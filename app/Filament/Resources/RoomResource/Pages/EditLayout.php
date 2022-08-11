<?php

namespace App\Filament\Resources\RoomResource\Pages;

use App\Filament\Resources\RoomResource;
use Filament\Resources\Pages\Page;

class EditLayout extends Page
{
    protected static string $resource = RoomResource::class;

    protected static string $view = 'filament.resources.room-resource.pages.edit-layout';
}
