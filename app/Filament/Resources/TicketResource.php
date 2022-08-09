<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TicketResource\Pages;
use App\Filament\Resources\TicketResource\RelationManagers;
use App\Filament\Widgets\TicketsChart;
use App\Models\Ticket;
use Faker\Provider\Uuid;
use Filament\Forms;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TicketResource extends Resource
{
    protected static ?string $model = Ticket::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('unique_code')->default(Uuid::uuid())->disabled()->required()->maxLength(512),
                Select::make('user_id')->relationship('user', 'email')->required(),
                Select::make('showing_id')->relationship('showing', 'begin')->required(),
                Toggle::make('is_used'),
                Toggle::make('is_blocked'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('unique_code')->searchable()->sortable(),
                TextColumn::make('user.email')->searchable()->sortable(),
                TextColumn::make('showing.begin')->searchable()->sortable()->label('Begin'),
                TextColumn::make('showing.movie.title')->searchable()->sortable()->label('Movie'),
                TextColumn::make('showing.room.num_room')->searchable()->sortable()->label('Num room'),
                BooleanColumn::make('is_used')->sortable()->label('Used'),
                BooleanColumn::make('is_blocked')->sortable()->label('Blocked'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\UserRelationManager::class,
            RelationManagers\ShowingRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTickets::route('/'),
            'create' => Pages\CreateTicket::route('/create'),
            'edit' => Pages\EditTicket::route('/{record}/edit'),
        ];
    }

    public static function getWidgets(): array
    {
        return [
            TicketsChart::class,
        ];
    }
}
