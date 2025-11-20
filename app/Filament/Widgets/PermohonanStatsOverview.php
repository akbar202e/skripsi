<?php

namespace App\Filament\Widgets;

use App\Models\Permohonan;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class PermohonanStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Menunggu Verifikasi', Permohonan::where('status', 'menunggu_verifikasi')->when(auth()->user()->hasRole('Pemohon'), function($query){
                $query->where('user_id', auth()->user()->id);
            })->count()),
            Stat::make('Perlu Perbaikan', Permohonan::where('status', 'perlu_perbaikan')->when(auth()->user()->hasRole('Pemohon'), function($query){
                $query->where('user_id', auth()->user()->id);
            })->count()),
            Stat::make('Menunggu Pembayaran & Sampel', Permohonan::where('status', 'menunggu_pembayaran_sampel')->when(auth()->user()->hasRole('Pemohon'), function($query){
                $query->where('user_id', auth()->user()->id);
            })->count()),
            Stat::make('Sedang Diuji', Permohonan::where('status', 'sedang_diuji')->when(auth()->user()->hasRole('Pemohon'), function($query){
                $query->where('user_id', auth()->user()->id);
            })->count()),
            Stat::make('Menyusun Laporan', Permohonan::where('status', 'menyusun_laporan')->when(auth()->user()->hasRole('Pemohon'), function($query){
                $query->where('user_id', auth()->user()->id);
            })->count()),
            Stat::make('Selesai', Permohonan::where('status', 'selesai')->when(auth()->user()->hasRole('Pemohon'), function($query){
                $query->where('user_id', auth()->user()->id);
            })->count()),
        ];
    }
}
