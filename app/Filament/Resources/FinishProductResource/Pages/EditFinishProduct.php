<?php

namespace App\Filament\Resources\FinishProductResource\Pages;

use App\Filament\Resources\FinishProductResource;
use App\Filament\Widgets\FinishProductQuantityOverview;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFinishProduct extends EditRecord
{
    protected static string $resource = FinishProductResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            FinishProductQuantityOverview::class,
        ];
    }
}
