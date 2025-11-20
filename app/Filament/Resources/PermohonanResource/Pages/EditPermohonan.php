<?php

namespace App\Filament\Resources\PermohonanResource\Pages;

use App\Filament\Resources\PermohonanResource;
use Filament\Actions;
use Filament\Forms;
use Filament\Resources\Pages\EditRecord;

class EditPermohonan extends EditRecord
{
    protected static string $resource = PermohonanResource::class;

    protected array $jenisPengujians = [];

    public function form(Forms\Form $form): Forms\Form
    {
        return parent::form($form)
            ->schema([
                Forms\Components\Section::make('Informasi Permohonan')
                    ->schema([
                        Forms\Components\TextInput::make('judul')
                            ->required()
                            ->maxLength(100)
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make('isi')
                            ->required()
                            ->rows(10)
                            ->columnSpanFull(),
                        Forms\Components\FileUpload::make('surat_permohonan')
                            ->label('Upload Surat Permohonan (PDF)')
                            ->acceptedFileTypes(['application/pdf'])
                            ->directory('permohonan')
                            ->disk('public')
                            ->downloadable()
                            ->openable()
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
                Forms\Components\Section::make('Jenis Pengujian & Jumlah Sampel')
                    ->description('Tambah atau ubah jenis pengujian yang ingin diuji')
                    ->schema([
                        Forms\Components\Repeater::make('jenisPengujians')
                            ->label('')
                            ->schema([
                                Forms\Components\Select::make('id')
                                    ->label('Jenis Pengujian')
                                    ->options(\App\Models\JenisPengujian::pluck('nama_pengujian', 'id'))
                                    ->required()
                                    ->searchable()
                                    ->distinct()
                                    ->disableOptionsWhenSelectedInSiblingRepeaterItems()
                                    ->columnSpan(2),
                                Forms\Components\TextInput::make('jumlah_sampel')
                                    ->label('Jumlah Sampel')
                                    ->numeric()
                                    ->required()
                                    ->minValue(1)
                                    ->default(1)
                                    ->columnSpan(1),
                                Forms\Components\Placeholder::make('biaya_info')
                                    ->label('Info')
                                    ->content(fn ($state, $record) => 
                                        $record && $record->biaya 
                                            ? 'Rp ' . number_format($record->biaya, 0, ',', '.') . '/item'
                                            : 'Pilih jenis pengujian terlebih dahulu'
                                    )
                                    ->columnSpan(1),
                            ])
                            ->columns(4)
                            ->addActionLabel('Tambah Jenis Pengujian')
                            ->reorderable(false)
                            ->columnSpanFull(),
                    ])
                    ->columns(1),
                Forms\Components\Section::make('Biaya & Laporan')
                    ->schema([
                        Forms\Components\TextInput::make('total_biaya')
                            ->label('Total Biaya Permohonan')
                            ->prefix('Rp')
                            ->numeric()
                            ->readOnly()
                            ->columnSpan(1),
                        Forms\Components\FileUpload::make('laporan_hasil')
                            ->label('Upload Laporan Hasil (PDF)')
                            ->acceptedFileTypes(['application/pdf'])
                            ->directory('permohonan')
                            ->disk('public')
                            ->downloadable()
                            ->openable()
                            ->visible(fn (Forms\Get $get) => in_array($get('status'), ['menyusun_laporan', 'selesai']))
                            ->columnSpan(1),
                    ])
                    ->columns(2),
                Forms\Components\Section::make('Keterangan Perbaikan')
                    ->schema([
                        Forms\Components\Placeholder::make('keterangan')
                            ->label('Keterangan')
                            ->content(fn ($record): ?string => $record?->keterangan)
                            ->columnSpanFull()
                            ->hidden(fn ($record): bool => empty($record?->keterangan)),
                    ])
                    ->hidden(fn ($record): bool => empty($record?->keterangan)),
            ]);
    }

    protected function fillForm(): void
    {
        parent::fillForm();

        // Load jenisPengujians data into repeater with correct structure
        $jenisPengujians = $this->record->jenisPengujians->map(function ($jenis) {
            return [
                'id' => $jenis->id,
                'jumlah_sampel' => $jenis->pivot->jumlah_sampel,
            ];
        })->toArray();

        $this->form->fill(array_merge(
            $this->record->toArray(),
            ['jenisPengujians' => $jenisPengujians]
        ));
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // If the pemohon is editing after receiving a "perlu_perbaikan" request,
        // reset status back to menunggu_verifikasi so petugas can re-verify.
        if (auth()->user()->hasRole('Pemohon') && $this->record->status === 'perlu_perbaikan') {
            $data['status'] = 'menunggu_verifikasi';
            // Clear the keterangan perbaikan when resubmitting
            $data['keterangan'] = null;
        }

        // Extract jenisPengujians data untuk di-sync setelah save
        $this->jenisPengujians = $data['jenisPengujians'] ?? [];
        unset($data['jenisPengujians']);

        return $data;
    }

    protected function afterSave(): void
    {
        // Sync the jenis pengujian dengan pivot data
        if (!empty($this->jenisPengujians)) {
            $syncData = [];
            foreach ($this->jenisPengujians as $item) {
                $syncData[$item['id']] = ['jumlah_sampel' => $item['jumlah_sampel'] ?? 1];
            }
            $this->record->jenisPengujians()->sync($syncData);
        }
        // Recalculate total biaya
        $this->calculateTotalBiaya();
    }

    protected function calculateTotalBiaya(): void
    {
        $total = 0;
        foreach ($this->record->jenisPengujians as $jenis) {
            $total += $jenis->biaya * $jenis->pivot->jumlah_sampel;
        }
        $this->record->update(['total_biaya' => $total]);
    }
}



