<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'num_room', 'nb_places', 'room_type_id',
    ];

    public function roomType(){
        return $this->belongsTo(RoomType::class);
    }

    public function movies(){
        return $this->hasMany(Showing::class);
    }
}
