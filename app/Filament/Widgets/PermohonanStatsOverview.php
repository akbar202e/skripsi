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
            Stat::make('Menunggu Verifikasi', Permohonan::where('status', 'menunggu verifikasi')->when(auth()->user()->hasRole('Pemohon'), function($query){
                $query->where('user_id', auth()->user()->id);
            })->count()),
            Stat::make('Terverifikasi', Permohonan::where('status', 'terverifikasi')->when(auth()->user()->hasRole('Pemohon'), function($query){
                $query->where('user_id', auth()->user()->id);
            })->count()),
            Stat::make('Sedang Diproses', Permohonan::where('status', 'diproses')->when(auth()->user()->hasRole('Pemohon'), function($query){
                $query->where('user_id', auth()->user()->id);
            })->count()),
            Stat::make('Selesai', Permohonan::where('status', 'selesai')->when(auth()->user()->hasRole('Pemohon'), function($query){
                $query->where('user_id', auth()->user()->id);
            })->count()),
            Stat::make('Dibatalkan', Permohonan::where('status', 'dibatalkan')->when(auth()->user()->hasRole('Pemohon'), function($query){
                $query->where('user_id', auth()->user()->id);
            })->count()),
            Stat::make('Perlu Perbaikan', Permohonan::where('status', 'perlu perbaikan')->when(auth()->user()->hasRole('Pemohon'), function($query){
                $query->where('user_id', auth()->user()->id);
            })->count()),
        ];
    }
}
