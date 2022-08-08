<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ShowingResource\Pages;
use App\Filament\Resources\ShowingResource\RelationManagers;
use App\Models\Room;
use App\Models\Showing;
use DateInterval;
use DateTime;
use Filament\Forms;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\DB;

class ShowingResource extends Resource
{
    protected static ?string $model = Showing::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                DateTimePicker::make('begin')->required(),
                TextInput::make('price')->numeric()->mask(fn (TextInput\Mask $mask) => $mask->money('€', ',', 2)),
                Select::make('movie_id')->relationship('movie', 'title')->required(),
                Select::make('showing_type_id')->relationship('showingtype', 'type')->required(),
                Select::make('language_id')->relationship('language', 'language')->required(),
                Select::make('room_id')->relationship('room', 'num_room_type', function ($query) {
                    return $query->join('room_types', 'rooms.room_type_id', '=', 'room_types.id')->select('rooms.id as id', 'num_room', DB::raw("CONCAT(num_room, ' (', type, ')') as num_room_type"));
                })->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('begin')->sortable()->getStateUsing(function(Showing $record){
                    $time = new DateTime($record->begin);
                    return $time->format('Y-m-d H:i');
                }),
                TextColumn::make('end')->getStateUsing(function(Showing $record){
                    $time = new DateTime($record->begin);
                    $time->add(new DateInterval('PT' . $record->movie->duration . 'M'));
                    return $time->format('Y-m-d H:i');
                }),
                TextColumn::make('price')->sortable(),
                TextColumn::make('movie.title')->searchable()->sortable(),
                TextColumn::make('showingtype.type')->sortable(),
                BooleanColumn::make('showingtype.is_event')->sortable()->label('event'),
                TextColumn::make('language.language')->sortable(),
                TextColumn::make('room.num_room')->sortable(),
                TextColumn::make('room.roomtype.type')->sortable()->label('Room type'),
            ])
            ->filters([
                SelectFilter::make('movie')->relationship('movie', 'title'),
                SelectFilter::make('room')->relationship('room', 'num_room'),
                Filter::make('created_at')
                    ->form([
                        Forms\Components\DatePicker::make('date'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['date'],
                                fn (Builder $query, $date): Builder => $query->whereDate('begin', '=', $date)
                            );
                        })
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
            RelationManagers\LanguageRelationManager::class,
            RelationManagers\ShowingTypeRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListShowings::route('/'),
            'create' => Pages\CreateShowing::route('/create'),
            'edit' => Pages\EditShowing::route('/{record}/edit'),
        ];
    }
}
