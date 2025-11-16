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
            Stat::make('Menunggu Verifikasi', Permohonan::where('status', 'permohonan_masuk')->when(auth()->user()->hasRole('Pemohon'), function($query){
                $query->where('user_id', auth()->user()->id);
            })->count()),
            Stat::make('Proses Verifikasi', Permohonan::where('status', 'verifikasi_berkas')->when(auth()->user()->hasRole('Pemohon'), function($query){
                $query->where('user_id', auth()->user()->id);
            })->count()),
            Stat::make('Perlu Perbaikan', Permohonan::where('status', 'perlu_perbaikan')->when(auth()->user()->hasRole('Pemohon'), function($query){
                $query->where('user_id', auth()->user()->id);
            })->count()),
            Stat::make('Terverifikasi', Permohonan::where('status', 'terverifikasi')->when(auth()->user()->hasRole('Pemohon'), function($query){
                $query->where('user_id', auth()->user()->id);
            })->count()),
            Stat::make('Menunggu Sampel', Permohonan::where('status', 'menunggu_sampel_dan_pembayaran')->when(auth()->user()->hasRole('Pemohon'), function($query){
                $query->where('user_id', auth()->user()->id);
            })->count()),
            Stat::make('Proses Administrasi', Permohonan::where('status', 'proses_administrasi')->when(auth()->user()->hasRole('Pemohon'), function($query){
                $query->where('user_id', auth()->user()->id);
            })->count()),
            Stat::make('Proses Pengujian', Permohonan::where('status', 'pengujian')->when(auth()->user()->hasRole('Pemohon'), function($query){
                $query->where('user_id', auth()->user()->id);
            })->count()),
            Stat::make('Selesai', Permohonan::where('status', 'selesai')->when(auth()->user()->hasRole('Pemohon'), function($query){
                $query->where('user_id', auth()->user()->id);
            })->count()),
        ];
    }
}
