<?php

namespace App\Filament\Resources\TypeResource\Pages;

use App\Filament\Resources\TicketResource;
use App\Filament\Resources\TypeResource;
use App\Models\Type;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class ListTypes extends ListRecords
{
    protected static string $resource = TypeResource::class;

    protected function getFooterWidgets():  array{
        return TypeResource::getWidgets();
    }
}
