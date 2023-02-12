<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PurchaseBillResource\Pages;
use App\Models\PurchaseBill;
use App\Models\RawProduct;
use Closure;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Model;

class PurchaseBillResource extends Resource
{
    protected static ?string $model = PurchaseBill::class;

    protected static ?string $navigationIcon = 'heroicon-o-cash';

    protected static ?string $navigationGroup = 'Purchasing';

    protected static ?int $navigationSort = 7;

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
                        ->required()
                        ->default(now()),
                    Forms\Components\FileUpload::make('payment_bill'),
                    Forms\Components\Textarea::make('payment_bill_note'),

                ]),
                Forms\Components\Card::make([
                    Forms\Components\Repeater::make('purchaseBillRawProducts')
                        ->label('Raw Products')
                        ->disabledOn(Pages\EditPurchaseBill::class)
                        ->relationship()
                        ->defaultItems(1)
                        ->columns(6)
                        ->schema([
                            Forms\Components\Select::make('raw_product_id')
                                ->options(RawProduct::query()->pluck('name', 'id'))
                                ->required()
                                ->searchable()
                                ->columnSpan(2)
                                ->reactive()
                                ->afterStateUpdated(function (Closure $set, Closure $get, $state) {
                                    $set('product_total', $state * $get('product_price'));
                                }),
                            Forms\Components\TextInput::make('product_quantity')
                                ->required()
                                ->numeric()
                                ->minValue(1)
                                ->columnSpan(1)
                                ->reactive()
                                ->afterStateUpdated(function (Closure $set, Closure $get, $state) {
                                    $set('product_total', $state * $get('product_price'));
                                }),
                            Forms\Components\TextInput::make('product_price')
                                ->required()
                                ->numeric()
                                ->minValue(1)
                                ->columnSpan(2)
                                ->reactive()
                                ->afterStateUpdated(function (Closure $set, Closure $get, $state) {
                                    $set('product_total', $get('product_quantity') * $state);
                                }),
                            Forms\Components\TextInput::make('product_total')
                                ->disabled()
                                ->numeric()
                                ->dehydrated()
                                ->columnSpan(1),
                        ])
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('purchase_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('vendor.name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('sub_total')
                    ->getStateUsing(function (Model $record) {
                        $items = [];
                        foreach ($record->purchaseBillRawProducts as $purchaseBill) {
                            $items[] = $purchaseBill->product_price * $purchaseBill->product_quantity;
                        }
                        return array_sum($items);
                    }),
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
            //PurchaseBillResource\RelationManagers\RawProductsRelationManager::class,
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
