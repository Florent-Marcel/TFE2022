<?php

namespace App\Models;

use App\Mail\OrderShipped;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class Movie extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'synopsis', 'date_release', 'duration', 'rating'
    ];

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
}
