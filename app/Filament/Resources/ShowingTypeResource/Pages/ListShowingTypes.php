<?php

namespace App\Filament\Resources\ShowingTypeResource\Pages;

use App\Filament\Resources\ShowingTypeResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListShowingTypes extends ListRecords
{
    protected static string $resource = ShowingTypeResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
