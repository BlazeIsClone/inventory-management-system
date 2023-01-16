<?php

namespace App\Filament\Resources\ExpensesCategoryResource\Pages;

use App\Filament\Resources\ExpensesCategoryResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditExpensesCategory extends EditRecord
{
    protected static string $resource = ExpensesCategoryResource::class;

    protected function getActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
