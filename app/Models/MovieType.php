<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\Pivot;

class MovieType extends Pivot
{
    protected $table = 'movies_types';

    public function movie(){
        return $this->belongsTo(Movie::class);
    }

    public function type(){
        return $this->belongsTo(Type::class);
    }
}

