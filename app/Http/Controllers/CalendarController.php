<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Acaronlex\LaravelCalendar\Calendar;
use App\Models\Showing;
use Carbon\Carbon;

class CalendarController extends Controller
{
    public static function getForRoom($idRoom){
        $calendar = new Calendar();
        $showings = Showing::getShowingsByIdRoom($idRoom);
        foreach ($showings as $show) {
            $begin = new Carbon($show->begin);
            $end = $begin->addMinutes($show->movie->duration);
            $calendar->addEvent(\Calendar::event(
                    $show->movie->title_en,
                    false,
                    $begin,
                    $begin->addMinutes($show->movie->duration),
                	$show->id
                )
            );
        }

        return $calendar;
    }

    public static function getAll(){
        $calendar = new Calendar();
        $showings = Showing::with('room')->get();
        foreach ($showings as $show) {
            $begin = new Carbon($show->begin);
            $end = $begin->addMinutes($show->movie->duration);
            $calendar->addEvent(\Calendar::event(
                    $show->movie->title_en." (Room: ".$show->room->num_room.")",
                    false,
                    $begin,
                    $begin->addMinutes($show->movie->duration),
                	$show->id
                )
            );
        }

        return $calendar;
    }
}
