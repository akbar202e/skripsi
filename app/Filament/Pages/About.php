<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class About extends Page
{
    protected static string $view = 'filament.pages.about';

    protected static bool $shouldRegisterNavigation = true;

    public static function getNavigationIcon(): string
    {
        return 'heroicon-o-information-circle';
    }

    public static function getNavigationLabel(): string
    {
        return 'Tentang UPT';
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Informasi';
    }

    public function getHeading(): string
    {
        return 'Tentang UPT LAB';
    }

    public function getSubHeading(): ?string
    {
        return 'Sistem Pengajuan Uji Bahan Konstruksi di UPT Laboratorium';
    }

    public function getFooterWidgets(): array
    {
        return [];
    }
}
