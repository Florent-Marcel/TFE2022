<?php

namespace App\Filament\Resources\PersonalityResource\Pages;

use App\Filament\Resources\PersonalityResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPersonality extends EditRecord
{
    protected static string $resource = PersonalityResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
