<?php

namespace App\Filament\Resources\ShowingResource\Pages;

use App\Filament\Resources\ShowingResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditShowing extends EditRecord
{
    protected static string $resource = ShowingResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
