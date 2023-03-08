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
                        'created_at',
                        '>=',
                        Carbon::now()->subMonth()->endOfMonth()->toDateString()
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

                    $finishProducts = FinishProduct::all()->where(
                        'created_at',
                        '>=',
                        Carbon::now()->subMonth()->endOfMonth()->toDateString()
                    );

                    $salesInvoices = SalesInvoice::all()->where(
                        'created_at',
                        '>=',
                        Carbon::now()->subMonth()->endOfMonth()->toDateString()
                    );

                    $finishProductQuantity = 0;

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
                ->getStateUsing(function (Model $record) {
                    return $this->purchasedQuantity - $this->usedQuantity;
                }),
            Tables\Columns\TextColumn::make('average_cost')
                ->label('Average Cost'),
            Tables\Columns\TextColumn::make('stock_value')
                ->label('Stock Value'),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            MaterialInventoryOverview::class,
        ];
    }
}
