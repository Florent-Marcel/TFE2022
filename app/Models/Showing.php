<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Showing extends Model
{
    use HasFactory;

    protected $fillable = [
        'begin', 'price', 'buffer'
    ];

    public function showingType(){
        return $this->hasOne(ShowingType::class);
    }

    public function language(){
        return $this->hasOne(Language::class);
    }

    public function room(){
        return $this->hasOne(Room::class);
    }

    public function tickets(){
        return $this->hasMany(Ticket::class);
    }
}
