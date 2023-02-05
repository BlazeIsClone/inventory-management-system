<?php

namespace App\Filament\Resources\PurchaseBillResource\Pages;

use App\Filament\Resources\PurchaseBillResource;
use App\Models\RawProduct;
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
    protected function mutateFormDataBeforeSave(array $data): array
    {
        foreach ($this->data['purchaseBillRawProducts'] as $row) {
            $rawProduct = RawProduct::find($row['raw_product_id']);

            if ($row['product_quantity'] >= $rawProduct->available_quantity) {
                $rawProduct->available_quantity += $row['product_quantity'];
            } else {
                $rawProduct->available_quantity -= $row['product_quantity'];
            }

            $rawProduct->save();
        }

        return $data;
    }
}
