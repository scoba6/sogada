<?php

namespace App\Filament\Resources\ProphylaxieResource\Pages;

use App\Filament\Resources\ProphylaxieResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageProphylaxies extends ManageRecords
{
    protected static string $resource = ProphylaxieResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
