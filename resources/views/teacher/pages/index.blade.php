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
        <div class="bg-white rounded-xl shadow-md p-6 border border-gray-200">
            <h3 class="text-gray-500 text-sm font-medium">دانشجویان</h3>
            <p class="text-3xl font-bold text-gray-900 mt-2">-</p>
        </div>
    </div>
</main>
@endsection
