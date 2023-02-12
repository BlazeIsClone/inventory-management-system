<?php

namespace App\Filament\Resources\PurchaseBillResource\Pages;

use App\Filament\Resources\PurchaseBillResource;
use App\Filament\Widgets\PurchaseBillSubTotalOverview;
use App\Models\RawProduct;
use Filament\Resources\Pages\CreateRecord;

class CreatePurchaseBill extends CreateRecord
{
    protected static string $resource = PurchaseBillResource::class;

    protected $items = [];

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        foreach ($this->data['purchaseBillRawProducts'] as $row) {
            $rawProduct = RawProduct::find($row['raw_product_id']);
            $rawProduct->available_quantity += $row['product_quantity'];
            $rawProduct->save();
        }

        return $data;
    }
}
