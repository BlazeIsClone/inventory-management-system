<?php

namespace App\Filament\Resources\PurchaseBillResource\RelationManagers;

use App\Models\PurchaseBill;
use Closure;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Actions\AttachAction;
use Filament\Tables\Actions\DetachAction;

class RawProductsRelationManager extends RelationManager
{
    protected static string $relationship = 'rawProducts';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('product_quantity')
                    ->required()
                    ->numeric()
                    ->minValue(1)
                    ->maxLength(255)
                    ->columnSpan(1)
                    ->reactive()
                    ->afterStateUpdated(function (Closure $set, Closure $get, $state) {
                        $set('product_total', $state * $get('product_price'));
                    }),
                Forms\Components\TextInput::make('product_price')
                    ->required()
                    ->numeric()
                    ->minValue(1)
                    ->maxLength(255)
                    ->columnSpan(3)
                    ->reactive()
                    ->afterStateUpdated(function (Closure $set, Closure $get, $state) {
                        $set('product_total', $get('product_quantity') * $state);
                    }),
                Forms\Components\TextInput::make('product_total')
                    ->disabled()
                    ->numeric()
                    ->maxLength(255)
                    ->columnSpan(2),

            ])->columns(6);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('product_quantity'),
                Tables\Columns\TextColumn::make('product_price'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\AttachAction::make()
                    ->form(fn (AttachAction $action): array => [
                        Forms\Components\Grid::make()
                            ->schema([
                                $action->preloadRecordSelect()
                                    ->getRecordSelect()
                                    ->columnSpan(6),
                                Forms\Components\TextInput::make('product_quantity')
                                    ->required()
                                    ->numeric()
                                    ->minValue(1)
                                    ->maxLength(255)
                                    ->columnSpan(2)
                                    ->reactive()
                                    ->afterStateUpdated(function (Closure $set, Closure $get, $state) {
                                        $set('product_total', $state * $get('product_price'));
                                    }),
                                Forms\Components\TextInput::make('product_price')
                                    ->required()
                                    ->numeric()
                                    ->minValue(1)
                                    ->maxLength(255)
                                    ->columnSpan(4)
                                    ->reactive()
                                    ->afterStateUpdated(function (Closure $set, Closure $get, $state) {
                                        $set('product_total', $get('product_quantity') * $state);
                                    }),
                                Forms\Components\TextInput::make('product_total')
                                    ->disabled()
                                    ->numeric()
                                    ->maxLength(255)
                                    ->columnSpan(6),
                            ])->columns(6)
                    ])->mutateFormDataUsing(function (array $data, RelationManager $livewire) {
                        $subTotal = 0;

                        $subTotal = $livewire->getOwnerRecord()->sub_total += $data['product_quantity'] * $data['product_price'];

                        $purchaseBill = PurchaseBill::find($livewire->getOwnerRecord()->id);
                        $purchaseBill->sub_total = $subTotal;
                        $purchaseBill->save();

                        return $data;
                    })
            ])
            ->actions([
                /** Tables\Actions\EditAction::make()
                    ->using(function (Model $record, array $data): Model {
                        $purchaseBill = PurchaseBill::find($record->pivot_purchase_bill_id);

                        if ($purchaseBill->sub_total < $data['product_quantity'] * $data['product_price']) {
                            $subTotal = $purchaseBill->sub_total += $data['product_quantity'] * $data['product_price'];
                        } else {
                            $subTotal = $purchaseBill->sub_total -= $data['product_quantity'] * $data['product_price'];
                        }

                        $purchaseBill->sub_total = $subTotal;
                        $purchaseBill->save();
                        $record->update($data);

                        return $record;
                    }), */
                Tables\Actions\DetachAction::make()->after(function (DetachAction $action) {
                    $purchaseBill = PurchaseBill::find($action->getRecord()->pivot_purchase_bill_id);
                    $purchaseBill->sub_total -= $action->getRecord()->product_quantity * $action->getRecord()->product_price;
                    $purchaseBill->save();
                })
            ])
            ->bulkActions([
                Tables\Actions\DetachBulkAction::make(),
            ]);
    }
}
