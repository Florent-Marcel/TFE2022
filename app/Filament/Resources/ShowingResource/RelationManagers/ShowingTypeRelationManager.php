<?php

namespace App\Filament\Resources\ShowingResource\RelationManagers;

use App\Filament\Resources\ShowingTypeResource;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ShowingTypeRelationManager extends RelationManager
{
    protected static string $relationship = 'showingType';

    protected static ?string $recordTitleAttribute = 'id';

    public static function form(Form $form): Form
    {
        return ShowingTypeResource::form($form);
    }

    public static function table(Table $table): Table
    {
        return ShowingTypeResource::table($table);
    }
}
