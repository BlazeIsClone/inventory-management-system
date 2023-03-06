<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\TotalProductionInventoryOverview;
use App\Models\FinishProduct;
use App\Models\Production;
use App\Models\SalesInvoice;
use Filament\Pages\Page;
use Filament\Tables;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Concerns\InteractsWithTable;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Session;

class TotalProductionInventory extends Page implements HasTable
{
	use InteractsWithTable;

	protected static ?string $navigationIcon = 'heroicon-o-inbox';

	protected static ?string $navigationGroup = 'Records';

	protected static ?string $title = 'Total Production Inventory';

	protected static string $view = 'filament.pages.total-production-inventory';

	protected static ?int $navigationSort = 3;

	protected $allTotalValue = 0;
	protected $broughtForward = 0;
	protected $totalProduced = 0;
	protected $totalSold = 0;
	protected $balance = 0;
	protected $averageCost = 0;

	protected function getTableQuery(): Builder
	{
		return FinishProduct::query();
	}

	protected function getTableColumns(): array
	{
		$GLOBALS['productionInventoryValue'] = 0;

		$schema = [
			Tables\Columns\TextColumn::make('name')
				->searchable(),
			Tables\Columns\TextColumn::make('brought_forward')
				->getStateUsing(function (Model $record) {

					$broughtForward = 0;
					$currentMonthProductions = 0;

					$productions = Production::all()->where(
						'created_at',
						'>=',
						Carbon::now()->startOfMonth()->toDateString()
					);

					$finishProducts = FinishProduct::all()->where(
						'created_at',
						'<=',
						Carbon::now()->subMonth()->endOfMonth()->toDateString()
					);

					foreach ($productions as $production) {
						if ($record->id === $production->finish_product_id) {
							$currentMonthProductions += $production->quantity;
						}
					}

					if ($finishProducts->isNotEmpty()) {
						foreach ($finishProducts as $finishProduct) {
							if ($record->id === $finishProduct->id) {
								$broughtForward += ($finishProduct->available_quantity + $currentMonthProductions);
							}
						}
					} else {
						$broughtForward += $currentMonthProductions;
					}

					$this->broughtForward = $broughtForward;

					return $broughtForward;
				}),
			Tables\Columns\TextColumn::make('total_produced')
				->getStateUsing(function (Model $record) {
					$totalProduced = 0;

					$productions = Production::all()->where(
						'created_at',
						'>=',
						Carbon::now()->startOfMonth()->toDateString()
					);

					foreach ($productions as $production) {
						if ($record->id === $production->finish_product_id) {
							$totalProduced += $production->quantity;
						}
					}

					$this->totalProduced = $totalProduced;

					return $totalProduced;
				}),

			Tables\Columns\TextColumn::make('total_sold')
				->getStateUsing(function (Model $record) {
					$totalSold = 0;
					$productions = SalesInvoice::all();

					foreach ($productions as $production) {
						foreach ($production->finishProductSalesInvoice as $pivot) {
							if ($record->id === $pivot->finish_product_id) {
								$totalSold += $pivot->finish_product_quantity;
							}
						}
					}

					$this->totalSold = $totalSold;

					return $totalSold;
				}),
			Tables\Columns\TextColumn::make('balance')
				->getStateUsing(function () {
					$balance = ($this->broughtForward + $this->totalProduced) - $this->totalSold;
					$this->balance = $balance;

					return $balance;
				}),
			Tables\Columns\TextColumn::make('average_cost')
				->getStateUsing(function (Model $record) {
					$averageCost = $record->sales_price;
					$this->averageCost = $averageCost;

					return $averageCost;
				}),
			Tables\Columns\TextColumn::make('total_value')
				->getStateUsing(function () {
					$totalValue = $this->balance * $this->averageCost;

					// Set global value for widgets
					$GLOBALS['productionInventoryValue'] += $totalValue;

					return $totalValue;
				}),
		];

		return $schema;
	}

	protected function getHeaderWidgets(): array
	{
		return [
			TotalProductionInventoryOverview::class,
		];
	}
}
