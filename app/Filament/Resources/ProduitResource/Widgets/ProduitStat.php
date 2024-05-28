<?php

namespace App\Filament\Resources\ProduitResource\Widgets;

use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\Concerns\InteractsWithPageTable;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use App\Filament\Resources\ProduitResource\Pages\ListProduits;

class ProduitStat extends BaseWidget
{
    use InteractsWithPageTable;

    protected static ?string $pollingInterval = null;

    protected function getTablePage(): string
    {
        return ListProduits::class;
    }
    protected function getStats(): array
    {
        return [
            Stat::make('Total Produits', $this->getPageTableQuery()->count()),
            Stat::make('Inventaire Produit', $this->getPageTableQuery()->sum('vstock')),
            Stat::make('Stock moyen des Produits', number_format($this->getPageTableQuery()->avg('vstock'), 2)),
        ];
    }
}
