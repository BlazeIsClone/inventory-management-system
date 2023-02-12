<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RawProductResource\Pages;
use App\Filament\Widgets\RawProductOverview;
use App\Filament\Widgets\RawProductQuantityOverview;
use App\Filament\Widgets\TimestampsOverview;
use App\Models\RawProduct;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;

class RawProductResource extends Resource
{
    protected static ?string $model = RawProduct::class;

    protected static ?string $navigationIcon = 'heroicon-o-archive';

    protected static ?string $navigationGroup = 'Purchasing';

    protected static ?int $navigationSort = 5;

    protected static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Card::make()
                ->schema([
                    Forms\Components\TextInput::make('name')
                        ->unique(ignorable: fn ($record) => $record),
                    Forms\Components\Select::make('unit')
                        ->options([
                            'unit' => 'Unit',
                            'kg' => 'kg',
                            'l' => 'l',
                        ])->required(),
                ])
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('available_quantity'),
                Tables\Columns\TextColumn::make('unit')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListRawProducts::route('/'),
            'create' => Pages\CreateRawProduct::route('/create'),
            'edit' => Pages\EditRawProduct::route('/{record}/edit'),
        ];
    }

    public static function getWidgets(): array
    {
        return [
            RawProductOverview::class,
            RawProductQuantityOverview::class,
            TimestampsOverview::class,
        ];
    }
}
