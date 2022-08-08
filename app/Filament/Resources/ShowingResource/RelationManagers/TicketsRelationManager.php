<?php

namespace App\Filament\Resources\ShowingResource\RelationManagers;

use App\Filament\Resources\TicketResource;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TicketsRelationManager extends RelationManager
{
    protected static string $relationship = 'tickets';

    protected static ?string $recordTitleAttribute = 'id';

    public static function form(Form $form): Form
    {
        return TicketResource::form($form);
    }

    public static function table(Table $table): Table
    {
        return TicketResource::table($table);
    }
}
