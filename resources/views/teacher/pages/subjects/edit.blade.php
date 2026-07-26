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
