@extends('teacher.layout.master')
@section('teacher-title', 'ویرایش سوال')
@section('teacher-content')
<main class="flex-1 overflow-y-auto p-6 bg-gray-50 dark:bg-gray-900">
    <div class="bg-white rounded-xl shadow-md p-6 border border-gray-200">
        <h2 class="text-xl font-bold mb-6">ویرایش سوال</h2>
        <form action="{{ route('teacher.questions.update', $question->id) }}" method="POST">
            @csrf @method('PUT')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">متن سوال</label>
                    <textarea name="question_text" class="w-full rounded-lg border-gray-300" rows="3" required>{{ $question->question_text }}</textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">درس مربوطه</label>
                    <select name="subject_id" class="w-full rounded-lg border-gray-300">
                        @foreach($subjects as $subject)
                            <option value="{{ $subject->id }}" {{ $question->subject_id == $subject->id ? 'selected' : '' }}>{{ $subject->title }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">سختی سوال</label>
                    <select name="difficulty" class="w-full rounded-lg border-gray-300">
                        <option value="easy" {{ $question->difficulty == 'easy' ? 'selected' : '' }}>آسان</option>
                        <option value="medium" {{ $question->difficulty == 'medium' ? 'selected' : '' }}>متوسط</option>
                        <option value="hard" {{ $question->difficulty == 'hard' ? 'selected' : '' }}>سخت</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">نمره سوال</label>
                    <input type="number" step="0.25" name="score" value="{{ $question->score }}" class="w-full rounded-lg border-gray-300" required>
                </div>
                
                <div class="md:col-span-2 mt-4">
                    <h3 class="font-bold text-lg mb-4">گزینه ها</h3>
                    @foreach($question->options as $index => $option)
                    <div class="flex items-center gap-4 mb-3">
                        <input type="radio" name="correct_option" value="{{ $index }}" {{ $option->is_correct ? 'checked' : '' }} class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300">
                        <input type="text" name="options[{{ $index }}]" value="{{ $option->option_text }}" class="w-full rounded-lg border-gray-300" required>
                    </div>
                    @endforeach
                </div>
            </div>
            <button type="submit" class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700">بروزرسانی سوال</button>
        </form>
    </div>
</main>
@endsection
