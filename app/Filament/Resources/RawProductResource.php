<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RawProductResource\Pages;
use App\Filament\Resources\RawProductResource\RelationManagers;
use App\Models\RawProduct;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RawProductResource extends Resource
{
    protected static ?string $model = RawProduct::class;

    protected static ?string $navigationIcon = 'heroicon-o-archive';

    protected static ?string $navigationGroup = 'Purchasing';

    protected static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required(),
                Forms\Components\Select::make('unit')
                    ->options([
                        'kg ' => 'kilograms',
                        'g' => 'grams',
                        'l' => 'liters',
                        'ml' => 'milliliters',
                    ])->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('unit'),
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
}
