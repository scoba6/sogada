<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Produit;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\ProduitResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ProduitResource\RelationManagers;
use App\Filament\Resources\ProduitResource\RelationManagers\StockRelationManager;
use App\Filament\Resources\ProduitResource\Widgets\ProduitStat;
use App\Models\Groupe;
use App\Models\Prostock;

class ProduitResource extends Resource
{
    protected static ?string $model = Produit::class;
    protected ?string $maxContentWidth = 'full';
    protected static ?string $navigationGroup = 'GESTION DES STOCKS';
    protected static ?int $navigationSort = 3;
    protected static ?string $navigationLabel = 'Produits';

    protected static ?string $navigationIcon = 'heroicon-o-tag';


    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Forms\Components\Group::make()
                ->schema([
                    Forms\Components\Section::make()
                        ->schema([
                            Forms\Components\TextInput::make('libpro')->label('LIBELLE DU PRODUIT')
                                ->required()
                                ->maxLength(255)
                                ->columnSpan('full'),
                            Forms\Components\MarkdownEditor::make('despro')->label('DESCRIPTION')
                                ->columnSpan('full'),
                        ])
                        ->columns(2),

                    Forms\Components\Section::make('Images')
                        ->schema([
                            FileUpload::make('imgpro')
                                ->image()
                                ->hiddenLabel(),
                        ])
                        ->collapsible(),
                        Forms\Components\Section::make('Inventaire')
                        ->schema([
                            Forms\Components\TextInput::make('ugspro')
                                ->label('UGS (Unité de Gestion de Stock)')
                                ->unique(Produit::class, 'ugspro', ignoreRecord: true)
                                ->maxLength(255),

                            Forms\Components\TextInput::make('codbar')
                                ->label('CODE BARRE (UPC, EAN, etc.)')
                                ->unique(Produit::class, 'codbar', ignoreRecord: true)
                                ->maxLength(255),

                            Forms\Components\TextInput::make('seupro')->label('SEUIL')
                                //->helperText('The safety stock is the limit stock for your products which alerts you if the product stock will soon be out of stock.')
                                ->numeric()
                                ->minValue(1)
                                ->required(),
                            Forms\Components\TextInput::make('vstock')->label('VALEUR DU STOCK')
                                ->placeholder(
                                    function ($state, $record) {
                                        return Prostock::where('produit_id', $record->vstock)->get()->sum();
                                    }
                                )->disabled(),
                    ])->columns(2),

                ])
                ->columnSpan(['lg' => 2]),

            Forms\Components\Group::make()
                ->schema([
                    Forms\Components\Section::make('Associations')
                        ->schema([
                            Forms\Components\Toggle::make('statut')
                                ->label('Disponible')
                                ->default(true),
                            Forms\Components\Select::make('groupe_id')
                                ->relationship('groupe', 'libgrp')
                                ->required(),
                            Forms\Components\DatePicker::make('datval')
                                ->label('Date de valeur')
                                ->default(now())
                                ->required(),
                        ]),
                ])
                ->columnSpan(['lg' => 1]),
        ])
        ->columns(3);

    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('libpro')->searchable()->label('PRODUIT'),
                Tables\Columns\TextColumn::make('groupe.libgrp')->label('GROUPE'),
                Tables\Columns\TextColumn::make('ugspro')->label('UGS'),
                Tables\Columns\TextColumn::make('codbar')->label('CODE BARRE'),
                Tables\Columns\TextColumn::make('seupro')->label('SEUIL'),
                Tables\Columns\TextColumn::make('vstock')->label('VAL. STOCK'),
                Tables\Columns\IconColumn::make('statut')->boolean()->label('DISPONIBILITE'),
                Tables\Columns\TextColumn::make('datval')->label('DATE DE VALEUR')->datetime('d/m/Y'),

            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            StockRelationManager::class,
        ];
    }

    public static function getWidgets(): array
    {
        return [
            ProduitStat::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProduits::route('/'),
            'create' => Pages\CreateProduit::route('/create'),
            'edit' => Pages\EditProduit::route('/{record}/edit'),
        ];
    }
}
