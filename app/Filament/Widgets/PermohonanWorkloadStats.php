<?php

namespace App\Filament\Widgets;

use App\Models\Permohonan;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class PermohonanWorkloadStats extends BaseWidget
{
    protected static ?int $sort = 1;

    public static function canView(): bool
    {
        return auth()->check() && (auth()->user()->hasRole('Admin') || auth()->user()->hasRole('Petugas'));
    }

    public function getHeading(): ?string
    {
        return 'Service & Performance Insight';
    }

    protected function getStats(): array
    {
        // Workload stats
        $sedangDiuji = Permohonan::where('status', 'sedang_diuji')->count();

        // Performance stats
        $completedPermohonan = Permohonan::where('status', 'selesai')
            ->whereNotNull('testing_started_at')
            ->whereNotNull('completed_at')
            ->get();

        $averageTurnaroundDays = 0;
        if ($completedPermohonan->count() > 0) {
            $totalDays = 0;
            foreach ($completedPermohonan as $permohonan) {
                $days = $permohonan->testing_started_at->diffInDays($permohonan->completed_at);
                $totalDays += $days;
            }
            $averageTurnaroundDays = floor($totalDays / $completedPermohonan->count());
        }

        return [
            Stat::make('Beban Kerja Saat Ini', $sedangDiuji . ' Permohonan')
                ->description('Status: Sedang Diuji')
                ->color('info')
                ->icon('heroicon-o-beaker'),
            Stat::make('Rata-rata Waktu Penyelesaian', $averageTurnaroundDays . ' hari')
                ->description('Mulai Pengujian - Selesai')
                ->color('success')
                ->icon('heroicon-o-clock'),
        ];
    }
}
