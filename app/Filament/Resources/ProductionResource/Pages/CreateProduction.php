<?php

namespace App\Filament\Resources\ProductionResource\Pages;

use App\Filament\Resources\ProductionResource;
use App\Models\FinishProduct;
use App\Models\RawProduct;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateProduction extends CreateRecord
{
    protected static string $resource = ProductionResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $finishProduct = FinishProduct::find($data['finish_product_id']);
        foreach ($finishProduct->finishProductRawProducts as $record) {
            $finishProduct->available_quantity = $data['quantity'];
            $finishProduct->save();

            $rawProduct = RawProduct::find($record->raw_product_id);
            $rawProduct->available_quantity -= $data['quantity'] * $record->raw_product_quantity;
            $rawProduct->save();
        };
        return $data;
    }
}
