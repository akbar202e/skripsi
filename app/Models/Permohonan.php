<?php

namespace App\Models;

use App\Observers\PermohonanObserver;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;

#[ObservedBy(PermohonanObserver::class)]
class Permohonan extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'judul',
        'isi',
        'user_id',
        'worker_id',
        'status',
        'surat_permohonan',
        'laporan_hasil',
        'total_biaya',
        'keterangan',
        'is_paid',
        'is_sample_ready'
    ];

    protected $casts = [
        'total_biaya' => 'decimal:2',
        'is_paid' => 'boolean',
        'is_sample_ready' => 'boolean',
    ];

    /**
     * Get the user that owns the permohonan
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function pemohon(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function worker(): BelongsTo
    {
        return $this->belongsTo(User::class, 'worker_id', 'id');
    }

    public function jenisPengujians(): BelongsToMany
    {
        return $this->belongsToMany(JenisPengujian::class, 'permohonan_pengujian')
            ->withPivot('jumlah_sampel')
            ->withTimestamps();
    }

    /**
     * Get the payments for this permohonan
     */
    public function pembayarans(): HasMany
    {
        return $this->hasMany(Pembayaran::class);
    }

    /**
     * Get the latest payment
     */
    public function latestPembayaran()
    {
        return $this->hasOne(Pembayaran::class)->latestOfMany();
    }
}
