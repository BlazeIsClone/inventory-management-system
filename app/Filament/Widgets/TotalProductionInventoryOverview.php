<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class TotalProductionInventoryOverview extends BaseWidget
{
	public ?Model $record = null;

	protected function getCards(): array
	{
		//dd(Session::get('allTotalValue'));
		return [
			Card::make('Total Saels Amount',  Session::get('allTotalValue'))
				->icon('heroicon-o-cash'),
		];
	}
}
