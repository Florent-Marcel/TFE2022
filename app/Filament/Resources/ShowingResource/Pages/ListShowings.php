<?php

namespace App\Filament\Resources\ShowingResource\Pages;

use App\Filament\Resources\ShowingResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListShowings extends ListRecords
{
    protected static string $resource = ShowingResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
