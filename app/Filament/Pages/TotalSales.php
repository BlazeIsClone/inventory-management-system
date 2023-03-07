<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\TotalSalesOverview;
use App\Models\FinishProduct;
use Filament\Pages\Page;
use App\Models\SalesInvoice;
use Filament\Tables;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Concerns\InteractsWithTable;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class TotalSales extends Page implements HasTable
{
    use InteractsWithTable;

    protected static ?string $navigationIcon = 'heroicon-o-credit-card';

    protected static ?string $navigationGroup = 'Records';

    protected static ?string $title = 'Total Sales';

    protected static string $view = 'filament.pages.total-sales';

    protected static ?int $navigationSort = 0;

    protected function getTableQuery(): Builder
    {
        return FinishProduct::query();
    }

    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('name')
                ->label('Finish Product')
                ->searchable(),
            Tables\Columns\TextColumn::make('total_sold')
                ->label('Total Sold Qty')
                ->getStateUsing(function (Model $record) {
                    $finishProductsSold = 0;
                    $salesInvoices = SalesInvoice::all();
                    foreach ($salesInvoices as $salesInvoice) {
                        foreach ($salesInvoice->finishProductSalesInvoice as $pivot) {
                            if ($record->id === $pivot->finish_product_id) {
                                $finishProductsSold += $pivot->finish_product_quantity;
                            }
                        }
                    }
                    return $finishProductsSold;
                }),
            Tables\Columns\TextColumn::make('sales_amount')
                ->label('Sales Amount')
                ->getStateUsing(function (Model $record) {
                    $finishProductsSold = 0;
                    $salesInvoices = SalesInvoice::all();
                    foreach ($salesInvoices as $salesInvoice) {
                        foreach ($salesInvoice->finishProductSalesInvoice as $pivot) {
                            if ($record->id === $pivot->finish_product_id) {
                                $finishProductsSold += $pivot->finish_product_quantity * $pivot->finish_product_price;
                            }
                        }
                    }

                    return number_format($finishProductsSold);
                }),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            TotalSalesOverview::class,
        ];
    }
}
