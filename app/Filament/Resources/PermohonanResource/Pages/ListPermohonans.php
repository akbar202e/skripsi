<?php

namespace App\Filament\Resources\PermohonanResource\Pages;

use App\Filament\Resources\PermohonanResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListPermohonans extends ListRecords
{
    protected static string $resource = PermohonanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }


public function getTabs(): array
{
    return [
        'all' => Tab::make(),
        'menunggu verifikasi' => Tab::make()
            ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'menunggu verifikasi')),
        'terverifikasi' => Tab::make()
            ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'terverifikasi')),
        'diproses' => Tab::make()
            ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'diproses')),
        'selesai' => Tab::make()
            ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'selesai')),
        'dibatalkan' => Tab::make()
            ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'dibatalkan')),
        'perlu perbaikan' => Tab::make()
            ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'perlu perbaikan')),
    ];
}
}
