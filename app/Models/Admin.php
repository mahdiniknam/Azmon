<?php

namespace App\Models;

use App\Filters\Contracts\Filterable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class Admin extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles, Filterable;

    protected $guard_name = 'admin';
    protected $fillable = [
        'first_name',
        'last_name',
        'national_code',
        'mobile',
        'address',
        'status',
        'email',
        'password',
        'otp_enabled',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // بررسی فعال بودن
    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    //نام کامل ادمین
    public function getFullNameAttribute(): string
    {
        return $this->first_name . ' ' . $this->last_name;
    }
    //سوپر ادمین بودن
    public function isSuperAdmin(): bool
    {
        return $this->hasRole(config('auth.super_admin_role'));
    }
    public function googleAuths()
    {
        return $this->morphMany(GoogleAuth::class, 'authenticatable');
    }

    public function activeGoogleAuth()
    {
        return $this->morphOne(GoogleAuth::class, 'authenticatable')
            ->where('is_enabled', true);
    }

    public function getTwoFactorEnabledAttribute(): bool
    {
        return $this->activeGoogleAuth()->exists();
    }

    public function otps()
    {
        return $this->morphMany(Otp::class, 'authenticatable');
    }
    public function questions()
    {
        return $this->morphMany(Question::class, 'created_by');
    }
    public function exams()
    {
        return $this->morphMany(Exam::class, 'createdBy');
    }
}
