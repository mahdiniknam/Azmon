
<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\Result;
use Illuminate\Support\Facades\Auth;

class StudentDashboardController extends Controller
{
    public function index()
    {
        $student = Auth::guard('student')->user();

        $wallet = $student->wallet()->firstOrCreate([]);

        $availableExams = Exam::where('is_active', true)->get();
        $results = Result::where('student_id', $student->id)->latest()->take(5)->get();

        return view('student.dashboard.index', compact('student', 'wallet', 'availableExams', 'results'));
    }
}
