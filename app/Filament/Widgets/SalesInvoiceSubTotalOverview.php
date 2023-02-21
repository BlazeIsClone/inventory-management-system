<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use Illuminate\Database\Eloquent\Model;

class SalesInvoiceSubTotalOverview extends BaseWidget
{
    public ?Model $record = null;

    protected function getCards(): array
    {
        $items = [];
        foreach ($this->record->finishProductSalesInvoice as $finishProduct) {
            $items[] = ($finishProduct->finish_product_price * $finishProduct->finish_product_quantity)
                - $this->record->discount;
        }

        return [
            Card::make('Sub Total', array_sum($items) ?: 0)
                ->icon('heroicon-o-cash'),
        ];
    }
}
