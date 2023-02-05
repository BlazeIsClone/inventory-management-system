<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Models\RawProduct;
use Filament\Tables;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Concerns\InteractsWithTable;
use Illuminate\Contracts\Database\Eloquent\Builder;

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
        return RawProduct::query();
    }

    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('total_purchased'),
            Tables\Columns\TextColumn::make('total_used'),
            Tables\Columns\TextColumn::make('balanced'),
            Tables\Columns\TextColumn::make('average_cost'),
            Tables\Columns\TextColumn::make('total'),
        ];
    }
}
