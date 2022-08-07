<?php

namespace App\Filament\Resources\MovieTypeResource\Pages;

use App\Filament\Resources\MovieTypeResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMovieType extends EditRecord
{
    protected static string $resource = MovieTypeResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
