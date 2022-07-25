<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class MovieType extends Pivot
{
    protected $table = 'movies_types';
}
