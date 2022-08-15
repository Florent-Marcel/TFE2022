<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Showing extends Model
{
    use HasFactory, SoftDeletes;

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

    public function temporaryTickets(){
        return $this->hasMany(TemporaryTicket::class);
    }

    public static function currentShowings($events = false){
        $showings = Showing::whereDate('begin', '>=', now())->get();
        $toRemove = [];
        foreach($showings as $key => &$show){
            $show->showingType;
            if($events != $show->showingType->is_event){
                array_push($toRemove, $key);
                continue;
            }
            $show->movie->personalitiesProfessionsMovies;
            $show->room->roomType;
            $show->language;
            unset($show);
        }
        foreach($toRemove as $rem){
            $showings->forget($rem);
        }
        return $showings->values();
    }

    public static function showWithSeats($idShow){
        $show = Showing::findOrFail($idShow);
        $show->tickets;
        $show->room->roomType;
        $show->movie;
        $show->language;
        foreach($show->tickets as &$ticket){
            unset($ticket->unique_code);
            unset($ticket->user_id);
            unset($ticket->showing_id);
        }
        unset($ticket);

        return $show;
    }

    public static function seatsStillAvailable($idShow, $seats){
        $show = self::findOrFail($idShow);
        if(!is_array($seats) || count($seats) == 0){
            return false;
        }
        $show->tickets;
        foreach($show->tickets as $ticket){
            if(!$ticket->is_blocked){
                if(in_array($ticket->num_seat, $seats)){
                    return false;
                }
            }
        }
        $show->temporaryTickets;
        foreach($show->temporaryTickets as $ticket){
            if(!$ticket->is_blocked){
                if(in_array($ticket->num_seat, $seats)){
                    return false;
                }
            }
        }
        return true;
    }

    public static function isNumSeatsCorrect($idShow, $numSeats){
        $show = self::findOrFail($idShow);
        $room = $show->room;
        $layout = json_decode($room->layout_json);
        $count = 0;
        foreach($layout as $seat){
            if(isset($seat->num_seat) && in_array($seat->num_seat, $numSeats)){
                $count++;
            }
        }
        return $count == count($numSeats);
    }
}
