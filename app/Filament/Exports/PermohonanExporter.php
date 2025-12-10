<?php

namespace App\Filament\Exports;

use App\Models\Permohonan;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class PermohonanExporter extends Exporter
{
    protected static ?string $model = Permohonan::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('judul')
                ->label('Judul Permohonan'),
            ExportColumn::make('status')
                ->label('Status')
                ->formatStateUsing(fn (string $state): string => match ($state) {
                    'menunggu_verifikasi' => 'Menunggu Verifikasi',
                    'perlu_perbaikan' => 'Perlu Perbaikan',
                    'menunggu_pembayaran_sampel' => 'Menunggu Pembayaran & Sampel',
                    'sedang_diuji' => 'Sedang Diuji',
                    'menyusun_laporan' => 'Menyusun Laporan',
                    'selesai' => 'Selesai',
                    default => $state,
                }),
            ExportColumn::make('pemohon.name')
                ->label('Pemohon'),
            ExportColumn::make('worker.name')
                ->label('Petugas'),
            ExportColumn::make('total_biaya')
                ->label('Total Biaya')
                ->formatStateUsing(fn ($state): string => 'Rp ' . number_format($state, 0, ',', '.')),
            ExportColumn::make('is_paid')
                ->label('Pembayaran Selesai')
                ->formatStateUsing(fn (bool $state): string => $state ? 'Ya' : 'Tidak'),
            ExportColumn::make('is_sample_ready')
                ->label('Sampel Diterima')
                ->formatStateUsing(fn (bool $state): string => $state ? 'Ya' : 'Tidak'),
            ExportColumn::make('verified_at')
                ->label('Waktu Verifikasi'),
            ExportColumn::make('sample_received_at')
                ->label('Waktu Sampel Diterima'),
            ExportColumn::make('testing_started_at')
                ->label('Waktu Pengujian Dimulai'),
            ExportColumn::make('testing_ended_at')
                ->label('Waktu Pengujian Selesai'),
            ExportColumn::make('completed_at')
                ->label('Waktu Penyelesaian'),
            ExportColumn::make('created_at')
                ->label('Dibuat Pada'),
            ExportColumn::make('updated_at')
                ->label('Diperbarui Pada'),
        ];
    }

    public function getFileName(Export $export): string
    {
        return "permohonan-{$export->getKey()}.xlsx";
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        return "Rekap Permohonan berhasil diunduh.";
    }
}
