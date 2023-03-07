<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use Illuminate\Database\Eloquent\Model;

class MaterialInventoryOverview extends BaseWidget
{
	public ?Model $record = null;

	protected static ?string $pollingInterval = null;

	protected function getCards(): array
	{
		return [
			Card::make('Total Stock Value',  null ?? 0)
				->icon('heroicon-o-cash'),
		];
	}
}
