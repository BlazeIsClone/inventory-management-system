<?php

namespace App\Filament\Widgets;

use App\Models\SalesInvoice;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use Illuminate\Database\Eloquent\Model;

class TotalSalesOverview extends BaseWidget
{
	public ?Model $record = null;

	protected static ?string $pollingInterval = null;

	protected function getCards(): array
	{
		$salesInvoices = SalesInvoice::all();

		$quantity = 0;
		$salesAmount = 0;

		foreach ($salesInvoices as $salesInvoice) {
			foreach ($salesInvoice->finishProductSalesInvoice as $pivot) {
				$quantity += $pivot->finish_product_quantity;
				$salesAmount += $pivot->finish_product_quantity * $pivot->finish_product_price;
			}
		}

		// Set global value for widgets
		$GLOBALS['totalSalesValue'] = $salesAmount;

		return [
			Card::make('Total Quantity Sold', $quantity)
				->icon('heroicon-o-collection'),
			Card::make('Total Saels Amount',  number_format($salesAmount))
				->icon('heroicon-o-cash'),
		];
	}
}
