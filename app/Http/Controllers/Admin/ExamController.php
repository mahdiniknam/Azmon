<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\StoreExamRequest;
use App\Http\Requests\Admin\UpdateExamRequest;
use App\Models\Exam;
use App\Models\Subject;
use App\Models\Question;
use App\Services\ExamService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;

class ExamController extends Controller
{
    private $examService;

    public function __construct(ExamService $examService)
    {
        $this->examService = $examService;
    }

    public function index()
    {
        $exams = Exam::latest()
            ->paginate(20);

        return view('admin.pages.exam.index', compact('exams'));
    }

    public function create()
    {
        $subjects = Subject::has('questions')->get();

        $questions = Question::all();

        $students=User::where('role','student')->where('is_active',1)->get();

        $teachers = User::where('role', 'teacher')->where('is_active', 1)->get();

        return view('admin.pages.exam.create', compact('subjects', 'questions','students','teachers'));
    }

    public function store(StoreExamRequest $request)
    {
        
        $data = $request->validated();

        $data['created_by'] = auth()->id();

        $this->examService->create($data);

        return redirect()
            ->route('admin.exams.index')
            ->with('success', 'آزمون با موفقیت ایجاد شد');
    }

    public function edit($id)
    {
        $exam = Exam::with(['subjects', 'questions'])->findOrFail($id);

        $subjects = Subject::all();

        $questions = Question::all();

        return view('admin.pages.exam.edit', compact('exam', 'subjects', 'questions'));
    }

    public function update(UpdateExamRequest $request, $id)
    {
        $exam = Exam::findOrFail($id);

        $this->examService->update($exam, $request->validated());

        return redirect()
            ->route('admin.pages.exam.index')
            ->with('success', 'آزمون ویرایش شد');
    }

    public function destroy($id)
    {
        $exam = Exam::findOrFail($id);

        $this->examService->delete($exam);

        return redirect()
            ->route('admin.pages.exam.index')
            ->with('success', 'آزمون حذف شد');
    }
}
