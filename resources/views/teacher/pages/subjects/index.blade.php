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
                        <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">وضعیت</th>
                        <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">عملیات</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($subjects as $subject)
                    <tr>
                        <td class="px-6 py-4 text-sm text-gray-900">{{ $subject->title }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900">{{ $subject->description }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900">
                            @if($subject->status == 1) <span class="text-green-600">فعال</span>
                            @else <span class="text-red-600">غیرفعال</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm">
                            <a href="{{ route('teacher.subjects.edit', $subject->id) }}" class="text-blue-600 hover:text-blue-900 mx-2">ویرایش</a>
                            <form action="{{ route('teacher.subjects.destroy', $subject->id) }}" method="POST" class="inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('مطمئن هستید؟')">حذف</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="px-6 py-4 text-center">موردی یافت نشد.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4">{{ $subjects->links() ?? '' }}</div>
    </div>
</main>
@endsection
