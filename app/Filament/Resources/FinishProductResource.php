<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FinishProductResource\Pages;
use App\Models\FinishProduct;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;

class FinishProductResource extends Resource
{
    protected static ?string $model = FinishProduct::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static ?string $navigationGroup = 'Production';

    protected static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->unique(ignorable: fn ($record) => $record),
                Forms\Components\Select::make('raw_materials'),
                Forms\Components\TextInput::make('labour_percentage')
                    ->numeric(),
                Forms\Components\TextInput::make('sales_price')
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->sortable(),
                Tables\Columns\TextColumn::make('sales_price')
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
            'index' => Pages\ListFinishProducts::route('/'),
            'create' => Pages\CreateFinishProduct::route('/create'),
            'edit' => Pages\EditFinishProduct::route('/{record}/edit'),
        ];
    }
}
