<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'num_room', 'nb_places', 'room_type_id', 'layout_json', 'nb_rows', 'max_places_row'
    ];

    public function roomType(){
        return $this->belongsTo(RoomType::class);
    }

    public function showings(){
        return $this->hasMany(Showing::class);
    }

    public static function generateJson($nbRows, $maxPlacesRow){
        $nbSeats = $nbRows * $maxPlacesRow;
        $res = [];
        for($i=1; $i<=$nbSeats; $i++){
            $res[$i] = ["activated" => true, "num_seat" =>$i];
        }
        return json_encode($res);
    }
}
