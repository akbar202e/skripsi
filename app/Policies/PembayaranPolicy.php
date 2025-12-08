<?php

namespace App\Policies;

use App\Models\Pembayaran;
use App\Models\User;

class PembayaranPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasRole(['Admin', 'Petugas', 'Pemohon']);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Pembayaran $pembayaran): bool
    {
        // Admin dan Petugas bisa lihat semua
        if ($user->hasRole(['Admin', 'Petugas'])) {
            return true;
        }
        
        // Pemohon hanya bisa lihat pembayaran miliknya sendiri
        if ($user->hasRole('Pemohon')) {
            return $user->id === $pembayaran->user_id;
        }
        
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasRole(['Admin', 'Petugas']);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Pembayaran $pembayaran): bool
    {
        return $user->hasRole(['Admin', 'Petugas']);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Pembayaran $pembayaran): bool
    {
        return $user->hasRole(['Admin', 'Petugas']);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Pembayaran $pembayaran): bool
    {
        return $user->hasRole(['Admin', 'Petugas']);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Pembayaran $pembayaran): bool
    {
        return $user->hasRole(['Admin', 'Petugas']);
    }
}
