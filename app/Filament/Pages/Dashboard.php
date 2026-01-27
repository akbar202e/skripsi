<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Widgets\AccountWidget;
use Filament\Widgets\FilamentInfoWidget;

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

    public function getSubHeading(): ?string
    {
        return 'Selamat datang di UPT LAB - Sistem Manajemen Permohonan Pengujian';
    }

    /**
     * @return array<class-string<\Filament\Widgets\Widget>|string>
     */
    protected function getHeaderWidgets(): array
    {
        return [
            AccountWidget::class,
        ];
    }

    /**
     * @return array<class-string<\Filament\Widgets\Widget>|string>
     */
    protected function getFooterWidgets(): array
    {
        return [
            FilamentInfoWidget::class,
        ];
    }
}
