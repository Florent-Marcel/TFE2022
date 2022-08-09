<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

use App\Models\Ticket;
use App\Models\User;
use Filament\Widgets\BarChartWidget;
use Filament\Widgets\LineChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class TicketsChart extends LineChartWidget
{
    protected static ?string $heading = 'Tickets per month';

    protected function getData(): array
    {
        $data = Trend::model(Ticket::class)
            ->between(
                start: now()->startOfYear(),
                end: now(),
            )
            ->perMonth()
            ->count();
            
        return [
            'datasets' => [
                [
                    'label' => 'Tickets',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                    'backgroundColor' => [
                        '#0B84A5',
                        '#F6C85F',
                        '#6F4E7C',
                        '#9DD866',
                        '#CA472F',
                        '#FFA056',
                        '#8DDDD0',
                      ],
                    'hoverOffset'=> 4
                ],
            ],
            'labels' => $data->map(fn (TrendValue $value) => $value->date),
        ];
    }
}
