<?php

namespace App\Filament\Widgets;

use App\Models\Pembayaran;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Number;

class PembayaranStatusStats extends BaseWidget
{
    protected static ?int $sort = 2;

    public static function canView(): bool
    {
        return auth()->check() && (auth()->user()->hasRole('Admin') || auth()->user()->hasRole('Petugas'));
    }

    public function getHeading(): ?string
    {
        return 'Status Pembayaran';
    }

    protected function getStats(): array
    {
        $totalPending = Pembayaran::where('status', 'pending')
            ->sum('amount');

        $totalPaid = Pembayaran::where('status', 'success')
            ->sum('amount');

        $totalFailed = Pembayaran::where('status', 'failed')
            ->sum('amount');

        $countPending = Pembayaran::where('status', 'pending')->count();
        $countPaid = Pembayaran::where('status', 'success')->count();
        $countFailed = Pembayaran::where('status', 'failed')->count();

        return [
            Stat::make('Tagihan Pending', $countPending . ' Tagihan')
                ->description('Rp ' . Number::format($totalPending, locale: 'id'))
                ->color('warning')
                ->icon('heroicon-o-clock'),
            Stat::make('Tagihan Berhasil', $countPaid . ' Tagihan')
                ->description('Rp ' . Number::format($totalPaid, locale: 'id'))
                ->color('success')
                ->icon('heroicon-o-check-circle'),
            Stat::make('Tagihan Batal', $countFailed . ' Tagihan')
                ->description('Rp ' . Number::format($totalFailed, locale: 'id'))
                ->color('danger')
                ->icon('heroicon-o-x-circle'),
        ];
    }
}
