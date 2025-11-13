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
        // $permohonan->worker_id = auth()->id();
        // $permohonan->status = 'menunggu verifikasi';
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
