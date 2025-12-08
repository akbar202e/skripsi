<?php

namespace App\Filament\Resources\PermohonanResource\Pages;

use App\Filament\Resources\PermohonanResource;
use App\Models\Permohonan;
use Filament\Actions;
use Filament\Forms;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;

class ViewPermohonan extends ViewRecord
{
    protected static string $resource = PermohonanResource::class;

    protected function getHeaderActions(): array
    {
        $record = $this->record;
        $actions = [
            Actions\EditAction::make(),
        ];

        // Tombol Pembayaran untuk user yang mengajukan
        if (auth()->user()->id === $record->user_id) {
            if ($record->status === 'menunggu_pembayaran_sampel' && !$record->is_paid) {
                $actions[] = Actions\Action::make('lakukan_pembayaran')
                    ->label('Lakukan Pembayaran')
                    ->icon('heroicon-o-credit-card')
                    ->color('success')
                    ->url(route('payment.show', $record))
                    ->openUrlInNewTab();
            }
        }

        // Add status action buttons based on current status
        if (auth()->user()?->hasRole('Petugas')) {
            if ($record->status === 'menunggu_verifikasi' && ($record->worker_id === null || $record->worker_id === auth()->id())) {
                $actions[] = Actions\Action::make('lanjut_pembayaran_sampel')
                    ->label('Terima - Lanjut Pembayaran & Sampel')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->action(function () use ($record) {
                        $record->update([
                            'status' => 'menunggu_pembayaran_sampel',
                            'worker_id' => auth()->id(),
                            'keterangan' => null // Clear keterangan when accepting
                        ]);
                        $this->dispatch('refreshPageData');
                    });

                $actions[] = Actions\Action::make('tolak_perbaikan')
                    ->label('Tolak - Perlu Perbaikan')
                    ->icon('heroicon-o-x-mark')
                    ->color('danger')
                    ->form([
                        Forms\Components\Textarea::make('keterangan')
                            ->label('Keterangan Perbaikan')
                            ->required(),
                    ])
                    ->action(function (array $data) use ($record) {
                        $record->update([
                            'status' => 'perlu_perbaikan',
                            'keterangan' => $data['keterangan'],
                            'worker_id' => auth()->id()
                        ]);
                        $this->dispatch('refreshPageData');
                    });
            }

            if ($record->status === 'menunggu_pembayaran_sampel' && $record->worker_id === auth()->id() && !$record->is_sample_ready) {
                $actions[] = Actions\Action::make('konfirmasi_sampel')
                    ->label('Konfirmasi Sampel Diterima')
                    ->icon('heroicon-o-inbox-stack')
                    ->color('info')
                    ->requiresConfirmation()
                    ->modalHeading('Konfirmasi Sampel Diterima')
                    ->modalDescription('Apakah Anda yakin sampel sudah diterima dari pemohon? Centang "Sampel Sudah Diterima" akan membuka halaman pengujian.')
                    ->action(function () use ($record) {
                        $record->update(['is_sample_ready' => true]);
                        $this->dispatch('refreshPageData');
                        Notification::make()
                            ->success()
                            ->title('Konfirmasi Berhasil')
                            ->body('Sampel telah dikonfirmasi diterima.')
                            ->send();
                    });
            }
            
            if ($record->status === 'menunggu_pembayaran_sampel' && $record->worker_id === auth()->id() && $record->is_paid && $record->is_sample_ready) {
                $actions[] = Actions\Action::make('mulai_pengujian')
                    ->label('Mulai Pengujian')
                    ->icon('heroicon-o-beaker')
                    ->color('info')
                    ->requiresConfirmation()
                    ->action(function () use ($record) {
                        $record->update(['status' => 'sedang_diuji']);
                        $this->dispatch('refreshPageData');
                    });
            }

            if ($record->status === 'sedang_diuji' && $record->worker_id === auth()->id()) {
                $actions[] = Actions\Action::make('selesai_pengujian')
                    ->label('Selesai Pengujian - Menyusun Laporan')
                    ->icon('heroicon-o-document-text')
                    ->color('warning')
                    ->requiresConfirmation()
                    ->action(function () use ($record) {
                        $record->update(['status' => 'menyusun_laporan']);
                        $this->dispatch('refreshPageData');
                    });
            }

            if ($record->status === 'menyusun_laporan' && $record->worker_id === auth()->id()) {
                $actions[] = Actions\Action::make('finalisasi_selesai')
                    ->label('Finalisasi - Selesai')
                    ->icon('heroicon-o-check-badge')
                    ->color('success')
                    ->form([
                        Forms\Components\FileUpload::make('laporan_hasil')
                            ->label('Upload Laporan Hasil (PDF)')
                            ->acceptedFileTypes(['application/pdf'])
                            ->directory('permohonan')
                            ->disk('public')
                            ->required(),
                    ])
                    ->action(function (array $data) use ($record) {
                        $record->update([
                            'status' => 'selesai',
                            'laporan_hasil' => $data['laporan_hasil']
                        ]);
                        $this->dispatch('refreshPageData');
                    });
            }
        }

        return $actions;
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make('Informasi Permohonan')
                    ->schema([
                        Infolists\Components\TextEntry::make('judul'),
                        Infolists\Components\TextEntry::make('isi'),
                        Infolists\Components\TextEntry::make('status')
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
                            }),
                        Infolists\Components\TextEntry::make('pemohon.name')
                            ->label('Pemohon'),
                        Infolists\Components\TextEntry::make('worker.name')
                            ->label('Petugas'),
                    ])
                    ->columns(2),
                Infolists\Components\Section::make('Detail Pengujian')
                    ->schema([
                        Infolists\Components\RepeatableEntry::make('jenisPengujians')
                            ->schema([
                                Infolists\Components\TextEntry::make('nama_pengujian')
                                    ->label('Jenis Pengujian'),
                                Infolists\Components\TextEntry::make('biaya')
                                    ->label('Biaya Per Sampel')
                                    ->money('IDR'),
                                Infolists\Components\TextEntry::make('pivot.jumlah_sampel')
                                    ->label('Jumlah Sampel'),
                                Infolists\Components\TextEntry::make('total_harga')
                                    ->label('Total Harga')
                                    ->state(function ($record) {
                                        return $record->biaya * $record->pivot->jumlah_sampel;
                                    })
                                    ->money('IDR'),
                            ])
                            ->columns(4),
                    ]),
                Infolists\Components\Section::make('Biaya')
                    ->schema([
                        Infolists\Components\TextEntry::make('total_biaya')
                            ->label('Total Biaya Permohonan')
                            ->money('IDR'),
                    ]),
                Infolists\Components\Section::make('File')
                    ->schema([
                        Infolists\Components\TextEntry::make('surat_permohonan')
                            ->label('Surat Permohonan')
                            ->url(fn ($state) => $state ? url('/storage/' . $state) : null)
                            ->openUrlInNewTab(),
                        Infolists\Components\TextEntry::make('laporan_hasil')
                            ->label('Laporan Hasil')
                            ->url(fn ($state) => $state ? url('/storage/' . $state) : null)
                            ->openUrlInNewTab()
                            ->visible(fn () => $this->record->laporan_hasil !== null),
                    ]),
                Infolists\Components\Section::make('Keterangan')
                    ->schema([
                        Infolists\Components\TextEntry::make('keterangan')
                            ->label('Keterangan Perbaikan')
                            ->visible(fn () => $this->record->keterangan !== null),
                    ]),
            ]);
    }
}
