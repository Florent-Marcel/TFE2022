<?php

namespace App\Filament\Resources\MovieTypeResource\Pages;

use App\Filament\Resources\MovieTypeResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateMovieType extends CreateRecord
{
    protected static string $resource = MovieTypeResource::class;
}
