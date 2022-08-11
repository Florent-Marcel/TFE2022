<?php

namespace App\Filament\Resources\ShowingResource\RelationManagers;

use App\Filament\Resources\RoomResource;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RoomRelationManager extends RelationManager
{
    protected static string $relationship = 'room';

    protected static ?string $recordTitleAttribute = 'id';

    public static function form(Form $form): Form
    {
        return RoomResource::form($form);
    }

    public static function table(Table $table): Table
    {
        return RoomResource::table($table);
    }
}
