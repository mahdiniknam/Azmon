<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ExamSubject extends Model
{
    use HasFactory;

    protected $fillable = [
        'exam_id',
        'subject_id',
        'question_count',
        'negative_score',
        'order',
    ];

    protected $casts = [
        'negative_score' => 'float',
    ];

    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
}
