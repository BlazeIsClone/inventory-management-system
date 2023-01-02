<?php

namespace App\Filament\Resources\PurchaseBillResource\Pages;

use App\Filament\Resources\PurchaseBillResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPurchaseBills extends ListRecords
{
    protected static string $resource = PurchaseBillResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
