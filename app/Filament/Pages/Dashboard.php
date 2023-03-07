<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\TotalProductionInventoryOverview;
use Filament\Pages\Page;

class Dashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-home';

    protected static ?int $navigationSort = -2;

    protected static string $view = 'filament.pages.dashboard';

    protected static function getNavigationLabel(): string
    {
        return static::$navigationLabel ?? static::$title ?? __('filament::pages/dashboard.title');
    }

    protected function getWidgets(): array
    {
        return [];
    }

    protected function getColumns(): int | array
    {
        return 2;
    }

    protected function getTitle(): string
    {
        return static::$title ?? 'Welcome To The Inventory Manager!';
    }


    protected function getViewData(): array
    {
        return ['test' => number_format($GLOBALS['productionInventoryValue'] ?? 0)];
    }
}
