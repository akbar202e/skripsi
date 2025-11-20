<?php

namespace App\Filament\Widgets;

use App\Models\Permohonan;
use Filament\Widgets\ChartWidget;
use Carbon\Carbon;

class PermohonanDailyChart extends ChartWidget
{
    protected static ?string $heading = 'Jumlah Permohonan Per Hari (30 Hari Terakhir)';
    protected static ?int $sort = 2;

    protected function getData(): array
    {
        // Get data dari 30 hari terakhir
        $startDate = now()->subDays(29);
        $endDate = now();

        $data = Permohonan::query()
            ->selectRaw('DATE(created_at) as date, COUNT(*) as total')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->keyBy('date');

        // Generate semua tanggal dalam 30 hari
        $dates = [];
        $counts = [];
        
        for ($i = 29; $i >= 0; $i--) {
            $date = now()->subDays($i)->toDateString();
            $dates[] = now()->subDays($i)->format('d M');
            $counts[] = $data->get($date)?->total ?? 0;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Permohonan',
                    'data' => $counts,
                    'backgroundColor' => 'rgba(59, 130, 246, 0.1)',
                    'borderColor' => 'rgba(59, 130, 246, 1)',
                    'borderWidth' => 2,
                    'fill' => true,
                    'pointRadius' => 4,
                    'pointHoverRadius' => 6,
                    'pointBackgroundColor' => 'rgba(59, 130, 246, 1)',
                    'tension' => 0.3,
                ],
            ],
            'labels' => $dates,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    protected function getOptions(): array
    {
        return [
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'ticks' => [
                        'stepSize' => 1,
                    ],
                ],
            ],
            'plugins' => [
                'legend' => [
                    'display' => true,
                    'position' => 'top',
                ],
            ],
            'responsive' => true,
            'maintainAspectRatio' => true,
        ];
    }
    public static function canView(): bool
    {
       return auth()->user()->hasRole('Admin');
    }
}
