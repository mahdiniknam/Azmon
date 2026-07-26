<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;

class Exam extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'type',
        'duration',
        'start_date',
        'start_time',
        'end_date',
        'end_time',
        'negative_score',
        'shuffle_questions',
        'shuffle_options',
        'created_by_type',
        'created_by_id',
        'price',
        'payment_type',
        'max_participants',
        'is_paid',
        'is_public',
        'teacher_id',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'shuffle_questions' => 'boolean',
        'shuffle_options' => 'boolean',
        'negative_score' => 'float',
    ];


    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }
    public function createdBy()
    {
        return $this->morphTo();
    }


    public function examSubjects()
    {
        return $this->hasMany(ExamSubject::class);
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'exam_subjects')
            ->withPivot(['question_count', 'negative_score', 'order'])
            ->withTimestamps();
    }

    public function examQuestions()
    {
        return $this->hasMany(ExamQuestion::class);
    }

    public function questions()
    {
        return $this->belongsToMany(Question::class, 'exam_questions')
            ->withPivot(['order'])
            ->withTimestamps();
    }

    public function attempts()
    {
        return $this->hasMany(ExamAttempt::class);
    }
    public function students()
    {
        return $this->belongsToMany(User::class, 'exam_user')
            ->withPivot('is_paid')
            ->withTimestamps();
    }

    public function scopeAvailable(Builder $query): Builder
    {
        $now = Carbon::now();

        return $query->where(function ($q) use ($now) {
            $q->whereRaw("CONCAT(start_date, ' ', start_time) <= ?", [$now->toDateTimeString()])
                ->whereRaw("CONCAT(end_date, ' ', end_time) >= ?", [$now->toDateTimeString()]);
        });
    }
}
