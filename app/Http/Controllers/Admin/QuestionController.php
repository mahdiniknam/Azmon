<?php

namespace App\Http\Controllers\Admin;

use App\Exports\QuestionsExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreQuestionRequest;
use App\Http\Requests\Admin\UpdateQuestionRequest;
use App\Models\Question;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Imports\QuestionsImport;
use Maatwebsite\Excel\Facades\Excel;

class QuestionController extends Controller
{
    /**
     * نمایش لیست سوالات
     */
    public function index()
    {
        $questions = Question::with(['subject', 'options'])
            ->latest()
            ->paginate(10);

        return view('admin.pages.questions.index', compact('questions'));
    }

    /**
     * نمایش فرم ساخت سوال
     */
    public function create()
    {
        $subjects = Subject::where('status', Subject::STATUS_ACTIVE)->get();

        return view('admin.pages.questions.create', compact('subjects'));
    }

    /**
     * ذخیره سوال جدید همراه با گزینه‌ها
     */
    public function store(StoreQuestionRequest $request)
    {
        if (!array_key_exists($request->correct_option, $request->options)) {
            return back()
                ->withErrors(['correct_option' => 'گزینه صحیح انتخاب‌شده معتبر نیست.'])
                ->withInput();
        }

        DB::transaction(function () use ($request) {
            $user = auth()->user();
            if (!$user) {
                abort(401, 'کاربر وارد سیستم نشده است.');
            }
            $question = Question::create([
                'subject_id' => $request->subject_id,
                'question_text' => $request->question_text,
                'score' => $request->score,
                'difficulty' => $request->difficulty,
                'created_by_type' => get_class($user),
                'created_by_id' => $user->id,
            ]);

            foreach ($request->options as $index => $optionText) {
                $question->options()->create([
                    'option_text' => $optionText,
                    'is_correct' => (int) $index === (int) $request->correct_option,
                ]);
            }
        });

        return redirect()
            ->route('admin.questions.index')
            ->with('success', 'سوال با موفقیت ایجاد شد.');
    }

    /**
     * نمایش فرم ویرایش سوال
     */
    public function edit($id)
    {
        $question = Question::with('options')->findOrFail($id);

        $subjects = Subject::where('status', 1)->get();

        return view('admin.pages.questions.edit', compact('question', 'subjects'));
    }

    /**
     * بروزرسانی سوال و گزینه‌ها
     */
    public function update(UpdateQuestionRequest $request, $id)
    {
        $question = Question::with('options')->findOrFail($id);

        if (!array_key_exists($request->correct_option, $request->options)) {
            return back()
                ->withErrors(['correct_option' => 'گزینه صحیح انتخاب‌شده معتبر نیست.'])
                ->withInput();
        }

        DB::transaction(function () use ($request, $question) {
            $question->update([
                'subject_id' => $request->subject_id,
                'question_text' => $request->question_text,
                'score' => $request->score,
                'difficulty' => $request->difficulty,
            ]);
            $question->options()->delete();

            foreach ($request->options as $index => $optionText) {
                $question->options()->create([
                    'option_text' => $optionText,
                    'is_correct' => (int) $index === (int) $request->correct_option,
                ]);
            }
        });

        return redirect()
            ->route('admin.questions.index')
            ->with('success', 'سوال با موفقیت ویرایش شد.');
    }

    /**
     * حذف سوال
     */
    public function destroy($id)
    {
        $question = Question::findOrFail($id);

        DB::transaction(function () use ($question) {
            $question->options()->delete();
            $question->delete();
        });

        return redirect()
            ->route('admin.questions.index')
            ->with('success', 'سوال با موفقیت حذف شد.');
    }

    public function import(Request $request)
    {
        $request->validate([
            'subject_id' => 'required|exists:subjects,id',
            'excel_file' => 'required|mimes:xlsx,xls,csv|max:2048',
        ]);

        try {
            Excel::import(
                new QuestionsImport($request->subject_id, auth()->user()),
                $request->file('excel_file')
            );

            return back()->with('success', 'فایل با موفقیت بارگذاری و سوالات اضافه شدند.');
        } catch (\Exception $e) {
            return back()->with('error', 'خطا در فرآیند بارگذاری: ' . $e->getMessage());
        }
    }

    public function export()
    {
        return Excel::download(new QuestionsExport, 'questions.xlsx');
    }
}
