<?php

namespace App\Filament\Resources\PermohonanResource\Pages;

use App\Filament\Resources\PermohonanResource;
use App\Filament\Widgets\BottleneckDetectionWidget;
use App\Filament\Widgets\PermohonanWorkloadStats;
use App\Filament\Widgets\Top5JenisPengujiansChart;
use App\Filament\Widgets\VolumeSampelPerBulanChart;
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

    protected function getHeaderWidgets(): array
    {
        return [
            PermohonanWorkloadStats::class,
            Top5JenisPengujiansChart::class,
            VolumeSampelPerBulanChart::class,
            BottleneckDetectionWidget::class,
        ];
    }

public function getTabs(): array
{
    return [
        'all' => Tab::make(),
        'Menunggu Verifikasi' => Tab::make()
            ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'menunggu_verifikasi')),
        'Perlu Perbaikan' => Tab::make()
            ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'perlu_perbaikan')),
        'Menunggu Pembayaran & Sampel' => Tab::make()
            ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'menunggu_pembayaran_sampel')),
        'Sedang Diuji' => Tab::make()
            ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'sedang_diuji')),
        'Menyusun Laporan' => Tab::make()
            ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'menyusun_laporan')),
        'Selesai' => Tab::make()
            ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'selesai')),
    ];
}
}
