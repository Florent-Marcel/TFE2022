<?php
use Acaronlex\LaravelCalendar\Calendar;
use App\Http\Controllers\CalendarController;

$idRoom = "";

$calendar = new Calendar();
if (preg_match('/rooms\/(.*?)\/edit/', url()->current(), $match) == 1) {
    $idRoom = $match[1];
    $calendar = CalendarController::getForRoom($idRoom);
} else{
    $calendar = CalendarController::getAll();
}

?>


<x-filament::widget>
    <script>
    var selected = null
    var idRoom = "{{$idRoom}}"
    </script>
    <?php

    $calendar->setOptions([
        'locale' => 'en',
        'firstDay' => 0,
        'displayEventTime' => true,
        'selectable' => true,
        'initialView' => 'timeGridWeek',
        'headerToolbar' => [
            'left' => 'prev,next today myCustomButton',
            'center' => 'title',
            'right' => 'dayGridMonth,timeGridWeek,timeGridDay'
        ],
        'customButtons' => [
            'myCustomButton' => [
                'text'=> 'Create showing here',
                'click' => 'function() {
                    if(selected){
                        let begin = selected.startStr
                        begin = new Date(begin)
                        let year = begin.getFullYear()
                        let month = begin.getMonth() + 1
                        let day = begin.getDate()
                        let hour = begin.getHours()
                        let min = begin.getMinutes()
                        let base_url = window.location.origin;
                        window.location.href = `${base_url}/admin/showings/create?begin=${year}-${month}-${day}T${hour}:${min}&roomId=${idRoom}`
                    };
                }'
            ]
        ]
    ]);
    $calendar->setCallbacks([
        'select' => 'function(selectionInfo){
            selected = selectionInfo;
        }',
        'eventClick' => 'function(event){
            let base_url = window.location.origin;
            let id = event.event._def.publicId
            window.location.href  = `${base_url}/admin/showings/${id}/edit`
        }'
    ]);
    ?>


    <head>
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.5.0/main.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.5.0/locales-all.min.js"></script>

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.5.0/main.css"/>


        <style>
            .fc-event:hover{
                cursor: pointer;
            }
            .fc-event-main:hover{
                background-color: #5fb0ff;
            }
        </style>
    </head>


    <x-filament::card>
        {!! $calendar->calendar() !!}
        {!! $calendar->script() !!}
    </x-filament::card>
</x-filament::widget>
