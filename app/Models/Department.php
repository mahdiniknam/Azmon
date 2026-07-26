<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasTranslations;

class Department extends Model
{
    use HasTranslations;

    protected $fillable = [
        'status',
        'sort_order',
    ];

    protected $appends = ['name', 'description'];

    public function getNameAttribute(): string
    {
        return $this->t('name', app()->getLocale())
            ?? $this->t('name', 'en')
            ?? '';
    }

    public function getDescriptionAttribute(): ?string
    {
        return $this->t('description', app()->getLocale())
            ?? $this->t('description', 'en')
            ?? null;
    }
}
