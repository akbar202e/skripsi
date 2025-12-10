<?php

namespace App\Filament\Exports;

use App\Models\JenisPengujian;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class JenisPengujianExporter extends Exporter
{
    protected static ?string $model = JenisPengujian::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('nama')
                ->label('Nama Jenis Pengujian'),
            ExportColumn::make('harga')
                ->label('Harga')
                ->formatStateUsing(fn ($state): string => 'Rp ' . number_format($state, 0, ',', '.')),
            ExportColumn::make('deskripsi')
                ->label('Deskripsi'),
            ExportColumn::make('is_active')
                ->label('Aktif')
                ->formatStateUsing(fn (bool $state): string => $state ? 'Ya' : 'Tidak'),
            ExportColumn::make('created_at')
                ->label('Dibuat Pada'),
            ExportColumn::make('updated_at')
                ->label('Diperbarui Pada'),
        ];
    }

    public function getFileName(Export $export): string
    {
        return "jenis-pengujian-{$export->getKey()}.xlsx";
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        return "Rekap Jenis Pengujian berhasil diunduh.";
    }
}
