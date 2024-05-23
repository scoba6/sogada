<?php

namespace App\Filament\Pages;

use App\Models\Zone;
use Filament\Forms\Get;
use Filament\Forms\Form;
use Filament\Pages\Page;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\DatePicker;
use BaseDashboard\Concerns\HasFiltersForm;
use Filament\Pages\Dashboard as BaseDashboard;


class Dashboard extends BaseDashboard
{

    use BaseDashboard\Concerns\HasFiltersForm;

    public function filtersForm(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->schema([
                    /*     Select::make('businessCustomersOnly')
                            ->boolean(), */
                        Select::make('zone_id')->options(Zone::all()->pluck('libzon', 'id'))
                            ->label('ZONE')
                            ->required(),
                        DatePicker::make('startDate')
                            ->default(now())
                            ->label('DEBUT')
                            ->maxDate(fn (Get $get) => $get('endDate') ?: now()),
                        DatePicker::make('endDate')
                            ->default(now())
                            ->label('FIN')
                            ->minDate(fn (Get $get) => $get('startDate') ?: now())
                            ->maxDate(now()),
                    ])
                    ->columns(3),
            ]);
    }


}
