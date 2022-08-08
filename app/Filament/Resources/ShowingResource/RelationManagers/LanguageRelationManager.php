<?php

namespace App\Filament\Resources\ShowingResource\RelationManagers;

use App\Filament\Resources\LanguageResource;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LanguageRelationManager extends RelationManager
{
    protected static string $relationship = 'language';

    protected static ?string $recordTitleAttribute = 'id';

    public static function form(Form $form): Form
    {
        return LanguageResource::form($form);
    }

    public static function table(Table $table): Table
    {
        return LanguageResource::table($table);
    }
}
