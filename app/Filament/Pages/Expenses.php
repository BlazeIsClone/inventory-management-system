<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\TotalExpensesOverview;
use App\Filament\Widgets\TotalProductionInventoryOverview;
use App\Models\Expense;
use App\Models\FinishProduct;
use App\Models\Production;
use App\Models\SalesInvoice;
use Closure;
use Filament\Pages\Page;
use Filament\Tables;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Concerns\InteractsWithTable;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Expenses extends Page implements HasTable
{
	use InteractsWithTable;

	protected static ?string $navigationIcon = 'heroicon-o-receipt-refund';

	protected static ?string $navigationGroup = 'Records';

	protected static ?string $title = 'Total Expenses';

	protected static string $view = 'filament.pages.expenses';

	protected static ?int $navigationSort = 4;

	protected function getTableQuery(): Builder
	{
		return Expense::query()->where(
			'created_at',
			'>=',
			Carbon::now()->subMonth()->endOfMonth()->toDateString()
		);
	}

	protected function getTableColumns(): array
	{
		$GLOBALS['expensesAmount'] = 0;

		$schema = [
			Tables\Columns\TextColumn::make('date')
				->label('Date')
				->date()
				->sortable(),
			Tables\Columns\BadgeColumn::make('expenseCategory.name')
				->label('Expense Category')
				->searchable(),
			Tables\Columns\IconColumn::make('expenseCategory.is_included_in_total_expenses')
				->label('Include To Total Expenses')
				->boolean(),
			Tables\Columns\TextColumn::make('amount')
				->label('Amount')
				->getStateUsing(function (Model $record) {
					$amount = $record->amount;

					// Set global value for widgets
					$GLOBALS['expensesAmount'] += $amount;

					return $amount;
				}),
		];

		return $schema;
	}

	protected function getHeaderWidgets(): array
	{
		return [
			TotalExpensesOverview::class,
		];
	}
}
