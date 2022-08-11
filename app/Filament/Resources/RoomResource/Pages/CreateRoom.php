<?php

namespace App\Filament\Resources\RoomResource\Pages;

use App\Filament\Resources\RoomResource;
use App\Models\Movie;
use App\Models\Room;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateRoom extends CreateRecord
{
    protected static string $resource = RoomResource::class;

    protected function handleRecordCreation(array $data): Room
    {
        $data['layout_json'] = Room::generateJson($data['nb_rows'], $data['max_places_row']);
        $data['nb_places'] = substr_count($data['layout_json'], "true");

        $room = static::getModel()::create($data);

        return $room;
    }
}
