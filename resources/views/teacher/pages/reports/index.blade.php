@extends('teacher.layout.master')
@section('teacher-title', 'گزارشات')
@section('teacher-content')
    <main class="flex-1 overflow-y-auto p-6 bg-gray-50 dark:bg-gray-900">
        <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">گزارشات آزمون‌ها</h2>
                <p class="text-gray-600 dark:text-gray-400">آمار و عملکرد دانشجویان</p>
            </div>
        </div>

        <div class="bg-white py-6 space-y-4 rounded-xl shadow-md border border-gray-200">
            <div class="overflow-x-auto">
                <table class="w-full text-start">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">آزمون</th>
                            <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">نوع</th>
                            <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">تعداد شرکت‌کنندگان</th>
                            <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">عملیات</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($exams as $exam)
                            <tr>
                                <td class="px-6 py-4 text-sm text-gray-900">{{ $exam->title }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if ($exam->is_public === 1)
                                        <span
                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                            خصوصی
                                        </span>
                                    @elseif ($exam->is_public === 0)
                                        <span
                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200">
                                            عمومی
                                        </span>
                                    @else
                                        <span
                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200">
                                            ---
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-900">
                                    {{ $exam->attempts_count ?? 0 }} نفر
                                </td>

                                <td class="px-6 py-4 text-sm">
                                    <a href="{{ route('teacher.reports.exam-detail', $exam->id) }}"
                                        class="text-blue-600 hover:text-blue-900">مشاهده نتایج</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-center">موردی یافت نشد.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="p-4">{{ $exams->links() ?? '' }}</div>
        </div>
    </main>
@endsection
