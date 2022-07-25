<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class PersonalityProfessionMovie extends Model
{
    use HasFactory;

    protected $table = "personalities_professions_movies";

    public function movies(){
        return $this->belongsToMany(Movie::class);
    }

    public function personalities(){
        return $this->belongsToMany(Personality::class);
    }

    public function professions(){
        return $this->belongsToMany(Profession::class);
    }
}
