<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
