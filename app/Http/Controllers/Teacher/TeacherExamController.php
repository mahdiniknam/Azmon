<?php
namespace App\Http\Controllers\Teacher;
use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\Subject;
use App\Models\Question;
use App\Models\User;
use App\Services\ExamService;
use Illuminate\Http\Request;

class TeacherExamController extends Controller
{
    private $examService;
    public function __construct(ExamService $examService) { $this->examService = $examService; }

    public function index()
    {
        $exams = Exam::where('teacher_id', auth()->id())->latest()->paginate(10);
        return view('teacher.pages.exams.index', compact('exams'));
    }

    public function create()
    {
        $subjects = Subject::where('created_by_type', User::class)->where('created_by_id', auth()->id())->has('questions')->get();
        $questions = Question::where('created_by_type', User::class)->where('created_by_id', auth()->id())->get();
        $students = User::where('role', 'student')->where('is_active', 1)->get();
        return view('teacher.pages.exams.create', compact('subjects', 'questions', 'students'));
    }

    public function store(Request $request)
    {
        $data = $request->except('_token');
        $data['teacher_id'] = auth()->id();
        $data['created_by_type'] = User::class;
        $data['created_by_id'] = auth()->id();

        $this->examService->create($data);
        return redirect()->route('teacher.exams.index')->with('success', 'آزمون با موفقیت ایجاد شد.');
    }

    public function edit($id)
    {
        $exam = Exam::where('teacher_id', auth()->id())->with(['subjects', 'questions'])->findOrFail($id);
        $subjects = Subject::where('created_by_type', User::class)->where('created_by_id', auth()->id())->get();
        $questions = Question::where('created_by_type', User::class)->where('created_by_id', auth()->id())->get();
        return view('teacher.pages.exams.edit', compact('exam', 'subjects', 'questions'));
    }

    public function update(Request $request, $id)
    {
        $exam = Exam::where('teacher_id', auth()->id())->findOrFail($id);
        $this->examService->update($exam, $request->except('_token', '_method'));
        return redirect()->route('teacher.exams.index')->with('success', 'آزمون ویرایش شد.');
    }

    public function destroy($id)
    {
        $exam = Exam::where('teacher_id', auth()->id())->findOrFail($id);
        $this->examService->delete($exam);
        return redirect()->route('teacher.exams.index')->with('success', 'آزمون حذف شد.');
    }
}
