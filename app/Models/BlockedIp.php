<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlockedIp extends Model
{
    protected $fillable = [
        'ip_address', 'type', 'description', 'starts_at', 'expires_at', 'is_active'
    ];

    protected $casts = [
        'starts_at' => 'datetime',
        'expires_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    // اسکوپ برای پیدا کردن ای‌پی‌های مسدود شده فعلی
    public function scopeIsBlocked($query, $ip)
    {
        return $query->where('ip_address', $ip)
            ->where('is_active', true)
            ->where(function ($q) {
                $q->whereNull('expires_at') // دائمی
                  ->orWhere('expires_at', '>', now()); // هنوز منقضی نشده
            });
    }
}