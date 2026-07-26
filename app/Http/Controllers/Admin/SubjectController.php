<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreSubjectRequest;
use App\Http\Requests\Admin\UpdateSubjectRequest;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class SubjectController extends Controller
{
    public function index()
    {
        $subjects = Subject::paginate(10);
        return view('admin.pages.subjects.index', compact('subjects'));
    }


    public function create()
    {
        return view('admin.pages.subjects.create');
    }

    public function store(StoreSubjectRequest $request)
    {

        $user = auth()->user();

        if (!$user) {
            abort(401, 'کاربر وارد سیستم نشده است.');
        }
        Subject::create([
            'title' => $request->title,
            'description' => $request->description,
            'status' => $request->status,

            'created_by_type' => get_class($user),
            'created_by_id' => $user->id,

        ]);

        return redirect()->route('admin.subjects.index')->with('success', 'درس با موفقیت ایجاد شد.');
    }


    public function edit($id)
    {
        $subject = Subject::findOrFail($id);
        return view('admin.pages.subjects.edit', compact('subject'));
    }


    public function update(UpdateSubjectRequest $request, $id)
    {
        $sub = Subject::findOrFail($id);
        // dd($sub);

        $sub->update([
            'title' => $request->title ?? $sub->title,
            'description' => $request->description ?? $sub->description,
            'status' => $request->status ?? $sub->status,
        ]);
        return redirect()->route('admin.subjects.index')->with('success', 'درس با موفقیت ویرایش شد.');
    }


    public function destroy($id)
    {
        $sub = Subject::findOrFail($id);
        $sub->delete();
        return redirect()->route('admin.subjects.index')->with('success', 'درس با موفقیت حذف شد.');
    }
}
