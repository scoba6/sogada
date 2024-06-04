<?php

namespace App\Filament\Resources\ProduitResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Get;
use App\Models\Prostock;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Facades\DB;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;

class StockRelationManager extends RelationManager
{
    protected static string $relationship = 'stock';


    public function form(Form $form): Form
    {
        return $form
            ->schema([
                DatePicker::make('datprd')->label('DATE APPRO')->displayFormat('d/m/Y')->required()
                    ->default(now())
                    ->readOnly(true),
                Forms\Components\TextInput::make('qteapp')->label('QUANTITE')
                    ->required()
                    ->numeric()
                    ->minValue(1)
                    ->afterStateUpdated(function (RelationManager $livewire, \Filament\Forms\Set $set, Get $get) {
                        $prd = $livewire->ownerRecord->id; //produit
                        $stoAjt = $get('qteapp'); // Stock approvisinné
                        $StoEnc = Prostock::where('produit_id','=',$prd)->get()->sum('qteapp'); // Stock en cours

                        $vstock = $stoAjt + $StoEnc; // Stock total du produit

                        //Maj de la valeur du stock du produit
                        DB::table('produits')
                            ->where('id', $prd)
                            ->update(['vstock' => $vstock]);

                        //dd($vstock);

                    }),
                Forms\Components\MarkdownEditor::make('desapp')->label('DESCRIPTION')
                    ->columnSpan('full'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('qteapp')
            ->columns([
                Tables\Columns\TextColumn::make('datapp')->label('DATE APPRO')->datetime('d/m/Y'),
                Tables\Columns\TextColumn::make('qteapp')->label('QTE APPRO'),
                Tables\Columns\IconColumn::make('statut')->boolean()->label('STATUT APPRO'),
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
