import os
import shutil

BASE_DIR = r"e:\کاری\برنامه نویسی\azmon2\v2-azmon\Azmon - Copy"

def write_file(filepath, content):
    full_path = os.path.join(BASE_DIR, filepath)
    os.makedirs(os.path.dirname(full_path), exist_ok=True)
    with open(full_path, 'w', encoding='utf-8') as f:
        f.write(content.strip())
    print(f"Created: {filepath}")

# 2a. Layout master
master_content = """
<!doctype html>
<html lang="fa" dir="{{ app()->getLocale()=='fa' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('teacher-title')</title>
    <meta name="description" content="پنل استاد آزمون ساز آنلاین">
    <link rel="stylesheet" href="{{ asset('assets/css/select2.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/datePicker.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">
    <link rel="preload" href="{{ asset('assets/fonts/payda/PeydaWebFaNum-Medium.woff2') }}" as="font" type="font/woff2" crossorigin>
</head>
<body class="bg-light dark:bg-background-dark text-text-primary-light dark:text-text-primary-dark transition-colors duration-200">
    <div class="flex h-screen overflow-hidden max-w-[1920px] mx-auto">
        <!-- sidebar -->
        @include('teacher.partial.sidebar')
        <!-- main content -->
        <div class="flex flex-col flex-1 overflow-hidden">
            <!-- header -->
            @include('teacher.partial.header')
            <!-- component alert -->
            @include('components.alerts')
            <!-- page content -->
            @yield('teacher-content')
        </div>
    </div>
    
    <script src="{{ asset('assets/js/plugin/jquery/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugin/jalalidatepicker/jalalidatepicker.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugin/select2/select2.min.js') }}"></script>
    @yield('scripts')
</body>
</html>
"""

# 2b. Sidebar
sidebar_content = """
<div class="hidden lg:flex lg:flex-shrink-0">
    <div class="flex flex-col w-72 bg-white dark:bg-gray-800 border-e border-gray-200 dark:border-gray-700 shadow-sm">
        <div class="flex items-center justify-center h-20 p-4 border-b border-gray-200 dark:border-gray-700">
            <h1 class="ms-3 text-xl font-bold text-dark dark:text-light">پنل <span class="text-primary">استاد</span></h1>
        </div>
        <div class="flex flex-col flex-grow p-4 overflow-y-auto">
            <nav class="space-y-1">
                <!-- Dashboard -->
                <a href="{{ route('teacher.dashboard') }}" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ request()->routeIs('teacher.dashboard') ? 'bg-primary-50 dark:bg-primary-900/30 text-primary-600 dark:text-primary-400 active' : '' }}">
                    داشبورد
                </a>
                
                <!-- Subjects -->
                <a href="{{ route('teacher.subjects.index') }}" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ request()->routeIs('teacher.subjects.*') ? 'bg-primary-50 text-primary-600' : '' }}">
                    مدیریت دروس
                </a>

                <!-- Questions -->
                <a href="{{ route('teacher.questions.index') }}" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ request()->routeIs('teacher.questions.*') ? 'bg-primary-50 text-primary-600' : '' }}">
                    مدیریت سوالات
                </a>

                <!-- Exams -->
                <a href="{{ route('teacher.exams.index') }}" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ request()->routeIs('teacher.exams.*') ? 'bg-primary-50 text-primary-600' : '' }}">
                    مدیریت آزمون‌ها
                </a>

                <!-- Reports -->
                <a href="{{ route('teacher.reports.index') }}" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ request()->routeIs('teacher.reports.*') ? 'bg-primary-50 text-primary-600' : '' }}">
                    گزارشات
                </a>
            </nav>
        </div>
    </div>
</div>
"""

