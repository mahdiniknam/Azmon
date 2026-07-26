<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Database\Eloquent\Casts\Attribute;

class GoogleAuth extends Model
{

    protected $fillable = [
        'secret',
        'url',
        'is_enabled',
        'verified_at',
    ];
    protected $casts = [
        'is_enabled' => 'boolean',
        'verified_at' => 'datetime',
        'last_used_at' => 'datetime',
    ];
    public function authenticatable()
    {
        return $this->morphTo();
    }

    protected function secret(): Attribute
    {
        return Attribute::make(
            get: fn($value) => Crypt::decryptString($value),
            set: fn($value) => Crypt::encryptString($value),
        );
    }
    protected function url(): Attribute
    {
        return Attribute::make(
            get: fn($value) => Crypt::decryptString($value),
            set: fn($value) => Crypt::encryptString($value),
        );
    }
}
