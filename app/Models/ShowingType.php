<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShowingType extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'type_fr', 'type_en', 'is_event',
    ];

    public function showings(){
        return $this->hasMany(Showing::class);
    }
}
