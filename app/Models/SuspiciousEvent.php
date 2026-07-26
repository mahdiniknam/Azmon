<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SuspiciousEvent extends Model
{
    protected $fillable = [
        'exam_attempt_id',
        'user_id',
        'type',
        'payload',
        'ip_address',
        'user_agent',
        'occurred_at',
    ];

    protected $casts = ['payload' => 'array', 'occurred_at' => 'datetime'];

    public function attempt(): BelongsTo
    {
        return $this->belongsTo(ExamAttempt::class, 'exam_attempt_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
