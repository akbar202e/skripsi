<?php

namespace App\Filament\Widgets;

use App\Models\Pembayaran;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Number;

class PembayaranFinancialStats extends BaseWidget
{
    protected static ?int $sort = 1;

    public static function canView(): bool
    {
        return auth()->check() && (auth()->user()->hasRole('Admin') || auth()->user()->hasRole('Petugas'));
    }



    protected function getStats(): array
    {
        $totalHarian = Pembayaran::where('status', 'success')
            ->whereDate('paid_at', today())
            ->sum('amount');

        $totalMingguan = Pembayaran::where('status', 'success')
            ->whereBetween('paid_at', [now()->startOfWeek(), now()->endOfWeek()])
            ->sum('amount');

        $totalBulanan = Pembayaran::where('status', 'success')
            ->whereMonth('paid_at', now()->month)
            ->whereYear('paid_at', now()->year)
            ->sum('amount');

        $totalTahunan = Pembayaran::where('status', 'success')
            ->whereYear('paid_at', now()->year)
            ->sum('amount');

        return [
            Stat::make('Pendapatan Hari Ini', 'Rp ' . Number::format($totalHarian, locale: 'id'))
                ->color('success')
                ->icon('heroicon-o-banknotes'),
            Stat::make('Pendapatan Minggu Ini', 'Rp ' . Number::format($totalMingguan, locale: 'id'))
                ->color('info')
                ->icon('heroicon-o-calendar'),
            Stat::make('Pendapatan Bulan Ini', 'Rp ' . Number::format($totalBulanan, locale: 'id'))
                ->color('warning')
                ->icon('heroicon-o-chart-bar'),
            Stat::make('Pendapatan Tahun Ini', 'Rp ' . Number::format($totalTahunan, locale: 'id'))
                ->color('primary')
                ->icon('heroicon-o-globe-alt'),
        ];
    }
}
