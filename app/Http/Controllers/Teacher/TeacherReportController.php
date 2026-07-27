<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\ExamAttempt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TeacherReportController extends Controller
{
    public function index()
    {
        $exams = Exam::where('teacher_id', auth()->id())->withCount('attempts')->latest()->paginate(10);

        return view('teacher.pages`.reports.index', compact('exams'));
    }

    public function examDetail($id)
    {
        $exam = Exam::where('teacher_id', auth()->id())->findOrFail($id);

        // شرکت کننده‌ها = attempt ها
        $participants = $exam->attempts()
            ->with(['user', 'suspiciousEvents'])
            ->withCount('suspiciousEvents')
            ->latest()
            ->get();

        return view('teacher.pages.reports.exam-detail', compact('exam', 'participants'));
    }

    public function invalidateAttempt(Request $request, ExamAttempt $attempt)
    {
        $request->validate([
            'reason' => ['required', 'string', 'min:5', 'max:1000'],
        ], [
            'reason.required' => 'لطفاً دلیل تقلب را وارد کنید.',
            'reason.min' => 'دلیل تقلب باید حداقل ۵ کاراکتر باشد.',
        ]);

        $teacher = auth()->user();

        // اطمینان از اینکه این attempt مربوط به آزمون‌های همین استاد است
        $attempt->loadMissing('exam');

        if (! $attempt->exam || (int) $attempt->exam->teacher_id !== (int) $teacher->id) {
            abort(403, 'شما اجازه تغییر این آزمون را ندارید.');
        }

        DB::transaction(function () use ($attempt, $request, $teacher) {
            $attempt->update([
                'score' => 0,
                'invalidated_at' => now(),
                'invalidated_reason' => $request->reason,
                'invalidated_by' => $teacher->id,
            ]);

            if ($attempt->user?->bale_chat_id) {
                app(\App\Services\BaleBotService::class)->sendMessage(
                    "🚫 نتیجه آزمون شما توسط استاد به دلیل تقلب ابطال شد.\n📝 دلیل: {$attempt->invalidated_reason}",
                    $attempt->user->bale_chat_id
                );
            }
        });

        return back()->with('success', 'نمره دانشجو به دلیل تقلب صفر و علت ثبت شد.');
    }
}
