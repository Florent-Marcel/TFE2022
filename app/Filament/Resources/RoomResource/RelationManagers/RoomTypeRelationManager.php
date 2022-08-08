<?php

namespace App\Filament\Resources\RoomResource\RelationManagers;

use App\Filament\Resources\RoomTypeResource;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RoomTypeRelationManager extends RelationManager
{
    protected static string $relationship = 'roomType';

    protected static ?string $recordTitleAttribute = 'id';

    public static function form(Form $form): Form
    {
        return RoomTypeResource::form($form);
    }

    public static function table(Table $table): Table
    {
        return RoomTypeResource::table($table);
    }
}
