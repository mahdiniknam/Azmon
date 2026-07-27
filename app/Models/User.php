<?php

namespace App\Models;

use App\Filters\Contracts\Filterable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use SoftDeletes;
    use HasFactory, HasApiTokens, Filterable, Notifiable;

    const STATUS_PENDING = 'pending';
    const STATUS_ACTIVE = 'active';
    const STATUS_BANNED = 'banned';
    /**
     * Mass assignable attributes
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'is_active',
    ];

    /**
     * Hidden attributes
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Attribute casting
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'mobile_verified_at' => 'datetime',
    ];

    /**
     * Accessor: full name
     */


    /**
     * Helper: check if user is active
     */
    public function isActive(): bool
    {
        return $this->status === self::STATUS_ACTIVE;
    }

    public function isMobileVerified(): bool
    {
        return ! is_null($this->mobile_verified_at);
    }

    public function otps()
    {
        return $this->morphMany(Otp::class, 'authenticatable');
    }

    public function subjects()
    {
        return $this->hasMany(Subject::class);
    }
    public function exams()
    {
        return $this->morphMany(Exam::class, 'createdBy');
    }


    public function questions()
    {
        return $this->morphMany(Question::class, 'created_by');
    }


    public function examAttempts()
    {
        return $this->hasMany(ExamAttempt::class);
    }
    public function examTeacher()
    {
        return $this->hasMany(Exam::class, 'teacher_id');
    }

    public function hasPaidForExam($exam): bool
    {
        if (($exam->price ?? 0) <= 0) {
            return true;
        }

        // اگه استاد پرداخت کرده
        if (($exam->payment_type ?? null) === 'creator' && $exam->is_paid) {
            return true;
        }

        // تو جدول واسط
        $paidOnPivot = $exam->students()
            ->where('users.id', $this->id)
            ->wherePivot('is_paid', true)
            ->exists();

        if ($paidOnPivot) {
            return true;
        }

        return Transaction::query()
            ->where('user_id', $this->id)
            ->where('user_type', get_class($this))
            ->where('exam_id', $exam->id)
            ->where('status', 1)
            ->exists();
    }
    public function baleLinks()
    {
        return $this->hasMany(BaleAccountLink::class);
    }
}
