<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MovieResource\Pages;
use App\Filament\Resources\MovieResource\RelationManagers;
use App\Filament\Resources\MovieResource\RelationManagers\MovieTypesRelationManager;
use App\Models\Movie;
use App\Models\Tmdb;
use App\Models\Type;
use Filament\Forms;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\MultiSelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MovieResource extends Resource
{
    protected static ?string $model = Movie::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static $timestamps = false;


    public static function form(Form $form): Form
    {
        //Type::createIfNotPresent([['id' => 500, 'name' => 'dsdsqs']]);
        if(isset($_GET['title'], $_GET['year'])){
            $data = Tmdb::search($_GET['title'], $_GET['year']);
            if(isset($data['results']) && count($data['results']) > 0){
                $data = $data['results'][0];
                $data = Tmdb::getByID($data['id']);
            } else{
                unset($data);
            }
        }

        return self::getFormWithTMDB($form, isset($data) ? $data : "");
    }

    public static function getFormWithTMDB(Form $form, $data): Form{
        return $form
            ->schema([
                TextInput::make('title_en')->default(isset($data['en']['title']) ? $data['en']['title'] : "")->required(),
                TextInput::make('title_fr')->default(isset($data['fr']['title']) ? $data['en']['title'] : "")->required(),
                DatePicker::make('date_release')->default(isset($data['en']['release_date']) ? $data['en']['release_date'] : "")->required(),
                TextInput::make('duration')->numeric()->default(isset($data['en']['runtime']) ? $data['en']['runtime'] : "")->required(),
                Textarea::make('synopsis_en')->default(isset($data['en']['overview']) ? $data['en']['overview'] : ""),
                Textarea::make('synopsis_fr')->default(isset($data['fr']['overview']) ? $data['en']['overview'] : ""),
                TextInput::make('rating')->numeric()->default(isset($data['en']['vote_average']) ? $data['en']['vote_average'] : ""),
                TextInput::make('tmdb_id')->numeric()->unique(ignoreRecord: true)->default(isset($data['en']['id']) ? $data['en']['id'] : "")->required(),
                TextInput::make('poster_url')->url()->default(isset($data['en']['poster_url']) ? $data['en']['poster_url'] : ""),
                Hidden::make('tmdb_data')->default(isset($data) ? json_encode($data) : ""),
            ]);
    }

    protected function getActions(): array
    {
        return [
            Action::make('settings')->color('secondary'),
        ];
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
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\MovieTypesRelationManager::class,
            RelationManagers\PersonalityProfessionMovieRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMovies::route('/'),
            'create' => Pages\CreateMovie::route('/create'),
            'edit' => Pages\EditMovie::route('/{record}/edit'),
            'search' => Pages\SearchMovie::route('/search'),
        ];
    }

    protected function handleRecordCreation(array $data): Movie
    {
        $data2 = [];
        $movie = static::getModel()::create($data2);

        return $movie;
    }
}
