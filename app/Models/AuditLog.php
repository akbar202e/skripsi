<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;

/**
 * AuditLog Model
 * 
 * Menyimpan audit trail untuk semua aktifitas sensitif di sistem
 * termasuk: login, logout, create, update, delete, dan payment operations.
 * 
 * @property int $id
 * @property int|null $user_id
 * @property string $action
 * @property string|null $model
 * @property int|null $model_id
 * @property array|null $old_values
 * @property array|null $new_values
 * @property string $ip_address
 * @property string $user_agent
 * @property \Illuminate\Support\Carbon $created_at
 */
class AuditLog extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'action',
        'model',
        'model_id',
        'old_values',
        'new_values',
        'ip_address',
        'user_agent',
        'created_at',
    ];

    protected $casts = [
        'old_values' => 'json',
        'new_values' => 'json',
        'created_at' => 'datetime',
    ];

    /**
     * Relationship dengan User
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Create audit log entry
     * 
     * @param string $action
     * @param string|null $model
     * @param int|null $modelId
     * @param array|null $oldValues
     * @param array|null $newValues
     * @return void
     */
    public static function log(
        string $action,
        ?string $model = null,
        ?int $modelId = null,
        ?array $oldValues = null,
        ?array $newValues = null
    ): void {
        self::create([
            'user_id' => auth()->id(),
            'action' => $action,
            'model' => $model,
            'model_id' => $modelId,
            'old_values' => $oldValues,
            'new_values' => $newValues,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'created_at' => now(),
        ]);
    }

    /**
     * Scope untuk filter berdasarkan aksi
     */
    public function scopeByAction(Builder $query, string $action): Builder
    {
        return $query->where('action', $action);
    }

    /**
     * Scope untuk filter berdasarkan user
     */
    public function scopeByUser(Builder $query, int $userId): Builder
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope untuk filter berdasarkan IP address
     */
    public function scopeByIpAddress(Builder $query, string $ip): Builder
    {
        return $query->where('ip_address', $ip);
    }

    /**
     * Scope untuk filter berdasarkan model
     */
    public function scopeByModel(Builder $query, string $model): Builder
    {
        return $query->where('model', $model);
    }

    /**
     * Scope untuk filter by date range
     */
    public function scopeInDateRange(Builder $query, $from, $to): Builder
    {
        return $query->whereBetween('created_at', [$from, $to]);
    }

    /**
     * Get failed login attempts untuk user
     */
    public static function getFailedLoginAttempts(int $userId, int $minutes = 15): int
    {
        return self::byUser($userId)
            ->byAction('failed_login')
            ->where('created_at', '>=', now()->subMinutes($minutes))
            ->count();
    }

    /**
     * Get suspicious activities (banyak failed logins)
     */
    public static function getSuspiciousActivities(int $maxAttempts = 5, int $minutes = 15)
    {
        return self::byAction('failed_login')
            ->where('created_at', '>=', now()->subMinutes($minutes))
            ->groupBy('user_id')
            ->selectRaw('user_id, COUNT(*) as attempt_count')
            ->havingRaw('COUNT(*) >= ?', [$maxAttempts])
            ->get();
    }

    /**
     * Get recent activities untuk dashboard
     */
    public static function getRecentActivities(int $limit = 50)
    {
        return self::with('user')
            ->latest()
            ->limit($limit)
            ->get();
    }

    /**
     * Get payment audit trail
     */
    public static function getPaymentAuditTrail(?int $limit = 100)
    {
        return self::byAction('payment')
            ->with('user')
            ->latest()
            ->limit($limit)
            ->get();
    }
}
