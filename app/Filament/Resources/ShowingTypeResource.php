<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ShowingTypeResource\Pages;
use App\Filament\Resources\ShowingTypeResource\RelationManagers;
use App\Models\ShowingType;
use Filament\Forms;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ShowingTypeResource extends Resource
{
    protected static ?string $model = ShowingType::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('type_fr')->unique(ignoreRecord: true)->required()->maxLength(64),
                TextInput::make('type_en')->unique(ignoreRecord: true)->required()->maxLength(64),
                Checkbox::make('is_event'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('type_en')->sortable()->searchable(),
                BooleanColumn::make('is_event')->sortable(),
            ])
            ->filters([
                Filter::make('is_event')
                    ->query(fn (Builder $query): Builder => $query->where('is_event', true)),
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
            RelationManagers\ShowingsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListShowingTypes::route('/'),
            'create' => Pages\CreateShowingType::route('/create'),
            'edit' => Pages\EditShowingType::route('/{record}/edit'),
        ];
    }
}
