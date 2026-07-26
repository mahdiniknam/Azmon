<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Prunable;
use Illuminate\Database\Eloquent\Builder;

class Otp extends Model
{
    use Prunable;

    protected $fillable = [
        'authenticatable_id',
        'authenticatable_type',
        'code',
        'type',
        'expires_at',
        'used'
    ];

    /**
     * ارتباط Polymorphic با مدل‌های User و Admin
     */
    public function authenticatable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * بررسی اینکه آیا کد منقضی شده است یا خیر
     */
    public function isExpired(): bool
    {
        return $this->expires_at->isPast();
    }

    /**
     * متد مخصوص لاراول برای پاکسازی خودکار رکوردها از دیتابیس
     */
    // public function prunable(): Builder
    // {
    //     return static::where('expires_at', '<=', now()->subDay())
    //         ->orWhere('used', true);
    // }
}