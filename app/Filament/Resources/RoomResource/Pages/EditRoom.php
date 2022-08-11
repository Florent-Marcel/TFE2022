<?php

namespace App\Filament\Resources\RoomResource\Pages;

use App\Filament\Resources\RoomResource;
use App\Models\Room;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRoom extends EditRecord
{
    protected static string $resource = RoomResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        if($this->record->nb_rows != $data['nb_rows'] || $this->record->max_places_row != $data['max_places_row']){
            $data['layout_json'] = Room::generateJson($data['nb_rows'], $data['max_places_row']);
            $data['nb_places'] = substr_count($data['layout_json'], "true");
        }

        return $data;
    }

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\Action::make("layout")->url(RoomResource::getUrl("layout", $this->getRecord()->id)),
        ];
    }
}
