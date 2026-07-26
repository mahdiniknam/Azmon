@extends('admin.layout.master')

@section('admin-title')
    گزارش آزمون‌ها
@endsection

@section('admin-content')
    <main class="flex-1 overflow-y-auto p-6 bg-gray-50 dark:bg-gray-900">
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">گزارش آزمون‌ها</h2>
            <p class="text-gray-600 dark:text-gray-400">آمار شرکت‌کنندگان در آزمون‌ها</p>
        </div>

        <div class="bg-white py-6 space-y-4 dark:bg-gray-800 rounded-xl shadow-md overflow-hidden border border-gray-200 dark:border-gray-700">
            <div class="overflow-x-auto">
                <table class="w-full text-start">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">شناسه</th>
                            <th class="px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">عنوان آزمون</th>
                            <th class="px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">سازنده</th>
                            <th class="px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">نوع / هزینه</th>
                            <th class="px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">تعداد شرکت‌کنندگان</th>
                            <th class="px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">تاریخ ایجاد</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($exams as $exam)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $exam->id }}</td>
                                <td class="px-6 py-4 whitespace-nowrap font-medium">{{ $exam->title }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $exam->creator->name ?? 'ناشناس' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <span class="block text-gray-500">{{ $exam->type }}</span>
                                    <span class="block font-medium text-green-600 mt-1">{{ $exam->price > 0 ? number_format($exam->price) . ' تومان' : 'رایگان' }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center text-lg font-bold text-primary">{{ $exam->students_count }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm" dir="ltr">
                                    {{ jdate($exam->created_at)->format('Y/m/d') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-8 text-center text-gray-500">هیچ آزمونی یافت نشد.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="px-6 pt-4 border-t border-gray-200 dark:border-gray-700">
                {{ $exams->links() }}
            </div>
        </div>
    </main>
@endsection
