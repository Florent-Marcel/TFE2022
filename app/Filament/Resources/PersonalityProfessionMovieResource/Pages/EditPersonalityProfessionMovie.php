<?php

namespace App\Filament\Resources\PersonalityProfessionMovieResource\Pages;

use App\Filament\Resources\PersonalityProfessionMovieResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPersonalityProfessionMovie extends EditRecord
{
    protected static string $resource = PersonalityProfessionMovieResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
