<?php

namespace App\Filament\Resources\MoviePersonalityProfessionResource\RelationManagers;

use App\Filament\Resources\MovieResource;
use App\Models\Movie;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
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
        return $table
            ->columns([
                ImageColumn::make('poster_url')->label('Poster'),
                TextColumn::make('title_en')->searchable(),
                TextColumn::make('date_release')->searchable(),
                TextColumn::make('tmdb_id')->searchable(),
            ])
            ->filters([

            ])
            ->actions([

            ])
            ->bulkActions([

            ]);
    }
}
