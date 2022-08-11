<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\Pivot;

class MovieType extends Model
{
    protected $table = 'movies_types';

    protected $fillable = [
        'movie_id', 'type_id'
    ];

    public $timestamps = false;

    public function movie(){
        return $this->belongsTo(Movie::class);
    }

    public function type(){
        return $this->belongsTo(Type::class);
    }
}

