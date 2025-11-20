<?php

namespace App\Filament\Resources\PermohonanResource\Pages;

use App\Filament\Resources\PermohonanResource;
use Filament\Actions;
use Filament\Forms;
use Filament\Resources\Pages\CreateRecord;

class CreatePermohonan extends CreateRecord
{
    protected static string $resource = PermohonanResource::class;

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
                    ->description('Pilih jenis pengujian dan jumlah sampel yang ingin diuji')
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
                                    ->columnSpan(2),
                            ])
                            ->columns(4)
                            ->addActionLabel('Tambah Pengujian Lain')
                            ->reorderable(false)
                            ->columnSpanFull(),
                    ])
                    ->columns(1),
            ]);
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Ensure the authenticated user is set as pemohon
        $data['user_id'] = auth()->id();

        // Default status
        $data['status'] = $data['status'] ?? 'menunggu_verifikasi';

        // Total biaya will be calculated after the record is created and relationships are synced
        $data['total_biaya'] = 0;

        // Extract jenisPengujians data untuk di-sync setelah create
        $this->jenisPengujians = $data['jenisPengujians'] ?? [];
        unset($data['jenisPengujians']);

        return $data;
    }

    protected function afterCreate(): void
    {
        // Sync the jenis pengujian dengan pivot data
        if (!empty($this->jenisPengujians)) {
            $syncData = [];
            foreach ($this->jenisPengujians as $item) {
                $syncData[$item['id']] = ['jumlah_sampel' => $item['jumlah_sampel'] ?? 1];
            }
            $this->record->jenisPengujians()->sync($syncData);
        }

        // Recalculate total biaya based on pivot data
        $this->calculateTotalBiaya();
    }

    protected function calculateTotalBiaya(): void
    {
        $total = 0;
        $this->record->refresh();
        foreach ($this->record->jenisPengujians as $jenis) {
            $total += $jenis->biaya * $jenis->pivot->jumlah_sampel;
        }
        $this->record->update(['total_biaya' => $total]);
    }
}
