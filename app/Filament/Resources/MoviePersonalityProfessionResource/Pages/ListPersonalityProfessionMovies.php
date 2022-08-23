<?php

namespace App\Filament\Resources\MoviePersonalityProfessionResource\Pages;

use App\Filament\Resources\MoviePersonalityProfessionResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMoviePersonalityProfessions extends ListRecords
{
    protected static string $resource = MoviePersonalityProfessionResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
