<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Models\RawProduct;
use Filament\Tables;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Concerns\InteractsWithTable;
use Illuminate\Contracts\Database\Eloquent\Builder;

class TotalSales extends Page implements HasTable
{
    use InteractsWithTable;

    protected static ?string $navigationIcon = 'heroicon-o-credit-card';

    protected static ?string $navigationGroup = 'Records';

    protected static ?string $title = 'Total Sales';

    protected static string $view = 'filament.pages.total-sales';

    protected static ?int $navigationSort = 0;


    protected function getTableQuery(): Builder
    {
        return RawProduct::query();
    }

    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('total_sold'),
            Tables\Columns\TextColumn::make('sales_amount'),
        ];
    }
}