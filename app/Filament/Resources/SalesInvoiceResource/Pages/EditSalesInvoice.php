<?php

namespace App\Filament\Resources\SalesInvoiceResource\Pages;

use App\Filament\Resources\SalesInvoiceResource;
use App\Models\FinishProduct;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSalesInvoice extends EditRecord
{
    protected static string $resource = SalesInvoiceResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->before(function () {
                    foreach ($this->data['finishProductSalesInvoice'] as $row) {
                        $finishProduct = FinishProduct::find($row['finish_product_id']);
                        $finishProduct->available_quantity += $row['finish_product_quantity'];
                        $finishProduct->save();
                    };
                }),
        ];
    }
}