# 2c. Header
header_content = """
<header class="flex items-center justify-between h-20 px-6 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
    <div class="flex items-center">
        <h2 class="text-xl font-bold text-gray-800 dark:text-white">پنل استاد</h2>
    </div>
    <div class="flex items-center gap-4">
        <span class="text-sm font-medium text-gray-700 dark:text-gray-200">{{ auth()->user()->name ?? 'استاد عزیز' }}</span>
        <form method="POST" action="{{ route('teacher.logout') ?? '#' }}">
            @csrf
            <button type="submit" class="text-sm text-red-600 hover:text-red-800">خروج</button>
        </form>
    </div>
</header>
"""

# 3. Dashboard
dashboard_content = """
@extends('teacher.layout.master')
@section('teacher-title', 'داشبورد استاد')
@section('teacher-content')
<main class="flex-1 overflow-y-auto p-6 bg-gray-50 dark:bg-gray-900">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
        <div class="bg-white rounded-xl shadow-md p-6 border border-gray-200">
            <h3 class="text-gray-500 text-sm font-medium">تعداد دروس</h3>
            <p class="text-3xl font-bold text-gray-900 mt-2">{{ \App\Models\Subject::where('created_by_type', \App\Models\User::class)->where('created_by_id', auth()->id())->count() ?? 0 }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-md p-6 border border-gray-200">
            <h3 class="text-gray-500 text-sm font-medium">تعداد سوالات</h3>
            <p class="text-3xl font-bold text-gray-900 mt-2">{{ \App\Models\Question::where('created_by_type', \App\Models\User::class)->where('created_by_id', auth()->id())->count() ?? 0 }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-md p-6 border border-gray-200">
            <h3 class="text-gray-500 text-sm font-medium">تعداد آزمون‌ها</h3>
            <p class="text-3xl font-bold text-gray-900 mt-2">{{ \App\Models\Exam::where('teacher_id', auth()->id())->count() ?? 0 }}</p>
        </div>
    </div>
</main>
@endsection
"""

# 4b. Subjects index
subjects_index = """
@extends('teacher.layout.master')
@section('teacher-title', 'لیست دروس')
@section('teacher-content')
<main class="flex-1 overflow-y-auto p-6 bg-gray-50 dark:bg-gray-900">
    <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">مدیریت درس ها</h2>
            <p class="text-gray-600 dark:text-gray-400">لیست تمامی دروس شما</p>
        </div>
        <div class="mt-4 md:mt-0">
            <a href="{{ route('teacher.subjects.create') }}" class="px-4 py-2 text-sm font-medium rounded-lg bg-primary-600 text-white hover:bg-primary-500 shadow-sm">افزودن درس جدید</a>
        </div>
    </div>
    
    <div class="bg-white py-6 space-y-4 rounded-xl shadow-md border border-gray-200">
        <div class="overflow-x-auto">
            <table class="w-full text-start">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">نام درس</th>
                        <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">توضیحات</th>
                        <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">عملیات</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($subjects as $subject)
                    <tr>
                        <td class="px-6 py-4 text-sm text-gray-900">{{ $subject->title }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900">{{ $subject->description }}</td>
                        <td class="px-6 py-4 text-sm">
                            <a href="{{ route('teacher.subjects.edit', $subject->id) }}" class="text-blue-600 hover:text-blue-900 mx-2">ویرایش</a>
                            <form action="{{ route('teacher.subjects.destroy', $subject->id) }}" method="POST" class="inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('مطمئن هستید؟')">حذف</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="3" class="px-6 py-4 text-center">موردی یافت نشد.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4">{{ $subjects->links() ?? '' }}</div>
    </div>
</main>
@endsection
"""

