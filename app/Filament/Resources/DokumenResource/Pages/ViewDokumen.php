<?php

namespace App\Filament\Resources\DokumenResource\Pages;

use App\Filament\Resources\DokumenResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewDokumen extends ViewRecord
{
    protected static string $resource = DokumenResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make()
                ->visible(fn () => auth()->user()?->hasRole('Admin') ?? false),
            Actions\DeleteAction::make()
                ->visible(fn () => auth()->user()?->hasRole('Admin') ?? false),
        ];
    }
}
