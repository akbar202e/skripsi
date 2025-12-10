<?php

namespace App\Observers;

use App\Models\Permohonan;

class PermohonanObserver
{
    public function creating(Permohonan $permohonan): void
    {
        $permohonan->user_id = auth()->id();
    }
    public function updating(Permohonan $permohonan): void
    {
        // Record timestamps based on status changes
        if ($permohonan->isDirty('status')) {
            $newStatus = $permohonan->status;
            $now = now();

            match ($newStatus) {
                'menunggu_pembayaran_sampel' => $permohonan->verified_at = $now,
                'sedang_diuji' => $permohonan->testing_started_at = $now,
                'menyusun_laporan' => $permohonan->report_started_at = $now,
                'selesai' => $permohonan->completed_at = $now,
                default => null,
            };

            // Also set sample_received_at when is_sample_ready is set to true
            if ($permohonan->isDirty('is_sample_ready') && $permohonan->is_sample_ready) {
                $permohonan->sample_received_at = $now;
            }
        }
    }
    /**
     * Handle the Permohonan "created" event.
     */
    public function created(Permohonan $permohonan): void
    {
        //
    }

    /**
     * Handle the Permohonan "updated" event.
     */
    public function updated(Permohonan $permohonan): void
    {
        //
    }

    /**
     * Handle the Permohonan "deleted" event.
     */
    public function deleted(Permohonan $permohonan): void
    {
        //
    }

    /**
     * Handle the Permohonan "restored" event.
     */
    public function restored(Permohonan $permohonan): void
    {
        //
    }

    /**
     * Handle the Permohonan "force deleted" event.
     */
    public function forceDeleted(Permohonan $permohonan): void
    {
        //
    }
}
