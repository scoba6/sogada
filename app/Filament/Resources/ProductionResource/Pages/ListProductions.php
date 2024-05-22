<?php

namespace App\Filament\Resources\ProductionResource\Pages;

use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\ProductionResource;
use App\Models\Zone;

class ListProductions extends ListRecords
{
    protected static string $resource = ProductionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

     public function getTabs(): array
    {
        return [
            null => Tab::make('TOUS'),


            'ARTISANAL' => Tab::make()->query(fn ($query) => $query->where('zone_id', '2')),
            'INDUSTRIELLE' => Tab::make()->query(fn ($query) => $query->where('zone_id', '3')),
            'PRODUCTION' => Tab::make()->query(fn ($query) => $query->where('zone_id', '4')),

            /* Zone::valueOrFail('libzon')->all() => Tab::make()->query(fn ($query) => $query->where('zone_id', '2')),
            Zone::() => Tab::make()->query(fn ($query) => $query->where('zone_id', '2')),
            'delivered' => Tab::make()->query(fn ($query) => $query->where('status', 'delivered')),
            'cancelled' => Tab::make()->query(fn ($query) => $query->where('status', 'cancelled')), */
        ];
    }
}
