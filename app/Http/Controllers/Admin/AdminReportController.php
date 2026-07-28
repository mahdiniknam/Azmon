<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\Transaction;
use Illuminate\Http\Request;

class AdminReportController extends Controller
{
    public function overview()
    {
        $totalIncome = Transaction::where('status', true)->where('type', 'deposit')->sum('amount');
        $totalExams = Exam::count();
        $successfulTransactions = Transaction::where('status', true)->count();
        $failedTransactions = Transaction::where('status', false)->count();
        
        return view('admin.pages.reports.overview', compact(
            'totalIncome', 'totalExams', 'successfulTransactions', 'failedTransactions'
        ));
    }

    public function financial(Request $request)
    {
        $query = Transaction::query()->with(['user', 'exam']);
        
        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }
        
        $transactions = $query->latest()->paginate(15);
        $totalIncome = Transaction::where('status', true)->where('type', 'deposit')->sum('amount');
        
        return view('admin.pages.reports.financial', compact('transactions', 'totalIncome'));
    }
    
    public function exams()
    {
        $exams = Exam::withCount('students')->with('createdBy')->latest()->paginate(15);
        
        return view('admin.pages.reports.exams', compact('exams'));
    }
}
