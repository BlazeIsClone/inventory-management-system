<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use Illuminate\Database\Eloquent\Model;

class RawProductQuantityOverview extends BaseWidget
{
    public ?Model $record = null;

    protected function getCards(): array
    {
        return [
            Card::make('Available Quantity', $this->record->available_quantity ?? 0)
                ->icon('heroicon-o-collection'),
        ];
    }
}
