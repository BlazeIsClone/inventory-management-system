<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\MaterialInventoryOverview;
use App\Models\FinishProduct;
use App\Models\PurchaseBill;
use Filament\Pages\Page;
use App\Models\RawProduct;
use App\Models\SalesInvoice;
use Carbon\Carbon;
use Filament\Tables;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Concerns\InteractsWithTable;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class MaterialInventory extends Page implements HasTable
{
    use InteractsWithTable;

    protected static ?string $navigationIcon = 'heroicon-o-archive';

    protected static ?string $navigationGroup = 'Records';

    protected static ?string $title = 'Material Inventory';

    protected static string $view = 'filament.pages.material-inventory';

    protected static ?int $navigationSort = 2;

    private $purchasedQuantity = 0;

    private $usedQuantity = 0;

    private $balanceQuantity = 0;

    private $averageCost = 0;


    protected function getTableQuery(): Builder
    {
        return RawProduct::query();
    }

    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('name')
                ->label('Name')
                ->searchable(),
            Tables\Columns\TextColumn::make('purchased_quantity')
                ->label('Purchased Qty')
                ->getStateUsing(function (Model $record) {
                    $purchasedQuantity = 0;

                    $purchaseBills = PurchaseBill::all()->where(
                        'purchase_date',
                        '>=',
                        Carbon::now()->startOfMonth()->toDateString()
                    );

                    foreach ($purchaseBills as $purchaseBill) {
                        foreach ($purchaseBill->purchaseBillRawProducts as $pivot) {
                            if ($record->id === $pivot->raw_product_id) {
                                $purchasedQuantity = $pivot->product_quantity;
                            }
                        }
                    }

                    $this->purchasedQuantity = $purchasedQuantity;

                    return $purchasedQuantity;
                }),
            Tables\Columns\TextColumn::make('used_quantity')
                ->label('Used Qty')
                ->getStateUsing(function (Model $record) {
                    $usedQuantity = 0;
                    $finishProductQuantity = 0;

                    $finishProducts = FinishProduct::all()->where(
                        'created_at',
                        '>=',
                        Carbon::now()->startOfMonth()->toDateString()
                    );

                    $salesInvoices = SalesInvoice::all()->where(
                        'date',
                        '>=',
                        Carbon::now()->startOfMonth()->toDateString()
                    );

                    foreach ($salesInvoices as $salesInvoice) {
                        foreach ($salesInvoice->finishProductSalesInvoice as $pivot) {
                            $finishProductQuantity = $pivot->finish_product_quantity;
                        };
                    }

                    foreach ($finishProducts as $finishProduct) {
                        foreach ($finishProduct->finishProductRawProducts as $pivot) {
                            if ($record->id === $pivot->raw_product_id) {
                                $usedQuantity = ($finishProductQuantity * $pivot->raw_product_quantity) - $this->purchasedQuantity;
                            }
                        }
                    }

                    $this->usedQuantity = $usedQuantity;

                    return $usedQuantity;
                }),
            Tables\Columns\TextColumn::make('balance')
                ->label('Balance Qty')
                ->getStateUsing(function () {
                    $balanceQuantity =  $this->purchasedQuantity - $this->usedQuantity;

                    $this->balanceQuantity = $balanceQuantity;

                    return $balanceQuantity;
                }),
            Tables\Columns\TextColumn::make('average_cost')
                ->label('Average Price')
                ->getStateUsing(function (Model $record) {
                    $averageCost = 0;
                    $rawProductPrices = [];

                    $purchaseBills = PurchaseBill::all()->where(
                        'purchase_date',
                        '>=',
                        Carbon::now()->startOfMonth()->toDateString()
                    );

                    foreach ($purchaseBills as $purchaseBill) {
                        foreach ($purchaseBill->purchaseBillRawProducts as $pivot) {
                            if ($record->id === $pivot->raw_product_id) {
                                $rawProductPrices[] = $pivot->product_price;
                            }
                        }
                    }

                    if ($rawProductPrices) {
                        $averageCost = array_sum($rawProductPrices) / count($rawProductPrices);
                    } else {
                        $averageCost = 0;
                    }

                    $this->averageCost = $averageCost;

                    return number_format($averageCost);
                }),
            Tables\Columns\TextColumn::make('stock_value')
                ->label('Stock Value')
                ->getStateUsing(function () {
                    return number_format($this->balanceQuantity * $this->averageCost);
                }),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            MaterialInventoryOverview::class,
        ];
    }
}
