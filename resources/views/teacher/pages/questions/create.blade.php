@extends('teacher.layout.master')

@section('teacher-title')
    مدیریت سوال ها
@endsection

@section('teacher-content')
    <main class="flex-1 overflow-y-auto p-6 bg-gray-50 dark:bg-gray-900">
        <!-- header page -->
        <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">ایجاد سوال جدید</h2>
                <p class="text-gray-600 dark:text-gray-400">اطلاعات سوال جدید را در فرم زیر وارد کنید</p>
            </div>
            <div class="mt-4 md:mt-0">
                <button onclick="window.history.back()"
                    class="flex items-center px-4 py-2 text-sm font-medium rounded-lg bg-gray-200 text-gray-700 hover:bg-gray-300 shadow-sm dark:bg-gray-700 dark:text-white dark:hover:bg-gray-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 me-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z"
                            clip-rule="evenodd" />
                    </svg>
                    بازگشت
                </button>
            </div>
        </div>
        <form action="{{ route('teacher.questions.import') }}" method="POST" enctype="multipart/form-data"
            class="flex items-end gap-4 bg-blue-50 p-4 rounded-lg">
            @csrf
            <div>
                <label class="block text-sm mb-1">انتخاب درس:</label>
                <select name="subject_id" class="rounded-lg border-gray-300 text-sm">
                    @foreach ($subjects as $subject)
                        <option value="{{ $subject->id }}">{{ $subject->title }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm mb-1">فایل اکسل سوالات:</label>
                <input type="file" name="excel_file" class="text-sm">
            </div>
            <button type="submit" class="bg-blue-600 text-black px-4 py-2 rounded-lg hover:bg-blue-700">
                بارگذاری انبوه سوالات
            </button>
        </form>
        <!-- Add user form -->
        <form action="{{ route('teacher.questions.store') }}" method="POST"
            class="bg-white py-6 space-y-4 dark:bg-gray-800 rounded-xl shadow-md dark:shadow-gray-700 overflow-hidden border border-gray-200 dark:border-gray-700">

            @csrf

            <div class="px-6 border-b border-gray-200 dark:border-gray-700">
                <h3 class="font-bold text-lg mb-4">
                    فرم ایجاد سوال
                </h3>
            </div>

            <div class="px-6 grid grid-cols-1 md:grid-cols-2 gap-6">

                {{-- درس --}}
                <div>
                    <label class="block mb-1 text-sm font-medium">
                        درس
                    </label>

                    <select name="subject_id" class="select2 w-full border rounded-lg px-3 py-2">

                        <option value="">
                            انتخاب درس
                        </option>

                        @foreach ($subjects as $subject)
                            <option value="{{ $subject->id }}">
                                {{ $subject->title }}
                            </option>
                        @endforeach

                    </select>

                    @error('subject_id')
                        <x-alert type="error" message="{{ $message }}" />
                    @enderror
                </div>

                {{-- نمره --}}
                <div>
                    <label class="block mb-1 text-sm font-medium">
                        نمره سوال
                    </label>

                    <input type="number" step="0.25" name="score" value="{{ old('score', 1) }}"
                        class="w-full border rounded-lg px-3 py-2">

                    @error('score')
                        <x-alert type="error" message="{{ $message }}" />
                    @enderror
                </div>

                {{-- سختی --}}
                <div>
                    <label class="block mb-1 text-sm font-medium">
                        درجه سختی
                    </label>

                    <select name="difficulty" class="w-full border rounded-lg px-3 py-2">

                        @foreach (\App\Models\Question::difficultys() as $key => $label)
                            <option value="{{ $key }}">{{ $label }}</option>
                        @endforeach

                    </select>

                    @error('difficulty')
                        <x-alert type="error" message="{{ $message }}" />
                    @enderror
                </div>

            </div>

            {{-- متن سوال --}}
            <div class="px-6">

                <label class="block mb-1 text-sm font-medium">
                    متن سوال
                </label>

                <textarea rows="5" name="question_text" class="w-full border rounded-lg px-3 py-2">{{ old('question_text') }}</textarea>

                @error('question_text')
                    <x-alert type="error" message="{{ $message }}" />
                @enderror

            </div>

            {{-- گزینه ها --}}
            <div class="px-6">

                <h4 class="font-bold mb-4">
                    گزینه ها
                </h4>

                @for ($i = 0; $i < 4; $i++)
                    <div class="flex items-center gap-3 mb-3">

                        <input type="radio" name="correct_option" value="{{ $i }}"
                            {{ $i == 0 ? 'checked' : '' }}>

                        <input type="text" name="options[]" placeholder="گزینه {{ $i + 1 }}"
                            class="flex-1 border rounded-lg px-3 py-2">

                    </div>
                @endfor

            </div>

            <div class="px-6 py-4 border-t flex justify-end">

                <button type="submit" class="px-4 py-2 rounded-lg bg-primary-600 text-white">

                    ذخیره سوال

                </button>

            </div>

        </form>
    </main>
@endsection

@push('scripts')
    <script src="{{ asset('assets/js/dependencies/app.js') }}"></script>

    <!-- jquery -->
    <script src="{{ asset('assets/js/plugin/jquery/jquery1.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugin/jquery/select2.js') }}"></script>
@endpush
