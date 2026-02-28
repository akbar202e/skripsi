<?php

namespace App\Filament\Widgets;

use App\Models\JenisPengujian;
use Filament\Widgets\ChartWidget;

class Top5JenisPengujiansChart extends ChartWidget
{
    protected static ?string $heading = 'Jenis Pengujian Terbanyak';
    protected static ?int $sort = 2;

    public static function canView(): bool
    {
        return auth()->check() && (auth()->user()->hasRole('Admin') || auth()->user()->hasRole('Petugas'));
    }

    protected function getData(): array
    {
        $top5 = JenisPengujian::withCount('permohonans')
            ->orderBy('permohonans_count', 'desc')
            ->take(5)
            ->get();

        $labels = $top5->pluck('nama_pengujian')->toArray();
        $data = $top5->pluck('permohonans_count')->toArray();

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Permohonan',
                    'data' => $data,
                    'backgroundColor' => [
                        'rgba(59, 130, 246, 0.8)',
                        'rgba(34, 197, 94, 0.8)',
                        'rgba(251, 146, 60, 0.8)',
                        'rgba(168, 85, 247, 0.8)',
                        'rgba(236, 72, 153, 0.8)',
                    ],
                    'borderColor' => [
                        'rgba(59, 130, 246, 1)',
                        'rgba(34, 197, 94, 1)',
                        'rgba(251, 146, 60, 1)',
                        'rgba(168, 85, 247, 1)',
                        'rgba(236, 72, 153, 1)',
                    ],
                    'borderWidth' => 2,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getOptions(): array
    {
        return [
            'scales' => [
                'x' => [
                    'ticks' => [
                        'display' => false, // hide label nama pengujian
                    ],
                ],
            ],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
