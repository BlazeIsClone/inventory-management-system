<?php

namespace App\Filament\Widgets;

use App\Models\FinishProduct;
use App\Models\RawProduct;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;


class RawProductOverview extends BaseWidget
{
    protected function getCards(): array
    {
        return [
            Card::make('Raw Products', RawProduct::count()),
            Card::make('Finish Products', FinishProduct::count()),
        ];
    }
}
