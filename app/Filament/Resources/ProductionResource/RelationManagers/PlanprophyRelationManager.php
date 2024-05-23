<?php

namespace App\Filament\Resources\ProductionResource\RelationManagers;

use App\Models\Prophylaxie;
use App\Models\Vaccin;
use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Repeater;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;

class PlanprophyRelationManager extends RelationManager
{
    protected static string $relationship = 'planpro';
    protected static ?string $title = 'PLAN PROPHYLAXIQUE';


    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Repeater::make('planpro')->label('PLAN PROPHYLAXIQUE')
                    ->schema([
                        Select::make('vaccin_id')->label('Elt de Prophyalaxie')->required()->options(Vaccin::all()->pluck('libvac', 'id')),
                        Forms\Components\TextInput::make('dosepr')->label('DOSE')
                            ->required()
                            ->numeric(),
                    ])
                    ->addable(false)
                    //->addActionLabel('Ajour un plan')
                    ->deletable(false)
                    //->defaultItems(4)
                    ->columns(2)
                    //->grid(2)
                    ->columnSpan([
                        'md' => 2
                    ]),

            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('dosepr')
            ->columns([
                Tables\Columns\TextColumn::make('dosepr'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
