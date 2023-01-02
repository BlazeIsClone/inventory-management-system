<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PurchaseBillResource\Pages;
use App\Filament\Resources\PurchaseBillResource\RelationManagers;
use App\Models\PurchaseBill;
use App\Models\RawProduct;
use App\Models\Vendor;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PurchaseBillResource extends Resource
{
    protected static ?string $model = PurchaseBill::class;

    protected static ?string $navigationIcon = 'heroicon-o-cash';

    protected static ?string $navigationGroup = 'Purchasing';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('vendor_id')
                    ->relationship('vendor', 'name')
                    ->required(),
                Forms\Components\Select::make('raw_product_id')
                    ->label('Products')
                    ->relationship('rawProducts', 'name')
                    ->multiple()
                    ->preload()
                    ->searchable()
                    ->required(),
                Forms\Components\DatePicker::make('purchase_date')
                    ->required(),
                Forms\Components\TextInput::make('price')
                    ->numeric()
                    ->required(),
                Forms\Components\FileUpload::make('payment_bill'),
                Forms\Components\Textarea::make('payment_bill_note'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('purchase_date'),
                Tables\Columns\TextColumn::make('price'),
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
            'index' => Pages\ListPurchaseBills::route('/'),
            'create' => Pages\CreatePurchaseBill::route('/create'),
            'edit' => Pages\EditPurchaseBill::route('/{record}/edit'),
        ];
    }
}
