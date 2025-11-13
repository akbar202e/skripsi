<?php

namespace App\Filament\Resources\PermohonanResource\Pages;

use App\Filament\Resources\PermohonanResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPermohonan extends EditRecord
{
    protected static string $resource = PermohonanResource::class;

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
        // reset status back to permohonan_masuk so petugas can re-verify.
        // if (auth()->user()->hasRole('Pemohon') && $this->record->status === 'perlu_perbaikan') {
            $data['status'] = 'permohonan_masuk';
        

        // Recalculate total biaya if jenis_pengujian changed
        $jenis = $data['jenis_pengujian'] ?? [];
        if (!empty($jenis)) {
            $data['total_biaya'] = \App\Models\JenisPengujian::whereIn('id', $jenis)->sum('biaya');
        }

        return $data;
    }

    protected function afterSave(): void
    {
        // Sync pivot relationship after saving
        $jenis = $this->form->getState()['jenis_pengujian'] ?? [];
        if (!empty($jenis)) {
            $this->record->jenisPengujians()->sync($jenis);
        }
    }
}
