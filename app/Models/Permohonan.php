<?php

namespace App\Models;

use App\Observers\PermohonanObserver;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;

#[ObservedBy(PermohonanObserver::class)]
class Permohonan extends Model
{
    use SoftDeletes;

    /**
     * Get the user that owns the permohonan
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function pemohon(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
