<?php

namespace App\Services;

use App\Models\ExamAttempt;
use App\Models\Question;
use App\Models\Option;
use Illuminate\Support\Facades\DB;

class ResultCalculator
{
    public function finish(ExamAttempt $attempt, string $status = 'finished'): ExamAttempt
    {
        return DB::transaction(function () use ($attempt, $status) {
            $attempt = $attempt->fresh(['exam.questions.options', 'answers']);

            if ($attempt->finished_at !== null) {
                return $attempt;
            }

            $questions = $attempt->exam->questions;
            if ($questions->isEmpty()) {
                $subjectIds = $attempt->exam->subjects()->pluck('subjects.id');
                $questions = Question::whereIn('subject_id', $subjectIds)->with('options')->get();
            }

            $answers = $attempt->answers->keyBy('question_id');
            $correct = 0;
            $wrong = 0;
            $unanswered = 0;
            $score = 0.0;
            $negativeRatio = $attempt->exam->negative_score ?? 0.33;

            foreach ($questions as $question) {
                $answer = $answers->get($question->id);
                $questionScore = $question->score ?? 3;

                if (! $answer || ! $answer->option_id) {
                    $unanswered++;
                } else {
                    $isCorrect = Option::where('id', $answer->option_id)
                        ->where('question_id', $question->id)
                        ->where('is_correct', true)
                        ->exists();

                    $answer->update(['is_correct' => $isCorrect]);

                    if ($isCorrect) {
                        $correct++;
                        $score += $questionScore;
                    } else {
                        $wrong++;
                        $score -= ($questionScore * $negativeRatio);
                    }
                }
            }

            $attempt->update([
                'finished_at' => now(),
                'status' => 'finished',
                'score' => round(max(0, $score), 2),
            ]);

            return $attempt->fresh(['exam', 'answers']);
        });
    }
}
