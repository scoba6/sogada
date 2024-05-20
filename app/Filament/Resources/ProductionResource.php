<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\Zone;
use Filament\Tables;
use App\Models\Batiment;
use Filament\Forms\Form;
use App\Models\Production;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ProductionResource\Pages;
use App\Filament\Resources\ProductionResource\RelationManagers;

class ProductionResource extends Resource
{
    protected static ?string $model = Production::class;

    protected ?string $maxContentWidth = 'full';
    protected static ?string $navigationGroup = 'PRODUCTION';
    protected static ?string $navigationLabel = 'Saisies journalières';

    protected static ?string $navigationIcon = 'heroicon-o-arrow-path-rounded-square';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                DatePicker::make('datprd')->label('DATE DE PRODUCTION')->displayFormat('d/m/Y')->required()->columnSpan('full'),
                Select::make('zone_id')->label('ZONE')->required()->options(Zone::all()->pluck('libzon', 'id'))->searchable(),
                Select::make('batiment_id')->label('BATIMENT')->required()->options(Batiment::all()->pluck('libbat', 'id'))->searchable(),
                TextInput::make('agepou')->label('AGE DES POULES')->numeric()->required(),
                TextInput::make('nbrpou')->label('NOMBRE DE POULES')->numeric()->required(),
                TextInput::make('prdjrn')->label('PRODUCTION JOURNALIERE')->numeric(),
                TextInput::make('nbrcrt')->label('NOMBRE DE CARTONS')->numeric()->required()->disabled(),
                TextInput::make('nbrcas')->label('OEUFS CASSES')->numeric()->required(),
                TextInput::make('nbrdcd')->label('POULES DCD ')->numeric()->required(),
                TextInput::make('cnsali')->label('CONSOMMATION ALIMENT')->numeric()->required(),
                TextInput::make('nbrsac')->label('NOMBRE DE SAC')->numeric()->required()->disabled(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('datprd')->sortable()->label('DATE DE PRODUCTION')->datetime('d/m/Y'),
                Tables\Columns\TextColumn::make('zone.libzon')->sortable()->label('ZONE')->searchable(),
                Tables\Columns\TextColumn::make('batiment.libbat')->sortable()->label('BATIMENT')->searchable(),
                Tables\Columns\TextColumn::make('agepou')->sortable()->label('AGE DES POULES'),
                Tables\Columns\TextColumn::make('nbrpou')->sortable()->label('NOMBRE DE POULES'),
                Tables\Columns\TextColumn::make('prdjrn')->sortable()->label('PRODUCTION JOURNALIERE'),
                Tables\Columns\TextColumn::make('nbrcrt')->sortable()->label('NOMBRE DE CARTONS'),
                Tables\Columns\TextColumn::make('nbrcas')->sortable()->label('OEUFS CASSES'),
                Tables\Columns\TextColumn::make('nbrdcd')->sortable()->label('POULES DCD'),
                Tables\Columns\TextColumn::make('cnsali')->sortable()->label('CONSOMMATION ALIMENT'),
                Tables\Columns\TextColumn::make('nbrsac')->sortable()->label('NOMBRE DE SAC'),
            ])
            ->filters([
                //Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProductions::route('/'),
            'create' => Pages\CreateProduction::route('/create'),
            'edit' => Pages\EditProduction::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
