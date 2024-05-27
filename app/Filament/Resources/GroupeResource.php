<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GroupeResource\Pages;
use App\Filament\Resources\GroupeResource\RelationManagers;
use App\Models\Groupe;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class GroupeResource extends Resource
{
    protected static ?string $model = Groupe::class;
    protected ?string $maxContentWidth = 'full';
    protected static ?string $navigationGroup = 'GESTION DES STOCKS';
    protected static ?int $navigationSort = 1;
    protected static ?string $navigationLabel = 'Groupes';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-group';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('libgrp')->columnSpan('full')
                ->required()
                ->maxLength(100)
                ->label('GROUPE'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('libgrp')
                ->searchable()
                ->label('GROUPE')
            ])
            ->filters([
                //
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageGroupes::route('/'),
        ];
    }
}
