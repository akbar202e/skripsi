<?php

namespace App\Filament\Widgets;

use App\Models\Permohonan;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class PermohonanChart extends ChartWidget
{
    protected static ?string $heading = 'Pendapatan Per Bulan';
    protected static ?int $sort = 2;

    protected function getData(): array
    {
        $data = Permohonan::query()
            ->selectRaw('MONTH(created_at) as month, YEAR(created_at) as year, SUM(total_biaya) as total')
            ->whereYear('created_at', now()->year)
            ->groupBy('year', 'month')
            ->orderBy('month')
            ->get();

        $months = [
            'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun',
            'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'
        ];

        $chartData = array_fill(0, 12, 0);
        foreach ($data as $item) {
            $chartData[$item->month - 1] = (float) $item->total;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Pendapatan (Rp)',
                    'data' => $chartData,
                    'backgroundColor' => 'rgba(34, 197, 94, 0.5)',
                    'borderColor' => 'rgba(34, 197, 94, 1)',
                    'borderWidth' => 2,
                    'fill' => true,
                ],
            ],
            'labels' => $months,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getOptions(): array
    {
        return [
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'ticks' => [
                        'callback' => 'function(value) { return "Rp " + value.toLocaleString("id-ID"); }',
                    ],
                ],
            ],
            'plugins' => [
                'legend' => [
                    'display' => true,
                    'position' => 'top',
                ],
            ],
        ];
    }
    public static function canView(): bool
    {
       return auth()->user()->hasRole('Admin');
    }
}
