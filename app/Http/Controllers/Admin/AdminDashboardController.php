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
        $totalIncome = Transaction::where('status', true)->where('type', 'deposit')->sum('amount');
        $totalExams = Exam::count();
        $successfulTransactions = Transaction::where('status', true)->count();
        $failedTransactions = Transaction::where('status', false)->count();

        return view('admin.pages.index', compact(
            'totalIncome',
            'totalExams',
            'successfulTransactions',
            'failedTransactions'
        ));

      
    }
}
