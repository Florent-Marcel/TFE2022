<?php

namespace App\Filament\Resources\ProfessionResource\RelationManagers;

use App\Filament\Resources\PersonalityProfessionMovieResource;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PersonalitiesProfessionsMoviesRelationManager extends RelationManager
{
    protected static string $relationship = 'personalitiesProfessionsMovies';

    protected static ?string $recordTitleAttribute = 'id';

    public static function form(Form $form): Form
    {
        return PersonalityProfessionMovieResource::form($form);
    }

    public static function table(Table $table): Table
    {
        return PersonalityProfessionMovieResource::table($table);
    }
}
