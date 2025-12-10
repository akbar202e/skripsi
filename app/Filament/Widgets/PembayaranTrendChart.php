<?php

namespace App\Filament\Widgets;

use App\Models\Pembayaran;
use Filament\Widgets\ChartWidget;

class PembayaranTrendChart extends ChartWidget
{
    protected static ?int $sort = 3;

    public static function canView(): bool
    {
        return auth()->check() && (auth()->user()->hasRole('Admin') || auth()->user()->hasRole('Petugas'));
    }

    public function getHeading(): ?string
    {
        return 'Tren Pendapatan';
    }

    protected function getData(): array
    {
        // Get current month data
        $currentMonthData = Pembayaran::where('status', 'success')
            ->whereMonth('paid_at', now()->month)
            ->whereYear('paid_at', now()->year)
            ->selectRaw('DAY(paid_at) as day, SUM(amount) as total')
            ->groupBy('day')
            ->orderBy('day')
            ->get();

        // Get previous month data for comparison
        $previousMonthData = Pembayaran::where('status', 'success')
            ->whereMonth('paid_at', now()->subMonth()->month)
            ->whereYear('paid_at', now()->subMonth()->year)
            ->selectRaw('DAY(paid_at) as day, SUM(amount) as total')
            ->groupBy('day')
            ->orderBy('day')
            ->get();

        $daysInMonth = now()->daysInMonth;
        $currentData = array_fill(1, $daysInMonth, 0);
        $previousData = array_fill(1, $daysInMonth, 0);

        foreach ($currentMonthData as $item) {
            $currentData[$item->day] = (float) $item->total;
        }

        foreach ($previousMonthData as $item) {
            $previousData[$item->day] = (float) $item->total;
        }

        $labels = array_keys($currentData);

        return [
            'datasets' => [
                [
                    'label' => 'Bulan Ini',
                    'data' => array_values($currentData),
                    'borderColor' => 'rgba(34, 197, 94, 1)',
                    'backgroundColor' => 'rgba(34, 197, 94, 0.1)',
                    'borderWidth' => 2,
                    'fill' => true,
                    'tension' => 0.4,
                ],
                [
                    'label' => 'Bulan Lalu',
                    'data' => array_values($previousData),
                    'borderColor' => 'rgba(156, 163, 175, 1)',
                    'backgroundColor' => 'rgba(156, 163, 175, 0.1)',
                    'borderWidth' => 2,
                    'fill' => true,
                    'tension' => 0.4,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
