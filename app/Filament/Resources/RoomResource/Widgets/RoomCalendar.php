<?php

namespace App\Filament\Resources\RoomResource\Widgets;

use Filament\Widgets\Widget;

class RoomCalendar extends Widget
{
    protected static string $view = 'filament.resources.room-resource.widgets.room-calendar';

    protected array|string|int $columnSpan = 2;
}
