<?php

namespace App\Filament\Resources\ProduitResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\ProduitResource;
use Filament\Pages\Concerns\ExposesTableToWidgets;

class ListProduits extends ListRecords
{
    use ExposesTableToWidgets;

    protected static string $resource = ProduitResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return ProduitResource::getWidgets();
    }
}
