<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MovieTypeResource\Pages;
use App\Filament\Resources\MovieTypeResource\RelationManagers;
use App\Models\Movie;
use App\Models\MovieType;
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

class MovieTypeResource extends Resource
{
    protected static ?string $model = MovieType::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('movie_id')
                    ->relationship('movie', 'title')
                    ->required(),
                Select::make('type_id')
                    ->relationship('type', 'type')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('movie.title')->searchable()->sortable(),
                TextColumn::make('type.type')->searchable()->sortable(),
            ])
            ->filters([
                SelectFilter::make('movie')->relationship('movie', 'title'),
                SelectFilter::make('type')->relationship('type', 'type'),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMovieTypes::route('/'),
            'create' => Pages\CreateMovieType::route('/create'),
            'edit' => Pages\EditMovieType::route('/{record}/edit'),
        ];
    }
}
