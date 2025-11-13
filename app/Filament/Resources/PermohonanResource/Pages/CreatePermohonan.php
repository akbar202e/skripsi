<?php

namespace App\Filament\Resources\PermohonanResource\Pages;

use App\Filament\Resources\PermohonanResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePermohonan extends CreateRecord
{
    protected static string $resource = PermohonanResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Ensure the authenticated user is set as pemohon
        $data['user_id'] = auth()->id();

        // Calculate total biaya from selected jenis pengujian ids
        $jenis = $data['jenis_pengujian'] ?? [];
        if (!empty($jenis)) {
            $data['total_biaya'] = \App\Models\JenisPengujian::whereIn('id', $jenis)->sum('biaya');
        }
        // Default status
        $data['status'] = $data['status'] ?? 'permohonan_masuk';

        return $data;
    }

    protected function afterCreate(): void
    {
        // Sync the many-to-many relationship after the record exists
        $jenis = $this->form->getState()['jenis_pengujian'] ?? [];
        if (!empty($jenis)) {
            $this->record->jenisPengujians()->sync($jenis);
        }
    }
}
