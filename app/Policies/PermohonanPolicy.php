<?php

namespace App\Policies;

use App\Models\Permohonan;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PermohonanPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        // Pimpinan dan Admin bisa lihat semua permohonan
        if ($user->hasRole(['Pimpinan', 'Admin'])) {
            return true;
        }
        
        // Petugas dan Pemohon juga bisa lihat
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Permohonan $permohonan): bool
    {
        // Pimpinan dan Admin bisa lihat semua permohonan
        if ($user->hasRole(['Pimpinan', 'Admin'])) {
            return true;
        }
        
        // Petugas bisa lihat semua
        if ($user->hasRole('Petugas')) {
            return true;
        }
        
        // Pemohon hanya bisa lihat punya sendiri
        if ($user->hasRole('Pemohon')) {
            return $permohonan->user_id === $user->id;
        }
        
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return auth()->user()->hasRole('Pemohon');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Permohonan $permohonan): bool
    {
        return auth()->user()->hasRole('Pemohon') && 
        $permohonan->user_id === $user->id &&
        in_array($permohonan->status, ['permohonan_masuk','perlu_perbaikan']);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Permohonan $permohonan): bool
    {
        return true;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Permohonan $permohonan): bool
    {
        return true;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Permohonan $permohonan): bool
    {
        return true;
    }
}
