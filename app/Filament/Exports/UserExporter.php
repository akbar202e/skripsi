<?php

namespace App\Filament\Exports;

use App\Models\User;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class UserExporter extends Exporter
{
    protected static ?string $model = User::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('name')
                ->label('Nama'),
            ExportColumn::make('email')
                ->label('Email'),
            ExportColumn::make('phone_number')
                ->label('Nomor Telepon'),
            ExportColumn::make('created_at')
                ->label('Dibuat Pada'),
            ExportColumn::make('updated_at')
                ->label('Diperbarui Pada'),
        ];
    }

    public function getFileName(Export $export): string
    {
        return "users-{$export->getKey()}";
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        return "Rekap Pengguna berhasil diunduh.";
    }
}
