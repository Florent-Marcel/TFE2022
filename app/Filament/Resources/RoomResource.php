<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RoomResource\Pages;
use App\Filament\Resources\RoomResource\RelationManagers;
use App\Filament\Resources\RoomResource\Widgets\RoomCalendar;
use App\Models\Room;
use App\Models\RoomType;
use Filament\Forms;
use Filament\Forms\Components\Builder;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Schema;
use Filament\Forms\Components\ViewField;

class RoomResource extends Resource
{
    protected static ?string $model = Room::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('num_room')->required()->unique(ignoreRecord: true)->numeric(),
                Select::make('room_type_id')->required()->relationship('roomType', 'type'),
                TextInput::make('nb_rows')->required()->numeric()->minValue(1)->integer()->label('Number of row'),
                TextInput::make('max_places_row')->required()->numeric()->minValue(1)->label('Max places per row')->integer(),
                TextInput::make('nb_places')->numeric()->disabled()->integer(),
                TextInput::make('layout_json')->disabled(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('num_room')->searchable()->sortable(),
                TextColumn::make('nb_places')->searchable()->sortable(),
                TextColumn::make('RoomType.type')->searchable()->sortable(),
            ])
            ->filters([
                SelectFilter::make('type')->relationship('RoomType', 'type'),
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
            RelationManagers\RoomTypeRelationManager::class,
            RelationManagers\ShowingsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRooms::route('/'),
            'create' => Pages\CreateRoom::route('/create'),
            'edit' => Pages\EditRoom::route('/{record}/edit'),
            'layout' => Pages\EditLayout::route('/{record}/layout'),
        ];
    }

    public static function getWidgets(): array
    {
        return [
            RoomCalendar::class,
        ];
    }
}
