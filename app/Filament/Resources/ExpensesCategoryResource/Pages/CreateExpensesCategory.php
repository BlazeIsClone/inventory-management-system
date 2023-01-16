<?php

namespace App\Filament\Resources\ExpensesCategoryResource\Pages;

use App\Filament\Resources\ExpensesCategoryResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateExpensesCategory extends CreateRecord
{
    protected static string $resource = ExpensesCategoryResource::class;
}
