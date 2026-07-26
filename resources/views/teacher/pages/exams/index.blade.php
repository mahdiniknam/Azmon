@extends('teacher.layout.master')
@section('teacher-title', 'لیست آزمون‌ها')
@section('teacher-content')
    <main class="flex-1 overflow-y-auto p-6 bg-gray-50 dark:bg-gray-900">
        <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">مدیریت آزمون‌ها</h2>
                <p class="text-gray-600 dark:text-gray-400">لیست تمامی آزمون‌های شما</p>
            </div>
            <div class="mt-4 md:mt-0">
                <a href="{{ route('teacher.exams.create') }}"
                    class="px-4 py-2 text-sm font-medium rounded-lg bg-primary-600 text-white hover:bg-primary-500 shadow-sm">افزودن
                    آزمون جدید</a>
            </div>
        </div>

        <div class="bg-white py-6 space-y-4 rounded-xl shadow-md border border-gray-200">
            <div class="overflow-x-auto">
                <table class="w-full text-start">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">عنوان آزمون</th>
                            <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">نوع</th>
                            <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">زمان شروع</th>
                            <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">مدت زمان</th>
                            <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">هزینه</th>
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
                                <td class="px-6 py-4 text-sm text-gray-900">{{ $exam->start_date }}</td>
                                <td class="px-6 py-4 text-sm text-gray-900">{{ $exam->duration }} دقیقه</td>
                                <td class="px-6 py-4 text-sm text-gray-900">
                                    {{ ($exam->price ?? 0) > 0 ? number_format($exam->price) . ' تومان' : 'رایگان' }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-900">
                                    <a href="{{ route('teacher.exams.edit', $exam->id) }}"
                                        class="text-blue-600 hover:text-blue-900 mx-2">ویرایش</a>
                                    <form action="{{ route('teacher.exams.destroy', $exam->id) }}" method="POST"
                                        class="inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900"
                                            onclick="return confirm('مطمئن هستید؟')">حذف</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-center">موردی یافت نشد.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="p-4">{{ $exams->links() ?? '' }}</div>
        </div>
    </main>
@endsection
