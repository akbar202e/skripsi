<?php

namespace App\Filament\Resources\PermohonanResource\Pages;

use App\Filament\Resources\PermohonanResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewPermohonan extends ViewRecord
{
    protected static string $resource = PermohonanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
            // Actions\Action::make('terverifikasi')
            //     ->color('success')
            //     ->label('Verifikasi')
            //     ->visible(fn () => auth()->user()->hasRole('Petugas') && $this->record->status === 'diproses' && $this->record->worker_id === auth()->id())
            //     ->form([
            //         \Filament\Forms\Components\Textarea::make('keterangan')
            //             ->label('Keterangan Tambahan')
            //             ->rows(3)
            //             ->placeholder('Tambahkan keterangan jika diperlukan'),
            //     ])
            //     ->action(function (array $data) {
            //         $this->record->update(['status' => 'terverifikasi', 'keterangan' => $data['keterangan']])
            //     ;}),
            // Actions\Action::make('dibatalkan')
            //     ->color('danger')
            //     ->label('Batalkan')
            //     ->visible(fn () => auth()->user()->hasRole('Petugas') && $this->record->status === 'diproses' && $this->record->worker_id === auth()->id())
            //     ->form([
            //         \Filament\Forms\Components\Textarea::make('keterangan')
            //             ->label('Keterangan Tambahan')
            //             ->rows(3)
            //             ->placeholder('Tambahkan keterangan jika diperlukan'),
            //     ])
            //     ->action(function (array $data) {
            //         $this->record->update(['status' => 'dibatalkan', 'keterangan' => $data['keterangan']])
            //     ;}),
            // Actions\Action::make('perlu perbaikan')
            //     ->color('info')
            //     ->label('Perlu Perbaikan')
            //     ->visible(fn () => auth()->user()->hasRole('Petugas') && $this->record->status === 'diproses' && $this->record->worker_id === auth()->id())
            //     ->form([
            //         \Filament\Forms\Components\Textarea::make('keterangan')
            //             ->label('Keterangan Tambahan')
            //             ->rows(3)
            //             ->placeholder('Tambahkan keterangan jika diperlukan'),
            //     ])
            //     ->action(function (array $data) {
            //         $this->record->update(['status' => 'perlu perbaikan', 'keterangan' => $data['keterangan']])
            //     ;})
        ];
    }
}
