<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\User;
use App\Models\Zone;
use Filament\Tables;
use App\Models\Vaccin;
use Filament\Forms\Get;
use App\Models\Batiment;
use Filament\Forms\Form;
use App\Models\Production;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Actions\Action;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ProductionResource\Pages;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use App\Filament\Resources\ProductionResource\RelationManagers;
use Malzariey\FilamentDaterangepickerFilter\Filters\DateRangeFilter;

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
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make()
                            ->schema(static::getDetailsFormSchema())
                            ->columns(2),

                        Forms\Components\Section::make('PLAN PROPHYLAXIQUE')
                            ->headerActions([
                                Action::make('Reinitialiser')
                                    ->modalHeading('En êtes vous sûe?')
                                    ->modalDescription('Tous les plans seront réinitialisés.')
                                    ->requiresConfirmation()
                                    ->color('danger')
                                    ->action(fn (Forms\Set $set) => $set('items', [])),
                            ])
                            ->schema([
                                static::getItemsRepeater(),
                            ]),
                    ])
                    ->columnSpan(['lg' => fn (?Production $record) => $record === null ? 3 : 2]),

                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\Placeholder::make('created_at')
                        ->label('Saisi le')
                        ->content(fn (Production $record): ?string => $record->created_at?->diffForHumans()),

                    Forms\Components\Placeholder::make('created_by')
                        ->label('Par')
                        ->content(fn (Production $record): ?string => User::find($record->updated_by)?->name),

                    Forms\Components\Placeholder::make('updated_at')
                        ->label('Derniere Modification')
                        ->content(fn (Production $record): ?string => $record->updated_at?->diffForHumans()),

                    Forms\Components\Placeholder::make('updated_by')
                        ->label('Par')
                        ->content(fn (Production $record): ?string => User::find($record->updated_by)?->name),
                    ])
                    ->columnSpan(['lg' => 1])
                    ->hidden(fn (?Production $record) => $record === null),
            ])
            ->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('datprd')->sortable()->label('DATE DE PRODUCTION')
                    ->datetime('d/m/Y'),
                Tables\Columns\TextColumn::make('zone.libzon')->sortable()->label('ZONE')->searchable(),
                Tables\Columns\TextColumn::make('batiment.libbat')->sortable()->label('BATIMENT')->searchable(),
                Tables\Columns\TextColumn::make('agepou')->sortable()->label('AGE DES POULES'),
                Tables\Columns\TextColumn::make('nbrpou')->sortable()->label('NOMBRE DE POULES')
                    ->summarize([
                        Tables\Columns\Summarizers\Sum::make()
                    ]),
                Tables\Columns\TextColumn::make('prdjrn')->sortable()->label('PRODUCTION JOURNALIERE')
                    ->summarize([
                        Tables\Columns\Summarizers\Sum::make()
                    ]),
                Tables\Columns\TextColumn::make('nbrcrt')->sortable()->label('NOMBRE DE CARTONS')
                    ->summarize([
                        Tables\Columns\Summarizers\Sum::make()
                    ]),
                Tables\Columns\TextColumn::make('nbrcas')->sortable()->label('OEUFS CASSES')
                    ->summarize([
                        Tables\Columns\Summarizers\Sum::make()
                    ]),
                Tables\Columns\TextColumn::make('nbrdcd')->sortable()->label('POULES DCD')
                    ->summarize([
                        Tables\Columns\Summarizers\Sum::make()
                    ]),
                Tables\Columns\TextColumn::make('cnsali')->sortable()->label('CONSOMMATION ALIMENT')
                    ->summarize([
                        Tables\Columns\Summarizers\Sum::make()
                    ]),
                Tables\Columns\TextColumn::make('nbrsac')->sortable()->label('NOMBRE DE SAC')
                    ->summarize([
                        Tables\Columns\Summarizers\Sum::make()
                    ]),
            ])
            ->filters([
                //Tables\Filters\TrashedFilter::make(),
                //DateRangeFilter::make('created_at'),
                DateRangeFilter::make('datprd')->label('DATE DE PRODUCTION'),

            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                    ExportBulkAction::make()->label('Export XLS'),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
           // RelationManagers\PlanprophyRelationManager::class,
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

    public static function getDetailsFormSchema(): array
    {
        return [
            DatePicker::make('datprd')->label('DATE DE PRODUCTION')->displayFormat('d/m/Y')->required()->columnSpan('full')
                ->default(now())
                ->readOnly(true),
            Select::make('zone_id')->label('ZONE')->required()->options(Zone::all()->pluck('libzon', 'id'))->searchable(),
            Select::make('batiment_id')->label('BATIMENT')->required()->options(Batiment::all()->pluck('libbat', 'id'))->searchable(),
            TextInput::make('agepou')->label('AGE DES POULES')->numeric()->required()->minValue(1),
            TextInput::make('nbrpou')->label('NOMBRE DE POULES')->numeric()->required()->minValue(1),
            TextInput::make('prdjrn')->label('PRODUCTION JOURNALIERE')->integer()->minValue(1)
                ->numeric()
                ->reactive()
                ->required()
                ->afterStateUpdated(function (\Filament\Forms\Set $set, Get $get, $state) {
                    (int) $prdjrn = $get('prdjrn'); //Production journalière
                    (int) $nbtcrt = (int) $prdjrn/360; //Calcul du nombre de cartons
                    $set('nbrcrt', $nbtcrt); //Affection
                }),
            TextInput::make('nbrcrt')->label('NOMBRE DE CARTONS')->numeric()->readOnly(true),
            TextInput::make('nbrcas')->label('OEUFS CASSES')->numeric()->required(),
            TextInput::make('nbrdcd')->label('POULES DCD ')->numeric()->required(),
            TextInput::make('cnsali')->label('CONSOMMATION ALIMENT')
                ->minValue(1)
                ->numeric()
                ->required(),
            TextInput::make('nbrsac')->label('NOMBRE DE SAC')->numeric()->required(),
            Forms\Components\MarkdownEditor::make('notes')
                ->columnSpan('full'),
        ];
    }

    public static function getItemsRepeater(): Repeater
    {
        return Repeater::make('planpro')
            ->relationship()
            ->schema([
                Forms\Components\Select::make('vaccin_id')
                    ->label('Vaccin')
                    ->options(Vaccin::query()->pluck('libvac', 'id'))
                    ->required()
                    ->reactive()
                    ->distinct()
                    ->disableOptionsWhenSelectedInSiblingRepeaterItems()
                    ->searchable(),

                Forms\Components\TextInput::make('dosepr')
                    ->label('Dose')
                    ->numeric()
                    ->minValue(1)
                    ->default(1)
                    ->required(),
            ])
            ->defaultItems(4)
            ->deletable(false)
            ->addActionLabel('Ajouter un vaccin')
            ->hiddenLabel()
            ->grid(2)
            ->columns([
                'md' => 2,
            ])
            ->required();
    }
}
