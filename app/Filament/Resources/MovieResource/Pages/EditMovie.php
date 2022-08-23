<?php

namespace App\Filament\Resources\MovieResource\Pages;

use App\Filament\Resources\MovieResource;
use App\Models\Movie;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMovie extends EditRecord
{
    protected static string $resource = MovieResource::class;

    protected function getActions(): array
    {
        return [
            //Soft delete shows linked to the movie
            Actions\DeleteAction::make()
                ->before(function() {
                    $movie = Movie::findOrFail($this->data['id']);
                    foreach($movie->showings as $show){
                        $show->delete();
                    }
                }),
        ];
    }
}
