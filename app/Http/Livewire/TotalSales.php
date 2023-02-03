<?php

namespace App\Http\Livewire;

use App\Models\RawProduct;
use Filament\Tables;
use Livewire\Component;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Contracts\Database\Eloquent\Builder;

class TotalSales extends Component implements HasTable
{
    use Tables\Concerns\InteractsWithTable;


    protected function getTableQuery(): Builder
    {
        return RawProduct::query();
    }

    protected function getTableColumns(): array
    {
        return [];
    }

    protected function getTableFilters(): array
    {
        return [];
    }

    protected function getTableActions(): array
    {
        return [];
    }

    protected function getTableBulkActions(): array
    {
        return [];
    }

    public function render()
    {
        return view('livewire.total-sales');
    }
}
