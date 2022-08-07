<?php

namespace App\Models;

use App\Mail\OrderShipped;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use GuzzleHttp;
use Illuminate\Support\Facades\Http;

class Movie extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'tmdb_id', 'title', 'synopsis', 'date_release', 'duration', 'rating', 'poster_url'
    ];

    private static $TMDB_API_KEY = "24cfeb5948080c6e86dd4fcb22c877f1";

    private static $TMDB_BASE_URL = "https://api.themoviedb.org/3";

    private static $TMDB_IMG_BASE_URL = "https://image.tmdb.org/t/p/w300";

    public function types(){
        return $this->belongsToMany(Type::class, MovieType::class);
    }

    public function personalitiesProfessionsMovies(){
        return $this->hasMany(PersonalityProfessionMovie::class);
    }

    public function showings(){
        return $this->hasMany(Showing::class);
    }

    public static function allWithShowings(){
        //Mail::to(auth()->user())->send(new OrderShipped());
        $movies = Movie::all();
        foreach($movies as &$movie){
            $showings = $movie->showings;
            $types = $movie->types;
            $movie->date_showings = $showings;
            $movie->types = $types;
            unset($movie, $showings, $types);
        }
        return $movies;
    }

    public static function tmdbSearch($title, $year){
        $url = self::$TMDB_BASE_URL."/search/movie?api_key=24cfeb5948080c6e86dd4fcb22c877f1&query=".$title."&year=".$year;

        $response = Http::get($url);

        return $response->json();
    }

    public static function tmdbGetByID($tmdbID){
        $url = self::$TMDB_BASE_URL."/movie/$tmdbID?api_key=24cfeb5948080c6e86dd4fcb22c877f1";
        $response = Http::get($url);
        $en = $response->json();
        if(isset($en['poster_path']) && $en['poster_path']){
            $en['poster_url'] = self::$TMDB_IMG_BASE_URL.$en['poster_path'];
        }

        $url = self::$TMDB_BASE_URL."/movie/$tmdbID?api_key=24cfeb5948080c6e86dd4fcb22c877f1&language=fr-BE";
        $response = Http::get($url);
        $fr=$response->json();
        if(isset($fr['poster_path']) && $fr['poster_path']){
            $fr['poster_url'] = self::$TMDB_IMG_BASE_URL.$fr['poster_path'];
        }

        return ['en' => $en, 'fr' => $fr];
    }

    public static function getCredids($tmdbID){
        $url = self::$TMDB_BASE_URL."/movie/$tmdbID/credits?api_key=24cfeb5948080c6e86dd4fcb22c877f1";
        $response = Http::get($url);
        $response = $response->json();

        return $response;
    }

    public static function createFromTMDB($tmdbData){
        if(isset($tmdbData['en'], $tmdbData['en']['title'])){
            return self::create([
                'title' => $tmdbData['en']['title'],
                'date_release' => $tmdbData['en']['release_date'],
                'duration' => $tmdbData['en']['runtime'],
                'rating' => isset($tmdbData['en']['vote_average']) ? $tmdbData['en']['vote_average'] : "",
                'synopsis' => $tmdbData['en']['overview'],
                'tmdb_id' => $tmdbData['en']['id'],
                'poster_url' => isset($tmdbData['en']['poster_url']) ? $tmdbData['en']['poster_url'] : "",
            ]);
        }

        return null;
    }
}
