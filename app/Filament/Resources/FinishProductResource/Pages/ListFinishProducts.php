<?php

namespace App\Filament\Resources\FinishProductResource\Pages;

use App\Filament\Resources\FinishProductResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFinishProducts extends ListRecords
{
    protected static string $resource = FinishProductResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
