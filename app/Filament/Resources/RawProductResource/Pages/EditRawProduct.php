<?php

namespace App\Filament\Resources\RawProductResource\Pages;

use App\Filament\Resources\RawProductResource;
use App\Filament\Widgets\RawProductQuantityOverview;
use App\Filament\Widgets\TimestampsOverview;
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

    protected function getHeaderWidgets(): array
    {
        return [
            TimestampsOverview::class,
            RawProductQuantityOverview::class,
        ];
    }
}
