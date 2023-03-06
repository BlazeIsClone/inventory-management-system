<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class TotalProductionInventoryOverview extends BaseWidget
{
	public ?Model $record = null;

	protected static ?string $pollingInterval = null;

	protected function getCards(): array
	{
		return [
			Card::make('Total Sales Amount',  number_format($GLOBALS['productionInventoryValue']) ?? 0)
				->icon('heroicon-o-cash'),
		];
	}
}
