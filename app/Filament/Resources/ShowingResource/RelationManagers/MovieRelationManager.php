<?php

namespace App\Filament\Resources\ShowingResource\RelationManagers;

use App\Filament\Resources\MovieResource;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MovieRelationManager extends RelationManager
{
    protected static string $relationship = 'movie';

    protected static ?string $recordTitleAttribute = 'id';

    public static function form(Form $form): Form
    {
        return MovieResource::form($form);
    }

    public static function table(Table $table): Table
    {
        return MovieResource::table($table);
    }
}
