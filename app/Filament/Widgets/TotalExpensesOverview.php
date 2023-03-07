<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use Illuminate\Database\Eloquent\Model;

class TotalExpensesOverview extends BaseWidget
{
	public ?Model $record = null;

	protected static ?string $pollingInterval = null;

	protected function getCards(): array
	{
		return [
			Card::make('Total Monthly Expenses',  number_format($GLOBALS['expensesAmount']) ?? 0)
				->icon('heroicon-o-cash'),
		];
	}
}
