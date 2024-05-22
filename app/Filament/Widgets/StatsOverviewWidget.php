<?php

namespace App\Filament\Widgets;

use Carbon\Carbon;
use Illuminate\Support\Number;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class StatsOverviewWidget extends BaseWidget
{

    use InteractsWithPageFilters;

    protected static ?int $sort = 0;
    protected function getStats(): array
    {
        $startDate = ! is_null($this->filters['startDate'] ?? null) ?
            Carbon::parse($this->filters['startDate']) :
            null;

        $endDate = ! is_null($this->filters['endDate'] ?? null) ?
            Carbon::parse($this->filters['endDate']) :
            now();

        $isBusinessCustomersOnly = $this->filters['zone_id'] ?? null;
        $businessCustomerMultiplier = match (true) {
            boolval($isBusinessCustomersOnly) => 2 / 3,
            blank($isBusinessCustomersOnly) => 1,
            default => 1 / 3,
        };

        $diffInDays = $startDate ? $startDate->diffInDays($endDate) : 0;

        $ponte = (int) (($startDate ? ($diffInDays * 137) : 192100) * $businessCustomerMultiplier);
        $casse = (int) (($startDate ? ($diffInDays * 7) : 1340) * $businessCustomerMultiplier);
        $mort = (int) (($startDate ? ($diffInDays * 13) : 3543) * $businessCustomerMultiplier);

        /* $formatNumber = function (int $number): string {
            if ($number < 1000) {
                return (string) Number::format($number, 0);
            }

            if ($number < 1000000) {
                return Number::format($number / 1000, 2) . 'k';
            }

            return Number::format($number / 1000000, 2) . 'm';
        };
 */
        return [
            Stat::make('TAUX DE PONTE', $ponte.' %')
                //->description('5% en augmentation')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('success'),
            Stat::make('TAUX DE CASSE', $casse.' %')
                //->description('3% en baisse')
                ->descriptionIcon('heroicon-m-arrow-trending-down')
                ->chart([17, 16, 14, 15, 14, 13, 12])
                ->color('danger'),
            Stat::make('TAUX DE MORTALITE', $mort.' %')
               // ->description('7% increase')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->chart([15, 4, 10, 2, 12, 4, 12])
                ->color('danger'),
        ];
    }
}
