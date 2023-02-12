<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use Illuminate\Database\Eloquent\Model;

class TimestampsOverview extends BaseWidget
{
    public ?Model $record = null;

    protected function getCards(): array
    {
        if (!$this->record) return [];

        return [
            Card::make('Created At', $this->record->created_at->diffForHumans())
                ->icon('heroicon-o-pencil-alt'),
            Card::make('Updated At', $this->record->updated_at->diffForHumans())
                ->icon('heroicon-o-document-add'),
        ];
    }
}
