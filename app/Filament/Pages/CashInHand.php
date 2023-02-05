<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Models\RawProduct;
use Filament\Tables;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Concerns\InteractsWithTable;
use Illuminate\Contracts\Database\Eloquent\Builder;

class CashInHand extends Page implements HasTable
{
    use InteractsWithTable;

    protected static ?string $navigationIcon = 'heroicon-o-cash';

    protected static ?string $navigationGroup = 'Records';

    protected static ?string $title = 'Cash in Hand';

    protected static string $view = 'filament.pages.cash-in-hand';

    protected static ?int $navigationSort = 1;


    protected function getTableQuery(): Builder
    {
        return RawProduct::query();
    }

    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('monthly_brought_forward'),
            Tables\Columns\TextColumn::make('total_sales'),
            Tables\Columns\TextColumn::make('total_expenditure'),
            Tables\Columns\TextColumn::make('total'),
        ];
    }
}
