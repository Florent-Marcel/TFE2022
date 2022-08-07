<?php

namespace App\Filament\Resources\MovieTypeResource\Pages;

use App\Filament\Resources\MovieTypeResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMovieTypes extends ListRecords
{
    protected static string $resource = MovieTypeResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
