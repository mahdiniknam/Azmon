<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use Illuminate\Http\Request;

class TeacherReportController extends Controller
{
    public function index()
    {
        $exams = Exam::where('teacher_id', auth()->id())->withCount('attempts')->latest()->paginate(10);

        return view('teacher.pages.reports.index', compact('exams'));
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
}
