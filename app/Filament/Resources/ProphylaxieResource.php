<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProphylaxieResource\Pages;
use App\Filament\Resources\ProphylaxieResource\RelationManagers;
use App\Models\Prophylaxie;
use App\Models\Vaccin;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProphylaxieResource extends Resource
{
    protected static ?string $model = Vaccin::class;
    protected ?string $maxContentWidth = 'full';
    protected static ?string $navigationGroup = 'PARAMETRES';
    protected static ?string $navigationLabel = 'Elt de prophylaxie';

    protected static ?string $navigationIcon = 'heroicon-o-check';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('libvac')->label('VACCIN')
                    ->required()
                    ->maxLength(255)
                    ->columnSpan('full'),

                Forms\Components\MarkdownEditor::make('comvac')->label('DESCRIPTION')
                    ->columnSpan('full'),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('libvac')->label('LIBELLE')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Dernière MAJ')
                    ->datetime('d/m/Y')
                    ,
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
            'index' => Pages\ManageProphylaxies::route('/'),
        ];
    }
}
