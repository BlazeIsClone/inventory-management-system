<?php

namespace App\Filament\Pages;

use App\Models\PurchaseBill;
use Filament\Pages\Page;
use App\Models\RawProduct;
use Filament\Tables;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Concerns\InteractsWithTable;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class MaterialInventory extends Page implements HasTable
{
    use InteractsWithTable;

    protected static ?string $navigationIcon = 'heroicon-o-archive';

    protected static ?string $navigationGroup = 'Records';

    protected static ?string $title = 'Material Inventory';

    protected static string $view = 'filament.pages.material-inventory';

    protected static ?int $navigationSort = 2;


    protected function getTableQuery(): Builder
    {
        return RawProduct::query();
    }

    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('name'),
            Tables\Columns\TextColumn::make('total_purchased')
                ->getStateUsing(function (Model $record) {
                    //PurchaseBill::where
                }),
            Tables\Columns\TextColumn::make('total_used'),
            Tables\Columns\TextColumn::make('balance'),
            Tables\Columns\TextColumn::make('avarage_cost'),
            Tables\Columns\TextColumn::make('total'),
        ];
    }
}
