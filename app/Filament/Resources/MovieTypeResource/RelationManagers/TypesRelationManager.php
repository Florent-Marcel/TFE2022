<?php

namespace App\Filament\Resources\MovieTypeResource\RelationManagers;

use App\Filament\Resources\TypeResource;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TypesRelationManager extends RelationManager
{
    protected static string $relationship = 'type';

    protected static ?string $recordTitleAttribute = 'id';

    public static function form(Form $form): Form
    {
        return TypeResource::form($form);
    }

    public static function table(Table $table): Table
    {
        return TypeResource::table($table);
    }
}
