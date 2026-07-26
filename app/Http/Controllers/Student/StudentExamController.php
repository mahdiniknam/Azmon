<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\ExamAttempt;
use App\Services\AntiCheatService;
use App\Services\ExamAttemptService;
use App\Services\ResultCalculator;
use Illuminate\Http\Request;

class StudentExamController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // آزمون‌های عمومی یا خصوصی که به این دانشجو وصل شدن
        $exams = Exam::query()
            ->where(function ($q) use ($user) {
                $q->where('is_public', 1)
                    ->orWhereHas('students', function ($q2) use ($user) {
                        $q2->where('users.id', $user->id);
                    });
            })
            ->withCount([
                'attempts as my_attempts_count' => function ($q) use ($user) {
                    $q->where('user_id', $user->id);
                },
            ])
            ->latest()
            ->paginate(15);

        return view('student.pages.exams.index', compact('exams'));
    }

    public function showExam(Exam $exam)
    {
        $user = auth()->user();

        if (! $this->canAccessExam($exam, $user)) {
            abort(403, 'دسترسی به این آزمون ندارید.');
        }

        $my_attempts_count = $exam->attempts()->where('user_id', $user->id)->count();
        $exam->load('teacher', 'createdBy');

        return view('student.pages.exams.show', compact('exam', 'my_attempts_count'));
    }

    public function start(Request $request, Exam $exam, ExamAttemptService $attemptService)
    {
        $user = auth()->user();

        if (! $this->canAccessExam($exam, $user)) {
            abort(403, 'دسترسی به این آزمون ندارید.');
        }

        // اگر پولی بود باید اول پرداخت کرده باشه
        if (($exam->price ?? 0) > 0 && ! $user->hasPaidForExam($exam)) {
            return redirect()->route('payment.checkout', $exam)
                ->with('error', 'اول باید هزینه آزمون را پرداخت کنید.');
        }

        $attempt = $attemptService->start($exam, $user);

        return redirect()->route('student.attempts.show', $attempt);
    }

    public function showAttempt(ExamAttempt $attempt)
    {
        $user = auth()->user();

        if ($attempt->user_id != $user->id) {
            abort(403);
        }

        // اگه تموم شده بره نتیجه
        if (! $attempt->isOpen()) {
            return redirect()->route('student.attempts.result', $attempt);
        }

        $attempt->load('answers');
        $exam = $attempt->exam()->with(['questions.options'])->first();

        // ترتیب سوالات
        $ordered = $exam->questions;
        if ($exam->shuffle_questions) {
            $ordered = $ordered->shuffle()->values();
        } else {
            $ordered = $ordered->sortBy(function ($q) {
                return $q->pivot->order ?? 0;
            })->values();
        }

        // شافل گزینه‌ها
        if ($exam->shuffle_options) {
            $ordered = $ordered->map(function ($q) {
                $q->setRelation('options', $q->options->shuffle()->values());
                return $q;
            });
        }

        // اگه سوال مستقیم نداشت از درس‌ها بیار
        if ($ordered->isEmpty()) {
            $subjectIds = $exam->subjects()->pluck('subjects.id');
            $ordered = \App\Models\Question::whereIn('subject_id', $subjectIds)
                ->with('options')
                ->get();
        }

        return view('student.pages.exams.attempt', [
            'attempt' => $attempt,
            'exam' => $exam,
            'ordered' => $ordered,
        ]);
    }

    public function answer(Request $request, ExamAttempt $attempt, ExamAttemptService $attemptService)
    {
        $user = auth()->user();

        if ($attempt->user_id != $user->id) {
            return response()->json(['ok' => false], 403);
        }

        $questionId = (int) $request->input('question_id');
        // فرانت question_option_id میفرسته، تو دیتابیس option_id هست
        $optionId = $request->input('question_option_id', $request->input('option_id'));
        $optionId = $optionId ? (int) $optionId : null;

        $attemptService->answer($attempt, $questionId, $optionId);

        return response()->json(['ok' => true]);
    }

    public function suspicious(Request $request, ExamAttempt $attempt, AntiCheatService $antiCheat)
    {
        $user = auth()->user();

        if ($attempt->user_id != $user->id) {
            return response()->json(['ok' => false], 403);
        }

        $data = $antiCheat->record($request, $attempt);

        return response()->json(['ok' => true, 'data' => $data]);
    }

    public function finish(ExamAttempt $attempt, ResultCalculator $calculator)
    {
        $user = auth()->user();

        if ($attempt->user_id != $user->id) {
            abort(403);
        }

        $calculator->finish($attempt);

        return redirect()->route('student.attempts.result', $attempt)
            ->with('success', 'آزمون با موفقیت ثبت شد.');
    }

    public function result(ExamAttempt $attempt)
    {
        $user = auth()->user();

        if ($attempt->user_id != $user->id) {
            abort(403);
        }

        $exam = $attempt->exam;
        $answers = $attempt->answers;

        $correct = $answers->where('is_correct', true)->count();
        $wrong = $answers->where('is_correct', false)->count();
        $answered = $correct + $wrong;

        $totalQuestions = $exam->questions()->count();
        if ($totalQuestions == 0) {
            $subjectIds = $exam->subjects()->pluck('subjects.id');
            $totalQuestions = \App\Models\Question::whereIn('subject_id', $subjectIds)->count();
        }

        $unanswered = max(0, $totalQuestions - $answered);

        $maxScore = $exam->questions()->sum('score');
        if ($maxScore <= 0) {
            $maxScore = max(1, $totalQuestions * 3);
        }

        $attempt->correct_answers = $correct;
        $attempt->wrong_answers = $wrong;
        $attempt->unanswered = $unanswered;
        $attempt->percentage = round(($attempt->score / $maxScore) * 100, 1);

        $resultPublished = true;
        $subjectBreakdown = [];

        return view('student.pages.exams.result', compact(
            'attempt',
            'exam',
            'resultPublished',
            'subjectBreakdown'
        ));
    }

    public function history()
    {
        $user = auth()->user();

        $attempts = ExamAttempt::with('exam')
            ->where('user_id', $user->id)
            ->latest()
            ->paginate(15);

        // درصد ساده برای جدول
        foreach ($attempts as $attempt) {
            $maxScore = 100;
            if ($attempt->exam) {
                $qCount = $attempt->exam->questions()->count();
                $sum = $attempt->exam->questions()->sum('score');
                $maxScore = $sum > 0 ? $sum : max(1, $qCount * 3);
            }
            $attempt->percentage = round((($attempt->score ?? 0) / $maxScore) * 100, 1);
        }

        return view('student.pages.exams.history', compact('attempts'));
    }

    private function canAccessExam(Exam $exam, $user): bool
    {
        if ($exam->is_public) {
            return true;
        }

        return $exam->students()->where('users.id', $user->id)->exists();
    }
}
