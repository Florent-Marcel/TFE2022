<?php

namespace App\Filament\Resources\RoomResource\Pages;

use App\Filament\Resources\RoomResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRoom extends EditRecord
{
    protected static string $resource = RoomResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\Action::make("layout")->url(RoomResource::getUrl("layout", $this->getRecord()->id)),
        ];
    }
}
