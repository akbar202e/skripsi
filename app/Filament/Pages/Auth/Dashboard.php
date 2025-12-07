<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\DokumenGrid;
use App\Filament\Widgets\PermohonanStatsOverview;
use App\Filament\Widgets\PermohonanChart;
use App\Filament\Widgets\PermohonanDailyChart;

class Dashboard extends \Filament\Pages\Dashboard
{
    public function getColumns(): int | string | array
    {
        return 2;
    }

    public function getWidgets(): array
    {
        return [
            PermohonanStatsOverview::class,
            PermohonanChart::class,
            PermohonanDailyChart::class,
            // DokumenGrid::class,
        ];
    }
}