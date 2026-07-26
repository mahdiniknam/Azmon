<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\Question;
use App\Models\Subject;
use App\Models\ExamAttempt;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\View\View;

class TeacherDashboardController extends Controller
{
    public function index(): View
    {
        $teacherId = auth()->id();

        $subjectsCount = Subject::where('created_by_type', User::class)
            ->where('created_by_id', $teacherId)
            ->count();

        $questionsCount = Question::where('created_by_type', User::class)
            ->where('created_by_id', $teacherId)
            ->count();

        $examsCount = Exam::where('teacher_id', $teacherId)->count();

        $examIds = Exam::where('teacher_id', $teacherId)->pluck('id');

        $participantsCount = ExamAttempt::whereIn('exam_id', $examIds)->count();

        $totalRevenue = Transaction::whereIn('exam_id', $examIds)
            ->where('status', true)
            ->sum('amount');

        $recentExams = Exam::where('teacher_id', $teacherId)->latest()->take(5)->get();

        return view('teacher.pages.index', compact(
            'subjectsCount',
            'questionsCount',
            'examsCount',
            'participantsCount',
            'totalRevenue',
            'recentExams'
        ));
    }
}
