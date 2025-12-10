<?php

namespace App\Filament\Widgets;

use App\Models\Permohonan;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class BottleneckDetectionWidget extends BaseWidget
{
    protected static ?int $sort = 5;
protected int | string | array $columnSpan = 'full';    
    public static function canView(): bool
    {
        return auth()->check() && (auth()->user()->hasRole('Admin') || auth()->user()->hasRole('Petugas'));
    }

    public function getHeading(): ?string
    {
        return 'Bottleneck Detection - Tahap Tertunda';
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(function () {
                $query = Permohonan::query()
                    ->select([
                        'id',
                        'judul',
                        'status',
                        'verified_at',
                        'sample_received_at',
                        'testing_started_at',
                        'testing_ended_at',
                        'report_started_at',
                        'completed_at',
                    ])
                    ->where('status', '!=', 'selesai')
                    ->whereNotNull('verified_at');

                // Filter by user if Pemohon
                if (auth()->user()->hasRole('Pemohon')) {
                    $query->where('user_id', auth()->user()->id);
                }

                return $query->orderByRaw('GREATEST(
                        COALESCE(sample_received_at, NOW()),
                        COALESCE(testing_started_at, NOW()),
                        COALESCE(report_started_at, NOW())
                    ) DESC')
                    ->limit(10);
            })
            ->columns([
                TextColumn::make('judul')
                    ->label('Judul Permohonan')
                    ->limit(30),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (Permohonan $record): string => match ($record->status) {
                        'menunggu_verifikasi' => 'gray',
                        'perlu_perbaikan' => 'warning',
                        'menunggu_pembayaran_sampel' => 'info',
                        'sedang_diuji' => 'info',
                        'menyusun_laporan' => 'warning',
                        'selesai' => 'success',
                        default => 'secondary',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'menunggu_verifikasi' => 'Menunggu Verifikasi',
                        'perlu_perbaikan' => 'Perlu Perbaikan',
                        'menunggu_pembayaran_sampel' => 'Menunggu Pembayaran & Sampel',
                        'sedang_diuji' => 'Sedang Diuji',
                        'menyusun_laporan' => 'Menyusun Laporan',
                        'selesai' => 'Selesai',
                        default => 'Unknown',
                    })
                    ->label('Status Saat Ini'),
                TextColumn::make('id')
                    ->label('Durasi Pengujian Saat Ini')
                    ->formatStateUsing(function (Permohonan $record) {
                        $lastTimestamp = collect([
                            $record->sample_received_at,
                            $record->testing_started_at,
                            $record->report_started_at,
                        ])->filter()->max();

                        if (!$lastTimestamp) {
                            return '-';
                        }

                        $hours = $lastTimestamp->diffInHours(now(), absolute: true);
                        if ($hours < 1) {
                            $minutes = abs(now()->diffInMinutes($lastTimestamp));
                            return round($minutes, 1) . ' menit';
                        }
                        if ($hours < 24) {
                            return round($hours, 1) . ' jam';
                        }
                        return ceil($hours / 24) . ' hari';
                    })
                    ->sortable(false)
                    ->searchable(false),
            ])
            ->paginated([10]);
    }
}
