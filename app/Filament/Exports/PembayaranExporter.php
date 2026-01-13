<?php

namespace App\Filament\Exports;

use App\Models\Pembayaran;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class PembayaranExporter extends Exporter
{
    protected static ?string $model = Pembayaran::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('permohonan.judul')
                ->label('Judul Permohonan'),
            ExportColumn::make('user.name')
                ->label('Nama Pembayar'),
            ExportColumn::make('amount')
                ->label('Nominal')
                ->formatStateUsing(fn ($state): string => 'Rp ' . number_format($state, 0, ',', '.')),
            ExportColumn::make('payment_method')
                ->label('Metode Pembayaran'),
            ExportColumn::make('payment_method_name')
                ->label('Nama Metode'),
            ExportColumn::make('merchant_order_id')
                ->label('Merchant Order ID'),
            ExportColumn::make('duitku_reference')
                ->label('Referensi Duitku'),
            ExportColumn::make('status')
                ->label('Status')
                ->formatStateUsing(fn (string $state): string => match ($state) {
                    'pending' => 'Menunggu',
                    'success' => 'Berhasil',
                    'failed' => 'Gagal',
                    'expired' => 'Kadaluarsa',
                    default => $state,
                }),
            ExportColumn::make('result_code')
                ->label('Result Code'),
            ExportColumn::make('paid_at')
                ->label('Waktu Pembayaran'),
            ExportColumn::make('notes')
                ->label('Catatan'),
            ExportColumn::make('created_at')
                ->label('Dibuat Pada'),
            ExportColumn::make('updated_at')
                ->label('Diperbarui Pada'),
        ];
    }

    public function getFileName(Export $export): string
    {
        return "pembayaran-{$export->getKey()}";
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        return "Rekap Pembayaran berhasil diunduh.";
    }
}
