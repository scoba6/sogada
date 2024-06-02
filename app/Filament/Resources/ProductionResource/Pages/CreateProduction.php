<?php

namespace App\Filament\Resources\ProductionResource\Pages;

use App\Models\User;
use Filament\Actions;
use Filament\Forms\Form;
use App\Models\Production;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Section;
use Filament\Notifications\Notification;
use Filament\Forms\Components\Wizard\Step;
use Filament\Notifications\Actions\Action;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\ProductionResource;
use Filament\Resources\Pages\Concerns\HasWizard;

class CreateProduction extends CreateRecord
{
    use HasWizard;
    protected static string $resource = ProductionResource::class;

    public function form(Form $form): Form
    {
        return parent::form($form)
            ->schema([
                Wizard::make($this->getSteps())
                    ->startOnStep($this->getStartStep())
                    ->cancelAction($this->getCancelFormAction())
                    ->submitAction($this->getSubmitFormAction())
                    ->skippable($this->hasSkippableSteps())
                    ->contained(false),
            ])
            ->columns(null);
    }

    protected function afterCreate(): void
    {
        ///** @var Production $order */
        //$order = $this->record;

       // /** @var User $user */
       // $user = auth()->user();

       /*  Notification::make()
            ->title('Nouvelle production journalière')
            ->icon('heroicon-o-shopping-bag')
            ->body("**{$order->customer?->name} ordered {$order->items->count()} productions.**")
            ->actions([
                Action::make('View')
                    ->url(ProductionResource::getUrl('edit', ['record' => $order])),
            ])
            ->sendToDatabase($user); */
    }

    protected function getSteps(): array
    {
        return [
            Step::make('PRODUCTION JOURNALIERE')
                ->schema([
                    Section::make()->schema(ProductionResource::getDetailsFormSchema())->columns(),
                ]),

            Step::make('PLAN PROPHYLAXIQUE')
                ->schema([
                    Section::make()->schema([
                        ProductionResource::getItemsRepeater(),
                    ]),
                ]),

            Step::make('CONSOMMATION PRODUITS')
                ->schema([
                    Section::make()->schema([
                        ProductionResource::getItemsProduitRepeater(),
                    ]),
                ]),

        ];
    }





}
