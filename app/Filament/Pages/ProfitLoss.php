<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Models\RawProduct;
use Filament\Tables;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Concerns\InteractsWithTable;
use Illuminate\Contracts\Database\Eloquent\Builder;

class ProfitLoss extends Page implements HasTable
{
    use InteractsWithTable;

    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';

    protected static ?string $navigationGroup = 'Records';

    protected static ?string $title = 'Profit and Loss';

    protected static string $view = 'filament.pages.profit-loss';

    protected static ?int $navigationSort = 4;

    protected function getTableQuery(): Builder
    {
        return RawProduct::query();
    }

    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('name'),
            Tables\Columns\TextColumn::make('unit'),
        ];
    }
}
