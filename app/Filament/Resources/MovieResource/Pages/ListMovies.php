<?php

namespace App\Filament\Resources\MovieResource\Pages;

use App\Filament\Resources\MovieResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMovies extends ListRecords
{
    protected static string $resource = MovieResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Actions\Action::make("ddd")->url(MovieResource::getUrl('search')),
        ];
    }

    public function test(): void
    {

    }
}
