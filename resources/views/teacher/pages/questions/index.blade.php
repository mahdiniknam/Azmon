@extends('teacher.layout.master')
@section('teacher-title', 'لیست سوالات')
@section('teacher-content')
    <main class="flex-1 overflow-y-auto p-6 bg-gray-50 dark:bg-gray-900">
        <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">مدیریت سوالات</h2>
                <p class="text-gray-600 dark:text-gray-400">لیست تمامی سوالات شما</p>
            </div>
            <div class="mt-4 md:mt-0">
                <a href="{{ route('teacher.questions.create') }}"
                    class="px-4 py-2 text-sm font-medium rounded-lg bg-primary-600 text-white hover:bg-primary-500 shadow-sm">افزودن
                    سوال جدید</a>
                <a href="{{ route('teacher.questions.export') }}"
                    class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 mt-3">
                    خروجی اکسل سوالات
                </a>
            </div>
        </div>

        <div class="bg-white py-6 space-y-4 rounded-xl shadow-md border border-gray-200">
            <div class="overflow-x-auto">
                <table class="w-full text-start">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">متن سوال</th>
                            <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">درس</th>
                            <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">نمره</th>
                            <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">سختی</th>
                            <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">عملیات</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($questions as $question)
                            <tr>
                                <td class="px-6 py-4 text-sm text-gray-900">
                                    {{ \Illuminate\Support\Str::limit($question->question_text, 50) }}</td>
                                <td class="px-6 py-4 text-sm text-gray-900">{{ $question->subject->title ?? '-' }}</td>
                                <td class="px-6 py-4 text-sm text-gray-900">{{ $question->score }}</td>
                                <td class="px-6 py-4 text-sm text-gray-900">{{ $question->difficulty_label }}</td>
                                <td class="px-6 py-4 text-sm">
                                    <a href="{{ route('teacher.questions.edit', $question->id) }}"
                                        class="text-blue-600 hover:text-blue-900 mx-2">ویرایش</a>
                                    <form action="{{ route('teacher.questions.destroy', $question->id) }}" method="POST"
                                        class="inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900"
                                            onclick="return confirm('مطمئن هستید؟')">حذف</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center">موردی یافت نشد.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="p-4">{{ $questions->links() ?? '' }}</div>
        </div>
    </main>
@endsection