# 4c. Subjects create
subjects_create = """
@extends('teacher.layout.master')
@section('teacher-title', 'ایجاد درس')
@section('teacher-content')
<main class="flex-1 overflow-y-auto p-6 bg-gray-50 dark:bg-gray-900">
    <div class="bg-white rounded-xl shadow-md p-6 border border-gray-200">
        <h2 class="text-xl font-bold mb-6">ایجاد درس جدید</h2>
        <form action="{{ route('teacher.subjects.store') }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">عنوان درس</label>
                    <input type="text" name="title" class="w-full rounded-lg border-gray-300 focus:border-primary-500 focus:ring-primary-500" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">وضعیت</label>
                    <select name="status" class="w-full rounded-lg border-gray-300">
                        <option value="1">فعال</option>
                        <option value="0">غیرفعال</option>
                    </select>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">توضیحات</label>
                    <textarea name="description" class="w-full rounded-lg border-gray-300" rows="4"></textarea>
                </div>
            </div>
            <button type="submit" class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700">ذخیره</button>
        </form>
    </div>
</main>
@endsection
"""

# 4d. Subjects edit
subjects_edit = """
@extends('teacher.layout.master')
@section('teacher-title', 'ویرایش درس')
@section('teacher-content')
<main class="flex-1 overflow-y-auto p-6 bg-gray-50 dark:bg-gray-900">
    <div class="bg-white rounded-xl shadow-md p-6 border border-gray-200">
        <h2 class="text-xl font-bold mb-6">ویرایش درس</h2>
        <form action="{{ route('teacher.subjects.update', $subject->id) }}" method="POST">
            @csrf @method('PUT')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">عنوان درس</label>
                    <input type="text" name="title" value="{{ $subject->title }}" class="w-full rounded-lg border-gray-300" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">وضعیت</label>
                    <select name="status" class="w-full rounded-lg border-gray-300">
                        <option value="1" {{ $subject->status == 1 ? 'selected' : '' }}>فعال</option>
                        <option value="0" {{ $subject->status == 0 ? 'selected' : '' }}>غیرفعال</option>
                    </select>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">توضیحات</label>
                    <textarea name="description" class="w-full rounded-lg border-gray-300" rows="4">{{ $subject->description }}</textarea>
                </div>
            </div>
            <button type="submit" class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700">بروزرسانی</button>
        </form>
    </div>
</main>
@endsection
"""

# Controllers code...
teacher_subject_controller = """<?php
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
"""

teacher_exam_controller = """<?php
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
        return view('teacher.pages.exams.create', compact('subjects', 'questions'));
    }

    public function store(Request $request)
    {
        $data = $request->except('_token');
        $data['teacher_id'] = auth()->id();
        $data['created_by_type'] = User::class;
        $data['created_by_id'] = auth()->id();
        $this->examService->create($data);
        return redirect()->route('teacher.exams.index')->with('success', 'آزمون ایجاد شد.');
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
"""

teacher_report_controller = """<?php
namespace App\Http\Controllers\Teacher;
use App\Http\Controllers\Controller;
use App\Models\Exam;
use Illuminate\Http\Request;

class TeacherReportController extends Controller
{
    public function index()
    {
        $exams = Exam::where('teacher_id', auth()->id())->withCount('participants')->paginate(10);
        return view('teacher.pages.reports.index', compact('exams'));
    }

    public function examDetail($id)
    {
        $exam = Exam::where('teacher_id', auth()->id())->with('participants.user')->findOrFail($id);
        return view('teacher.pages.reports.exam-detail', compact('exam'));
    }
}
"""

write_file('resources/views/teacher/layout/master.blade.php', master_content)
write_file('resources/views/teacher/partial/sidebar.blade.php', sidebar_content)
write_file('resources/views/teacher/partial/header.blade.php', header_content)
write_file('resources/views/teacher/pages/index.blade.php', dashboard_content)

write_file('resources/views/teacher/pages/subjects/index.blade.php', subjects_index)
write_file('resources/views/teacher/pages/subjects/create.blade.php', subjects_create)
write_file('resources/views/teacher/pages/subjects/edit.blade.php', subjects_edit)

write_file('app/Http/Controllers/Teacher/TeacherSubjectController.php', teacher_subject_controller)
write_file('app/Http/Controllers/Teacher/TeacherExamController.php', teacher_exam_controller)
write_file('app/Http/Controllers/Teacher/TeacherReportController.php', teacher_report_controller)

print("Part 1 finished")
