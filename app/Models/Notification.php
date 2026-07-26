<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasTranslations;

class Notification extends Model
{
    use HasTranslations;

    protected $fillable = [
        'user_id',
        'admin_id',
        'type',
        'status',
        'read',
        'read_at',
        'section',
    ];

    protected $casts = [
        'type' => 'array',
        'read' => 'boolean',
        'read_at' => 'datetime',
    ];

    protected $appends = ['title', 'description'];

    public const TYPE_SMS = 'sms';
    public const TYPE_EMAIL = 'email';
    public const TYPE_INTERNAL = 'internal';

    public const STATUS_ACTIVE = 'active';
    public const STATUS_INACTIVE = 'inactive';

    public const SECTION_NORMAL = 'normal';
    public const SECTION_TAPE = 'tape';
    public const SECTION_POP_UP = 'pop_up';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

    // عنوان/توضیح رو از translations می‌خوانیم
    public function getTitleAttribute(): string
    {
        return $this->t('title', app()->getLocale())
            ?? $this->t('title', 'en')
            ?? '';
    }

    public function getDescriptionAttribute(): ?string
    {
        return $this->t('description', app()->getLocale())
            ?? $this->t('description', 'en')
            ?? null;
    }
}
