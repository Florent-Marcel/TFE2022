<?php

namespace App\Models;

use App\Mail\OrderShipped;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use GuzzleHttp;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Http;

class Movie extends Model
{
    use HasFactory, SoftDeletes;

    public $timestamps = false;

    protected $fillable = [
        'tmdb_id', 'title_fr','title_en', 'synopsis_fr','synopsis_en', 'date_release', 'duration', 'rating', 'poster_url'
    ];

    private static $TMDB_API_KEY = "24cfeb5948080c6e86dd4fcb22c877f1";

    private static $TMDB_BASE_URL = "https://api.themoviedb.org/3";

    private static $TMDB_IMG_BASE_URL = "https://image.tmdb.org/t/p/w300";

    public function types(){
        return $this->belongsToMany(Type::class, MovieType::class);
    }

    public function movieTypes(){
        return $this->hasMany(MovieType::class);
    }

    public function personalitiesProfessionsMovies(){
        return $this->hasMany(PersonalityProfessionMovie::class);
    }

    public function showings(){
        return $this->hasMany(Showing::class);
    }

    public static function currentMovies(){
        $movies = Movie::select('movies.*')->join('showings', 'showings.movie_id', '=', 'movies.id')->whereDate('showings.begin','>=', now())->groupBy('movies.id')->get();
        $toRemove = [];
        foreach($movies as $key => &$movie){
            $movie->showings;
            if(count($movie->showings) == 0){
                array_push($toRemove, $key);
                continue;
            }
            $movie->types;
            unset($movie, $showings, $types);
        }
        foreach($toRemove as $rem){
            $movies->forget($rem);
        }
        return $movies->values();
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
                'title_en' => $tmdbData['en']['title'],
                'title_fr' => $tmdbData['fr']['title'],
                'date_release' => $tmdbData['en']['release_date'],
                'duration' => $tmdbData['en']['runtime'],
                'rating' => isset($tmdbData['en']['vote_average']) ? $tmdbData['en']['vote_average'] : "",
                'synopsis_fr' => $tmdbData['fr']['overview'],
                'synopsis_en' => $tmdbData['en']['overview'],
                'tmdb_id' => $tmdbData['en']['id'],
                'poster_url' => isset($tmdbData['en']['poster_url']) ? $tmdbData['en']['poster_url'] : "",
            ]);
        }
        return null;
    }

    public static function getMovieByID($id, $events=false){
        $movie = Movie::findOrFail($id);
        $toRemove = [];
        $movie->showings;

        foreach($movie->showings as $key => &$show){
            if($show->begin < Carbon::now()){
                array_push($toRemove, $key);
                continue;
            }
            $show->showingType;
            $show->language;
            $show->room->roomType;
        }
        unset($show);

        $movie->types;
        $movie->personalitiesProfessionsMovies;
        foreach($movie->personalitiesProfessionsMovies as &$perso){
            $perso->personality;
            $perso->profession;
        }
        unset($perso);

        foreach($toRemove as $rem){
            $movie->showings->forget($rem);
        }
        $showings = $movie->showings->values();

        $movie = $movie->toArray();
        $movie['showings'] = $showings;

        return $movie;
    }
}
