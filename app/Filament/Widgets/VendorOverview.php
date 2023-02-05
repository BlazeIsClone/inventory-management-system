<?php

namespace App\Filament\Widgets;

use App\Models\Vendor;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;


class VendorOverview extends BaseWidget
{
    protected function getCards(): array
    {
        return [
            Card::make('Vendors', Vendor::count()),
        ];
    }
}
