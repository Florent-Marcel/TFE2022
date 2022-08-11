<?php

namespace App\Filament\Resources\ShowingTypeResource\RelationManagers;

use App\Filament\Resources\ShowingResource;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ShowingsRelationManager extends RelationManager
{
    protected static string $relationship = 'showings';

    protected static ?string $recordTitleAttribute = 'id';

    public static function form(Form $form): Form
    {
        return ShowingResource::form($form);
    }

    public static function table(Table $table): Table
    {
        return ShowingResource::table($table);
    }
}
