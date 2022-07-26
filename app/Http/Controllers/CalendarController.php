<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Acaronlex\LaravelCalendar\Calendar;
use App\Models\Showing;
use Carbon\Carbon;

class CalendarController extends Controller
{
    /**
     * Create a calendar for a room
     * @param idRoom the id of the room
     */
    public static function getForRoom($idRoom){
        $calendar = new Calendar();
        $showings = Showing::getShowingsByIdRoom($idRoom);
        foreach ($showings as $show) {
            if(!$show->movie)
            {
                continue;
            }
            $begin = new Carbon($show->begin);
            $end = $begin->copy()->addMinutes($show->movie->duration);
            $calendar->addEvent(\Calendar::event(
                    $show->movie->title_en,
                    false,
                    $begin,
                    $end,
                	$show->id
                )
            );
        }

        return $calendar;
    }

    /**
     * Create a calendar for all rooms
     */
    public static function getAll(){
        $calendar = new Calendar();
        $showings = Showing::with('room')->get();
        foreach ($showings as $show) {
            if(!$show->movie)
            {
                continue;
            }
            $begin = new Carbon($show->begin);
            $end = $begin->copy()->addMinutes($show->movie->duration);
            $calendar->addEvent(\Calendar::event(
                    $show->movie->title_en." (Room: ".$show->room->num_room.")",
                    false,
                    $begin,
                    $end,
                	$show->id
                )
            );
        }

        return $calendar;
    }
}
