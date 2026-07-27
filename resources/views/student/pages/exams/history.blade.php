@extends('student.layout.master')

@section('student-title')
    تاریخچه آزمون‌ها
@endsection

@section('student-content')
    <main class="flex-1 overflow-y-auto p-6 bg-gray-50 dark:bg-gray-900">
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">تاریخچه آزمون‌ها</h2>
            <p class="text-gray-600 dark:text-gray-400 mt-1">لیست آزمون‌هایی که در آنها شرکت کرده‌اید</p>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden border border-gray-200 dark:border-gray-700">
            <div class="overflow-x-auto">
                <table class="w-full text-start">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">شناسه</th>
                            <th class="px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">عنوان آزمون</th>
                            <th class="px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">تاریخ شرکت</th>
                            <th class="px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">نمره</th>
                            {{-- <th class="px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">درصد</th> --}}
                            <th class="px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">وضعیت</th>
                            <th class="px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">عملیات</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($attempts as $attempt)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $attempt->id }}</td>
                                <td class="px-6 py-4 whitespace-nowrap font-medium">{{ $attempt->exam->title ?? '---' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm" dir="ltr">{{ $attempt->created_at ? jdate($attempt->created_at)->format('Y/m/d H:i') : '---' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-primary">{{ $attempt->score ?? '---' }}</td>
                                {{-- <td class="px-6 py-4 whitespace-nowrap text-sm text-blue-600 dark:text-blue-400 font-bold" dir="ltr">{{ $attempt->percentage ?? 0 }}%</td> --}}
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($attempt->status == 'finished')
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">پایان یافته</span>
                                    @else
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400">در حال انجام</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    @if($attempt->status == 'finished')
                                        <a href="{{ route('student.attempts.result', $attempt) }}" class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300">مشاهده کارنامه</a>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-8 text-center text-gray-500">تا کنون در هیچ آزمونی شرکت نکرده‌اید.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if(method_exists($attempts, 'links'))
                <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50">
                    {{ $attempts->links() }}
                </div>
            @endif
        </div>
    </main>
@endsection
