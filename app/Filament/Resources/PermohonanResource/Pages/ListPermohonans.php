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
        'Menunggu Verifikasi' => Tab::make()
            ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'permohonan_masuk')),
        'Proses Verifikasi' => Tab::make()
            ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'verifikasi_berkas')),
        'Perlu Perbaikan' => Tab::make()
            ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'perlu_perbaikan')),
        'Terverifikasi' => Tab::make()
            ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'terverifikasi')),
        'Menunggu Sampel' => Tab::make()
            ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'menunggu_sampel_dan_pembayaran')),
        'Proses Administrasi' => Tab::make()
            ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'proses_administrasi')),
        'Proses Pengujian' => Tab::make()
            ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'pengujian')),
        'Selesai' => Tab::make()
            ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'selesai')),
    ];
}
}
