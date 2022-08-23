<?php

namespace App\Filament\Resources\MoviePersonalityProfessionResource\Pages;

use App\Filament\Resources\MoviePersonalityProfessionResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMoviePersonalityProfession extends EditRecord
{
    protected static string $resource = MoviePersonalityProfessionResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
