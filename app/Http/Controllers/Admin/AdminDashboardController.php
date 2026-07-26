<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\ExamAttempt;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    public function index(): View
    {
        // 1. Total Income
        $totalIncome = Transaction::where('status', true)->sum('amount');

        // 2. Total Users
        $totalStudents = User::where('role', 'student')->count();
        $totalTeachers = User::where('role', 'teacher')->count();

        // 3. Total Exams
        $totalExams = Exam::count();
        
        // 4. Total Exam Attempts
        $totalAttempts = ExamAttempt::count();

        return view('admin.pages.index', compact(
            'totalIncome',
            'totalStudents',
            'totalTeachers',
            'totalExams',
            'totalAttempts'
        ));
    }
}
