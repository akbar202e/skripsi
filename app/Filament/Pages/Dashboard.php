<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;


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

    
}
