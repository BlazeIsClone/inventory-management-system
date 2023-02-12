<?php

namespace App\Filament\Resources\ProductionResource\Pages;

use App\Filament\Resources\ProductionResource;
use App\Models\FinishProduct;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProduction extends EditRecord
{
    protected static string $resource = ProductionResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->before(function () {
                    $finishProduct = FinishProduct::find($this->data['finish_product_id']);
                    $finishProduct->available_quantity -= $this->data['quantity'];
                    $finishProduct->save();
                }),
        ];
    }
}
