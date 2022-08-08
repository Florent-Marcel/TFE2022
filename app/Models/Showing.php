<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Showing extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'begin', 'price', 'buffer', 'movie_id', 'showing_type_id', 'language_id', 'room_id' 
    ];

    public function showingType(){
        return $this->belongsTo(ShowingType::class);
    }

    public function language(){
        return $this->belongsTo(Language::class);
    }

    public function room(){
        return $this->belongsTo(Room::class);
    }

    public function tickets(){
        return $this->hasMany(Ticket::class);
    }

    public function movie(){
        return $this->belongsTo(Movie::class);
    }

    public static function allWithMovie(){
        $showings = Showing::all();
        foreach($showings as &$show){
            $show->movie;
            unset($show);
        }
        return $showings;
    }
}
