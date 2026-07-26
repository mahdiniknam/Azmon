<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'subject_id',
        'question_text',
        'score',
        'difficulty',
        'created_by_type',
        'created_by_id',

    ];

    const EASY  = 'easy';
    const MEDIYM = 'medium';

    const HARD = 'hard';

    public static function difficultys(): array
    {
        return [
            self::EASY => 'آسان',
            self::MEDIYM => 'متوسط',
            self::HARD => 'سخت',
        ];
    }
    public function getDifficultyLabelAttribute()
    {
        return self::difficultys()[$this->difficulty] ?? 'نامشخص';
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function createdBy()
    {
        return $this->morphTo();
    }

    public function options()
    {
        return $this->hasMany(Option::class);
    }

    public function examQuestions()
    {
        return $this->hasMany(ExamQuestion::class);
    }

    public function exams()
    {
        return $this->belongsToMany(Exam::class, 'exam_questions')
            ->withPivot(['order'])
            ->withTimestamps();
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }
}
