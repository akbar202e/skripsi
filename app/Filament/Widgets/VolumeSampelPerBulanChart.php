<?php

namespace App\Filament\Widgets;

use App\Models\Permohonan;
use Filament\Widgets\ChartWidget;

class VolumeSampelPerBulanChart extends ChartWidget
{
    protected static ?int $sort = 3;

    public static function canView(): bool
    {
        return auth()->check() && (auth()->user()->hasRole('Admin') || auth()->user()->hasRole('Petugas'));
    }

    public function getHeading(): ?string
    {
        return 'Volume Sampel Masuk Per Bulan';
    }

    protected function getData(): array
    {
        $data = Permohonan::query()
            ->selectRaw('MONTH(permohonans.created_at) as month, YEAR(permohonans.created_at) as year, SUM(permohonan_pengujian.jumlah_sampel) as total')
            ->leftJoin('permohonan_pengujian', 'permohonans.id', '=', 'permohonan_pengujian.permohonan_id')
            ->whereYear('permohonans.created_at', now()->year)
            ->groupBy('year', 'month')
            ->orderBy('month')
            ->get();

        $months = [
            'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun',
            'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'
        ];

        $chartData = array_fill(0, 12, 0);
        foreach ($data as $item) {
            $chartData[$item->month - 1] = (int) ($item->total ?? 0);
        }

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Sampel',
                    'data' => $chartData,
                    'backgroundColor' => 'rgba(79, 172, 254, 0.5)',
                    'borderColor' => 'rgba(79, 172, 254, 1)',
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
}
