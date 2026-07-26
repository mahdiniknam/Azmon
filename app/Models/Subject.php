<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'status',
        'created_by_type',
        'created_by_id',


    ];


    const STATUS_ACTIVE = 1;
    const STATUS_IN_ACTIVE = 0;


    public static function statuses(): array
    {
        return [
            self::STATUS_ACTIVE => 'فعال',
            self::STATUS_IN_ACTIVE => 'غیر فعال'
        ];
    }
    public function getStatusLabelAttribute()
    {
        return self::statuses()[$this->status] ?? 'نامشخص';
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function examSubjects()
    {
        return $this->hasMany(ExamSubject::class);
    }

    public function exams()
    {
        return $this->belongsToMany(Exam::class, 'exam_subjects')
            ->withPivot(['question_count', 'negative_score', 'order'])
            ->withTimestamps();
    }
}
