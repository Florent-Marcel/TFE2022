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
        'begin', 'price', 'movie_id', 'showing_type_id', 'language_id', 'room_id'
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

    /**
     * Get the upcoming showings
     * @param $events Boolean, true to get only the events, false to get only the basic showings.
     * @return array of showings
     */
    public static function currentShowings($events = false){
        $showings = Showing::where('begin', '>=', now('Europe/Brussels'))
                    ->join('showing_types', 'showings.showing_type_id', 'showing_types.id')
                    ->join('movies', 'showings.movie_id', 'movies.id')
                    ->join('rooms', 'showings.room_id', 'rooms.id')
                    ->join('room_types', 'rooms.room_type_id', 'room_types.id')
                    ->join('languages', 'showings.language_id', 'languages.id')
                    ->select('showings.*',
                    'type_fr', 'type_en', 'is_event', 'room_types.type AS type_room', 'room_types.id AS room_types_id',
                    'languages.language', 'movies.title_fr', 'movies.title_en')
                    ->where('is_event', $events)->get();
        return $showings;
    }

    /**
     * Get the showing with tickets, room, seats and language
     * @param $idShow the id of the showing
     * @return Showing the showing
     */
    public static function showWithSeats($idShow){
        $show = Showing::where('id', $idShow)
                ->with(['tickets' => function($query) {
                    $query->select('num_seat', 'id', 'showing_id')
                        ->where('is_blocked', false);
                }])
                ->with(['room' => function($query){
                    $query->with('roomType');
                }])
                ->with('movie', 'language')->first();

        return $show;
    }

    public static function isShowStillAvailable($idShow){
        $show = Showing::where('id', '=', $idShow)->select('begin')->first();
        $now = now('Europe/Brussels');
        return $show->begin > $now;
    }

    /**
     * Check if all seats in the array seats are still available
     * @param idShow The id of the showing
     * @param seats The array of num seats
     * @return Boolean true if all seats are available, else return false
     */
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

    /**
     * Check if all num seat in the given array $numSeats are present in the room layout
     * @param $idShow the id of the showing
     * @param $numSeats The array of num seats
     * @return Boolean true if all num seats are correct, else return false.
     */
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

    public static function getShowingsByIdRoom($idRoom){
        $showings = self::where("room_id", $idRoom)->with('movie')->get();

        return $showings;
    }
}
