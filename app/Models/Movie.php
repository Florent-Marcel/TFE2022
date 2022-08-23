<?php

namespace App\Models;

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

    public function moviesPersonalitiesProfessions(){
        return $this->hasMany(MoviePersonalityProfession::class);
    }

    public function showings(){
        return $this->hasMany(Showing::class);
    }

    /**
     * Get the movies that have at least one upcoming showing.
     */
    public static function currentMovies(){
        $movies = Movie::select('movies.*')
                ->with('types')
                ->with(['showings' => function($query) {
                    $query->where('begin', '>=', now('Europe/Brussels'));
                }])
                ->groupBy('movies.id')->whereHas('showings', function($query) {
                    $query->where('begin', '>=', now('Europe/Brussels'));
                })->get();

        return $movies;
    }

    /**
     * Get the current most popular movies
     * @param $limit The number of movies to get
     * @return array The list of the most popular movies
     */
    public static function currentMoviesPopular($limit=5){
        $movies = Movie::selectRaw('movies.*, count(tickets.id) AS tickets_count')->join('showings', 'movies.id', 'showings.movie_id')
                ->join('tickets', 'showings.id', 'tickets.showing_id')
                ->with('showings')
                ->groupBy('movies.id')->whereHas('showings', function($query) {
                    $query->where('begin', '>=', now('Europe/Brussels'));
                })
                ->orderBy('tickets_count', 'desc')->limit($limit)
                ->get();

        return $movies;
    }

    /**
     * Get the current most rated movies
     * @param $limit The number of movies to get
     * @return array The list of the most rated movies
     */
    public static function currentMoviesRated($limit=5){
        $movies = Movie::select('movies.*')
                ->with('showings')
                ->groupBy('movies.id')->whereHas('showings', function($query) {
                    $query->where('begin', '>=', now('Europe/Brussels'));
                })
                ->orderBy('rating', 'desc')->limit($limit)
                ->get();

        return $movies;
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

    /**
     * Get the movie by ID
     * @param $id The id of the movie to get
     * @return Movie The movie found with the given ID
     */
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
                ->with(['moviesPersonalitiesProfessions' => function($query) {
                    $query->with('personality', 'profession');
                }])->first();

        return $movie;
    }
}
