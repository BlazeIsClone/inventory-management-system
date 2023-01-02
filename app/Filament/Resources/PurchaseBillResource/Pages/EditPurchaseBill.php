<?php

namespace App\Filament\Resources\PurchaseBillResource\Pages;

use App\Filament\Resources\PurchaseBillResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPurchaseBill extends EditRecord
{
    protected static string $resource = PurchaseBillResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
