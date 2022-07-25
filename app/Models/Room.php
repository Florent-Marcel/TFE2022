<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'num_room', 'nb_places'
    ];

    public function roomType(){
        return $this->hasOne(RoomType::class);
    }

    public function movies(){
        return $this->hasMany(Showing::class);
    }
}
