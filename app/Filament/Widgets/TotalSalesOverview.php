<?php

namespace App\Filament\Widgets;

use App\Models\SalesInvoice;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use Illuminate\Database\Eloquent\Model;

class TotalSalesOverview extends BaseWidget
{
    public ?Model $record = null;

    protected function getCards(): array
    {
        return [
            Card::make('Total Quantity Sold', 0)
                ->icon('heroicon-o-collection'),
            Card::make('Total Saels Amount', 0)
                ->icon('heroicon-o-collection'),
        ];
    }
}
