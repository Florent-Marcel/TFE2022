<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MoviePersonalityProfessionResource\Pages;
use App\Filament\Resources\MoviePersonalityProfessionResource\RelationManagers;
use App\Filament\Resources\MoviePersonalityProfessionResource\RelationManagers\MovieRelationManager;
use App\Models\MoviePersonalityProfession;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MoviePersonalityProfessionResource extends Resource
{
    protected static ?string $model = MoviePersonalityProfession::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('movie_id')->relationship('movie', 'title_en')->required(),
                Select::make('profession_id')->relationship('profession', 'profession')->required(),
                Select::make('personality_id')->relationship('personality', 'name')->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('movie.title_en')->sortable()->searchable(),
                TextColumn::make('profession.profession')->sortable()->searchable(),
                TextColumn::make('personality.name')->sortable()->searchable(),
            ])
            ->filters([
                SelectFilter::make('movie')->relationship('movie', 'title_en'),
                SelectFilter::make('profession')->relationship('profession', 'profession'),
                SelectFilter::make('personality')->relationship('personality', 'name'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\MovieRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMoviePersonalityProfessions::route('/'),
            'create' => Pages\CreateMoviePersonalityProfession::route('/create'),
            'edit' => Pages\EditMoviePersonalityProfession::route('/{record}/edit'),
        ];
    }
}
