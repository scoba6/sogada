<?php

namespace App\Filament\Widgets;

use Carbon\Carbon;
use App\Models\Stock;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Filament\Widgets\ChartWidget;

class StockMensuelle extends ChartWidget
{
    protected static ?string $heading = 'STOCK MENSUEL';
    protected static ?int $sort = 3;
    protected static ?string $maxHeight = '400px';

    public Carbon $fromDate;
    public Carbon $toDate;

    protected function getData(): array
    {
        $fromDate = $this->fromDate ??= now()->startOfYear(); //subWeek();
        $toDate = $this->toDate ??= now();

        $data = Trend::model(Stock::class)
        ->between(
            //start: now()->startOfYear(),
            //end: now()->endOfYear(),

            start: $fromDate,
            end: $toDate,
        )
        ->perMonth()
        ->count();

        return [
            'datasets' => [
                [
                    'label' => 'Suivi du stock mensuelle',
                    //'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                    'data' => [300, 50, 100],
                    'backgroundColor' => [
                        'rgb(255, 99, 132)',
                        'rgb(54, 162, 235)',
                        'rgb(255, 205, 86)'
                      ],
                      //'hoverOffset' => 4
                    //'backgroundColor' => '#36A2EB',
                    //'borderColor' => '#9BD0F5',
                    //'fill' => 'start'
                ],
            ],
            'labels' => ['Aliments', 'Prod vétérinaires', 'Alvéoles'],

        ];
    }

    protected function getType(): string
    {
        return 'pie';
    }
}
