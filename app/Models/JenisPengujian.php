<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class JenisPengujian extends Model
{
    protected $fillable = [
        'nama_pengujian',
        'biaya',
        'deskripsi'
    ];

    protected $casts = [
        'biaya' => 'decimal:2'
    ];

    public function permohonans(): BelongsToMany
    {
        return $this->belongsToMany(Permohonan::class, 'permohonan_pengujian');
    }
}