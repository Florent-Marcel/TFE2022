<?php

namespace App\Filament\Resources\TypeResource\RelationManagers;

use App\Filament\Resources\MovieTypeResource;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MovieTypesRelationManager extends RelationManager
{
    protected static string $relationship = 'movieTypes';

    protected static ?string $recordTitleAttribute = 'id';

    public static function form(Form $form): Form
    {
        return MovieTypeResource::form($form);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('movie.title_en')->searchable()->sortable(),
            ])
            ->filters([

            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
}
