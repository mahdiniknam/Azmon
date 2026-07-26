<?php
namespace App\Http\Controllers\Teacher;
use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Http\Request;

class TeacherQuestionController extends Controller
{
    public function index()
    {
        $questions = Question::with('subject')->where('created_by_type', User::class)->where('created_by_id', auth()->id())->paginate(10);
        return view('teacher.pages.questions.index', compact('questions'));
    }

    public function create()
    {
        $subjects = Subject::where('created_by_type', User::class)->where('created_by_id', auth()->id())->get();
        return view('teacher.pages.questions.create', compact('subjects'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'subject_id' => 'required',
            'question_text' => 'required',
            'score' => 'required|numeric',
            'difficulty' => 'required',
            'options' => 'required|array|min:2',
            'correct_option' => 'required|numeric'
        ]);

        $question = Question::create([
            'subject_id' => $request->subject_id,
            'question_text' => $request->question_text,
            'score' => $request->score,
            'difficulty' => $request->difficulty,
            'created_by_type' => User::class,
            'created_by_id' => auth()->id(),
        ]);

        foreach ($request->options as $index => $option_text) {
            if (!empty($option_text)) {
                $question->options()->create([
                    'option_text' => $option_text,
                    'is_correct' => ($index == $request->correct_option)
                ]);
            }
        }

        return redirect()->route('teacher.questions.index')->with('success', 'سوال ایجاد شد.');
    }

    public function edit($id)
    {
        $question = Question::with('options')->where('created_by_type', User::class)->where('created_by_id', auth()->id())->findOrFail($id);
        $subjects = Subject::where('created_by_type', User::class)->where('created_by_id', auth()->id())->get();
        return view('teacher.pages.questions.edit', compact('question', 'subjects'));
    }

    public function update(Request $request, $id)
    {
        $question = Question::where('created_by_type', User::class)->where('created_by_id', auth()->id())->findOrFail($id);
        
        $question->update([
            'subject_id' => $request->subject_id,
            'question_text' => $request->question_text,
            'score' => $request->score,
            'difficulty' => $request->difficulty,
        ]);

        $question->options()->delete();
        
        foreach ($request->options as $index => $option_text) {
            if (!empty($option_text)) {
                $question->options()->create([
                    'option_text' => $option_text,
                    'is_correct' => ($index == $request->correct_option)
                ]);
            }
        }

        return redirect()->route('teacher.questions.index')->with('success', 'سوال ویرایش شد.');
    }

    public function destroy($id)
    {
        $question = Question::where('created_by_type', User::class)->where('created_by_id', auth()->id())->findOrFail($id);
        $question->delete();
        return redirect()->route('teacher.questions.index')->with('success', 'سوال حذف شد.');
    }
}
