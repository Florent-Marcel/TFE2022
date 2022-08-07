<?php

namespace App\Filament\Resources\MovieResource\Pages;

use App\Filament\Resources\MovieResource;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Pages\CreateRecord;
use Filament\Resources\Pages\Page;

class SearchMovie extends CreateRecord
{
    protected static string $resource = MovieResource::class;

    protected static string $view = 'filament.resources.movie-resource.pages.search-movie';
}
