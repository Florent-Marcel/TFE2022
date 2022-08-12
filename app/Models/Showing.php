<?php

namespace App\Models;

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

    public static function allWithMovie(){
        $showings = Showing::all();
        foreach($showings as &$show){
            $show->movie;
            unset($show);
        }
        return $showings;
    }

    public static function showWithSeats($idShow){
        $show = Showing::findOrFail($idShow);
        $show->tickets;
        $show->room;
        $show->movie;
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
}
