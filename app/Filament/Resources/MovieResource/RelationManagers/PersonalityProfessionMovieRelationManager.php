<?php

namespace App\Filament\Resources\MovieResource\RelationManagers;

use App\Filament\Resources\MoviePersonalityProfessionResource;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MoviePersonalityProfessionRelationManager extends RelationManager
{
    protected static string $relationship = 'moviesPersonalitiesProfessions';

    protected static ?string $recordTitleAttribute = 'id';

    public static function form(Form $form): Form
    {
        return MoviePersonalityProfessionResource::form($form);
    }

    public static function table(Table $table): Table
    {
        return MoviePersonalityProfessionResource::table($table);
    }
}
