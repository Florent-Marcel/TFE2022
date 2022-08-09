<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

use App\Models\Type;
use Filament\Widgets\DoughnutChartWidget;
use Filament\Widgets\PieChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Illuminate\Support\Facades\DB;

class TypesChart extends PieChartWidget
{
    protected static ?string $heading = 'Tickets per type';

    protected function getData(): array
    {
        $data = Type::query()->join('movies_types', 'movies_types.type_id', '=', 'types.id')
        ->join('movies', 'movies.id', '=', 'movies_types.movie_id')
        ->join('showings', 'showings.movie_id', '=', 'movies.id')
        ->join('tickets', 'tickets.showing_id', '=', 'showings.id')
        ->select('types.id', 'types.type as type_type', DB::raw('count(tickets.id) as tickets_count'))
        ->groupBy('types.id')
        ->orderBy('tickets_count')
        ->limit(7)
        ->get();
        
        return [
            'datasets' => [
                [
                    'label' => 'Tickets',
                    'data' => $data->map(fn (Type $value) => $value->tickets_count),
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
            'labels' => $data->map(fn (Type $value) => $value->type_type),
            
        ];
    }
}
