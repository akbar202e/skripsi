<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;
use App\Filament\Widgets\PermohonanStatsOverview;
use App\Filament\Widgets\PermohonanChart;
use App\Filament\Widgets\PermohonanDailyChart;

class Dashboard extends BaseDashboard
{
    public static function getNavigationIcon(): string
    {
        return 'heroicon-o-home';
    }

    public function getHeading(): string
    {
        return 'Dashboard';
    }

    // public function getColumns(): int | string | array
    // {
    //     return 2;
    // }

    public function getWidgets(): array
    {
        return [
            PermohonanStatsOverview::class,
            PermohonanChart::class,
            PermohonanDailyChart::class,
        ];
    }
}
