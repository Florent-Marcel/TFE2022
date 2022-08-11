<?php

namespace App\Filament\Resources\RoomResource\Pages;

use App\Filament\Resources\RoomResource;
use App\Models\Movie;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateRoom extends CreateRecord
{
    protected static string $resource = RoomResource::class;

    protected function handleRecordCreation(array $data): Movie
    {
        var_dump($data);
        return Movie::find(1);
    }
}
