<?php

namespace App\Filament\Resources\DokumenResource\Pages;

use App\Filament\Resources\DokumenResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDokumens extends ListRecords
{
    protected static string $resource = DokumenResource::class;

    protected static ?string $title = 'Panduan & Informasi';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->visible(fn () => auth()->user()?->hasRole('Admin') ?? false),
        ];
    }
}
