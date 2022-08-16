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
        $movies = Movie::select('movies.*')->join('showings', 'showings.movie_id', '=', 'movies.id')
                ->with('types', 'showings')
                ->whereDate('showings.begin','>=', now('Europe/Brussels'))
                ->groupBy('movies.id')->has('showings', '>', 0)->get();

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

    public static function getMovieByID($id){
        $movie = Movie::where('id', '=', $id)
                ->with(['showings' => function($query) {
                    $query->where('begin', '>=', Carbon::now('Europe/Brussels'))
                    ->with('showingType', 'language')
                    ->with(['room' => function($query) {
                        $query->with('roomType');
                    }]);
                }])
                ->with('types')
                ->with(['personalitiesProfessionsMovies' => function($query) {
                    $query->with('personality', 'profession');
                }])->first();

        return $movie;
    }
}
