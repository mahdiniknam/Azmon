@extends('student.layout.master')

@section('student-title')
    نتیجه آزمون
@endsection

@section('student-content')
    <main class="flex-1 overflow-y-auto p-6 bg-gray-50 dark:bg-gray-900">
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">نتیجه آزمون: {{ $exam->title ?? 'نامشخص' }}</h2>
        </div>

        @if(isset($resultPublished) && !$resultPublished)
            <div class="bg-yellow-50 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-200 p-6 rounded-xl border border-yellow-200 dark:border-yellow-800 text-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                <h3 class="text-xl font-bold mb-2">نتایج هنوز منتشر نشده</h3>
                <p>منتظر بررسی و تایید نمرات توسط استاد باشید.</p>
                <div class="mt-6">
                    <a href="{{ route('student.exams.index') }}" class="inline-flex items-center rounded-lg bg-yellow-600 px-4 py-2 text-white hover:bg-yellow-700">بازگشت به لیست آزمون‌ها</a>
                </div>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-md border border-gray-200 dark:border-gray-700 text-center">
                    <p class="text-gray-500 dark:text-gray-400 mb-2">نمره کل</p>
                    <p class="text-3xl font-bold text-primary">{{ $attempt->score ?? 0 }}</p>
                </div>
                <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-md border border-gray-200 dark:border-gray-700 text-center">
                    <p class="text-gray-500 dark:text-gray-400 mb-2">درصد</p>
                    <p class="text-3xl font-bold text-blue-600 dark:text-blue-400">{{ $attempt->percentage ?? 0 }}%</p>
                </div>
                <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-md border border-gray-200 dark:border-gray-700 text-center">
                    <p class="text-gray-500 dark:text-gray-400 mb-2">تعداد صحیح / غلط</p>
                    <div class="flex justify-center items-center gap-4 text-xl font-bold">
                        <span class="text-green-500">{{ $attempt->correct_answers ?? 0 }}</span>
                        <span class="text-gray-400">/</span>
                        <span class="text-red-500">{{ $attempt->wrong_answers ?? 0 }}</span>
                    </div>
                </div>
                <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-md border border-gray-200 dark:border-gray-700 text-center">
                    <p class="text-gray-500 dark:text-gray-400 mb-2">بی‌پاسخ</p>
                    <p class="text-3xl font-bold text-gray-500">{{ $attempt->unanswered ?? 0 }}</p>
                </div>
            </div>

            @if(isset($subjectBreakdown) && count($subjectBreakdown) > 0)
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden border border-gray-200 dark:border-gray-700 mb-8">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                        <h3 class="font-bold text-lg">جزئیات بر اساس دروس</h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-start">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">درس</th>
                                    <th class="px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-300 uppercase text-center">صحیح</th>
                                    <th class="px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-300 uppercase text-center">غلط</th>
                                    <th class="px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-300 uppercase text-center">بی‌پاسخ</th>
                                    <th class="px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-300 uppercase text-center">درصد</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($subjectBreakdown as $subject)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap font-medium">{{ $subject['title'] }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center text-green-500">{{ $subject['correct'] }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center text-red-500">{{ $subject['wrong'] }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center text-gray-500">{{ $subject['unanswered'] }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center font-bold" dir="ltr">{{ $subject['percentage'] }}%</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif

            <div class="mt-6 flex justify-end">
                <a href="{{ route('student.exams.index') }}" class="inline-flex items-center rounded-lg bg-gray-600 px-6 py-2 text-white hover:bg-gray-700 font-medium">بازگشت به لیست آزمون‌ها</a>
            </div>
        @endif
    </main>
@endsection
