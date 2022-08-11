<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PersonalityResource\Pages;
use App\Filament\Resources\PersonalityResource\RelationManagers;
use App\Models\Personality;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PersonalityResource extends Resource
{
    protected static ?string $model = Personality::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')->unique(ignoreRecord: true)->required(),
                TextInput::make('tmdb_id')->numeric()->unique(ignoreRecord: true)->required(),
                TextInput::make('profile_url')->url()->maxLength(512),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('profile_url')->label('Photo'),
                TextColumn::make('name')->sortable()->searchable(),
                TextColumn::make('tmdb_id')->sortable()->searchable(),
                TextColumn::make('movies_count')->counts('movies')->sortable(),
                TextColumn::make('professions_count')->counts('professions')->sortable(),
            ])
            ->filters([
                SelectFilter::make('movie')->relationship('movies', 'title'),
                SelectFilter::make('profession')->relationship('professions', 'profession'),
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
            RelationManagers\PersonalitiesProfessionsMoviesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPersonalities::route('/'),
            'create' => Pages\CreatePersonality::route('/create'),
            'edit' => Pages\EditPersonality::route('/{record}/edit'),
        ];
    }
}
