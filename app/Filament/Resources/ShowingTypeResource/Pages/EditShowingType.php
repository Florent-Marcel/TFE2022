<?php

namespace App\Filament\Resources\ShowingTypeResource\Pages;

use App\Filament\Resources\ShowingTypeResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditShowingType extends EditRecord
{
    protected static string $resource = ShowingTypeResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
