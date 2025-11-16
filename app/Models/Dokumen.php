<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Dokumen extends Model
{
    protected $fillable = [
        'judul',
        'deskripsi',
        'kategori',
        'image_path',
        'created_by',
    ];

    protected $casts = [
        'kategori' => 'string',
    ];

    /**
     * Get the user that created the dokumen
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
}
