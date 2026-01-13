<?php

namespace App\Filament\Exports;

use App\Models\Dokumen;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class DokumenExporter extends Exporter
{
    protected static ?string $model = Dokumen::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('nama')
                ->label('Nama Dokumen'),
            ExportColumn::make('jenis_dokumen')
                ->label('Jenis Dokumen')
                ->formatStateUsing(fn (string $state): string => ucfirst(str_replace('_', ' ', $state))),
            ExportColumn::make('permohonan.judul')
                ->label('Judul Permohonan'),
            ExportColumn::make('file_path')
                ->label('Path File'),
            ExportColumn::make('uploaded_by')
                ->label('Diupload Oleh'),
            ExportColumn::make('uploaded_at')
                ->label('Waktu Upload'),
            ExportColumn::make('created_at')
                ->label('Dibuat Pada'),
            ExportColumn::make('updated_at')
                ->label('Diperbarui Pada'),
        ];
    }

    public function getFileName(Export $export): string
    {
        return "dokumen-{$export->getKey()}";
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        return "Rekap Dokumen berhasil diunduh.";
    }
}
