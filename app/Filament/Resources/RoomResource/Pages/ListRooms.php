<?php

namespace App\Filament\Resources\RoomResource\Pages;

use App\Filament\Resources\RoomResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRooms extends ListRecords
{
    protected static string $resource = RoomResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getDefaultTableSortColumn(): ?string
    {
        return 'num_room';
    }

    protected function getFooterWidgets(): array{
        return RoomResource::getWidgets();
    }
}
