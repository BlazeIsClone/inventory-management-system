<?php

namespace App\Filament\Resources\SalesInvoiceResource\Pages;

use App\Filament\Resources\SalesInvoiceResource;
use App\Models\FinishProduct;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateSalesInvoice extends CreateRecord
{
    protected static string $resource = SalesInvoiceResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        foreach ($this->data['finishProductSalesInvoice'] as $pivot) {
            $finishProduct = FinishProduct::find($pivot['finish_product_id']);
            $finishProduct->available_quantity -= $pivot['finish_product_quantity'];
            $finishProduct->save();
        }
        return $data;
    }
}
