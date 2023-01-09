<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PurchaseBillResource\Pages;
use App\Models\PurchaseBill;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;

class PurchaseBillResource extends Resource
{
    protected static ?string $model = PurchaseBill::class;

    protected static ?string $navigationIcon = 'heroicon-o-cash';

    protected static ?string $navigationGroup = 'Purchasing';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make([
                    Forms\Components\Select::make('vendor_id')
                        ->relationship('vendor', 'name')
                        ->searchable()
                        ->preload()
                        ->required(),
                    Forms\Components\DatePicker::make('purchase_date')
                        ->required(),
                    Forms\Components\FileUpload::make('payment_bill'),
                    Forms\Components\Textarea::make('payment_bill_note'),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('purchase_date')
                    ->sortable(),
                Tables\Columns\TextColumn::make('vendor.name')
                    ->searchable(),
                Tables\Columns\TagsColumn::make('rawProducts.name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('sub_total')
                    ->sortable(),
            ])->defaultSort('purchase_date', 'desc')
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
            PurchaseBillResource\RelationManagers\RawProductsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPurchaseBills::route('/'),
            'create' => Pages\CreatePurchaseBill::route('/create'),
            'edit' => Pages\EditPurchaseBill::route('/{record}/edit'),
        ];
    }
}
