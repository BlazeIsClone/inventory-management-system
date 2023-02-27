<?php

namespace App\Filament\Pages;

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

class TotalProductionInventory extends Page implements HasTable
{
    use InteractsWithTable;

    protected static ?string $navigationIcon = 'heroicon-o-inbox';

    protected static ?string $navigationGroup = 'Records';

    protected static ?string $title = 'Total Production Inventory';

    protected static string $view = 'filament.pages.total-production-inventory';

    protected static ?int $navigationSort = 3;

    protected function getTableQuery(): Builder
    {
        return FinishProduct::query();
    }

    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('name'),
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

                    return $broughtForward;
                }),
            Tables\Columns\TextColumn::make('total_produced')
                ->getStateUsing(function (Model $record) {

                    $totalQuantity = 0;

                    $productions = Production::all()->where(
                        'created_at',
                        '>=',
                        Carbon::now()->startOfMonth()->toDateString()
                    );

                    foreach ($productions as $production) {
                        if ($record->id === $production->finish_product_id) {
                            $totalQuantity += $production->quantity;
                        }
                    }

                    return $totalQuantity;
                }),

            Tables\Columns\TextColumn::make('total_sold')
                ->getStateUsing(function (Model $record) {

                    $totalQuantity = 0;

                    $productions = SalesInvoice::all();

                    foreach ($productions as $production) {
                        foreach ($production->finishProductSalesInvoice as $pivot) {
                            if ($record->id === $pivot->finish_product_id) {
                                $totalQuantity += $pivot->finish_product_quantity;
                            }
                        }
                    }

                    return $totalQuantity;
                }),


            Tables\Columns\TextColumn::make('balance'),
            Tables\Columns\TextColumn::make('average_cost'),
            Tables\Columns\TextColumn::make('total'),
        ];
    }
}
