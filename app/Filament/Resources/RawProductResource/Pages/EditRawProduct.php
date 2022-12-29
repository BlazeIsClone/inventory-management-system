<?php

namespace App\Filament\Resources\RawProductResource\Pages;

use App\Filament\Resources\RawProductResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRawProduct extends EditRecord
{
    protected static string $resource = RawProductResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
