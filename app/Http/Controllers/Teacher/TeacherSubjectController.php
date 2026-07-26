<?php
namespace App\Http\Controllers\Teacher;
use App\Http\Controllers\Controller;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Http\Request;

class TeacherSubjectController extends Controller
{
    public function index()
    {
        $subjects = Subject::where('created_by_type', User::class)->where('created_by_id', auth()->id())->paginate(10);
        return view('teacher.pages.subjects.index', compact('subjects'));
    }

    public function create()
    {
        return view('teacher.pages.subjects.create');
    }

    public function store(Request $request)
    {
        $request->validate(['title' => 'required', 'status' => 'required']);
        Subject::create([
            'title' => $request->title,
            'description' => $request->description,
            'status' => $request->status,
            'created_by_type' => User::class,
            'created_by_id' => auth()->id(),
        ]);
        return redirect()->route('teacher.subjects.index')->with('success', 'درس ایجاد شد.');
    }

    public function edit($id)
    {
        $subject = Subject::where('created_by_type', User::class)->where('created_by_id', auth()->id())->findOrFail($id);
        return view('teacher.pages.subjects.edit', compact('subject'));
    }

    public function update(Request $request, $id)
    {
        $subject = Subject::where('created_by_type', User::class)->where('created_by_id', auth()->id())->findOrFail($id);
        $subject->update($request->only('title', 'description', 'status'));
        return redirect()->route('teacher.subjects.index')->with('success', 'درس ویرایش شد.');
    }

    public function destroy($id)
    {
        $subject = Subject::where('created_by_type', User::class)->where('created_by_id', auth()->id())->findOrFail($id);
        $subject->delete();
        return redirect()->route('teacher.subjects.index')->with('success', 'درس حذف شد.');
    }
}
