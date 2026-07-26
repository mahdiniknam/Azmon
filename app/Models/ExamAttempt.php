<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ExamAttempt extends Model
{
    use HasFactory;

    protected $fillable = [
        'exam_id',
        'user_id',
        'started_at',
        'finished_at',
        'score',
        'ip_address',
        'user_agent',
        'status',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'finished_at' => 'datetime',
        'score' => 'float',
    ];

    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function suspiciousEvents()
    {
        return $this->hasMany(SuspiciousEvent::class);
    }

    public function isOpen(): bool
    {
        if ($this->status === 'finished' || $this->finished_at !== null) {
            return false;
        }

        if ($this->started_at && $this->exam && $this->exam->duration) {
            $end = $this->started_at->copy()->addMinutes($this->exam->duration);

            return $end->isFuture();
        }

        return true;
    }
}
