<?php

namespace App\Filament\Resources\ExpensesCategoryResource\Pages;

use App\Filament\Resources\ExpensesCategoryResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewExpensesCategory extends ViewRecord
{
    protected static string $resource = ExpensesCategoryResource::class;

    protected function getActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
