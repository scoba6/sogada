<?php

namespace App\Filament\Widgets;

use Carbon\Carbon;
use App\Models\Production;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Filament\Widgets\ChartWidget;

class ProdMensuelle extends ChartWidget
{
    protected static ?string $heading = 'PRODUCTION MENSUELLE';
    protected static ?int $sort = 2;

    public Carbon $fromDate;
    public Carbon $toDate;

    protected function getData(): array
    {
        $fromDate = $this->fromDate ??= now()->startOfYear(); //subWeek();
        $toDate = $this->toDate ??= now();

        $data = Trend::model(Production::class)
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
                    'label' => 'Evolution de la production mensuelle',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                    //'backgroundColor' => '#36A2EB',
                    //'borderColor' => '#9BD0F5',
                    'fill' => 'start'
                ],
            ],
            //'labels' => $data->map(fn (TrendValue $value) => $value->date),
            'labels' => ['Jan', 'Fev', 'Mar', 'Avr', 'Mai', 'Jun', 'Jul', 'Aou', 'Sep', 'Oct', 'Nov', 'Dec'],
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

}
