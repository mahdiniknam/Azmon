<?php

namespace App\Services;

use App\Models\Answer;
use App\Models\Exam;
use App\Models\ExamAttempt;
use App\Models\User;
use App\Models\Option;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class ExamAttemptService
{
    public function start(Exam $exam, User $user): ExamAttempt
    {
        return DB::transaction(function () use ($exam, $user) {
            $exam = Exam::query()->lockForUpdate()->findOrFail($exam->id);

            $openAttempt = $exam->attempts()
                ->where('user_id', $user->id)
                ->where('status', 'in_progress')
                ->whereNull('finished_at')
                ->lockForUpdate()
                ->first();

            if ($openAttempt && $openAttempt->isOpen()) {
                return $openAttempt->load('exam', 'answers');
            }

            $attempt = $exam->attempts()->create([
                'user_id' => $user->id,
                'started_at' => now(),
                'status' => 'in_progress',
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ]);

            return $attempt->load('exam', 'answers');
        });
    }

    public function answer(ExamAttempt $attempt, int $questionId, ?int $optionId): void
    {
        if (! $attempt->isOpen()) {
            throw ValidationException::withMessages(['attempt' => 'زمان آزمون به پایان رسیده است.']);
        }

        $isCorrect = null;
        if ($optionId) {
            $isCorrect = Option::where('id', $optionId)->where('is_correct', true)->exists();
        }

        $attempt->answers()->updateOrCreate(
            ['question_id' => $questionId],
            [
                'option_id' => $optionId,
                'is_correct' => $isCorrect,
            ]
        );
    }
}
