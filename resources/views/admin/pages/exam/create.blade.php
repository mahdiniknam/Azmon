@extends('admin.layout.master')

@section('admin-title')
    مدیریت آزمون ها - ایجاد آزمون
@endsection

@section('admin-content')
    <main class="flex-1 overflow-y-auto p-6 bg-gray-50 dark:bg-gray-900" dir="rtl">
        <!-- header page -->
        <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">ایجاد آزمون جدید</h2>
                <p class="text-gray-600 dark:text-gray-400">اطلاعات آزمون، محدودیت دسترسی و تنظیمات مالی را وارد کنید</p>
            </div>

            <div>
                <button onclick="window.history.back()"
                    class="flex items-center px-4 py-2 text-sm font-medium rounded-lg bg-gray-200 text-gray-700 hover:bg-gray-300 shadow-sm dark:bg-gray-700 dark:text-white dark:hover:bg-gray-600">
                    بازگشت
                </button>
            </div>
        </div>
        @if ($errors->any())
            <div class="mb-4 rounded-lg border border-red-300 bg-red-50 p-4 text-red-700">
                <strong class="block mb-2">خطاهای فرم:</strong>

                <ul class="list-disc pr-5 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif


        <form action="{{ route('admin.exams.store') }}" method="POST"
            class="bg-white dark:bg-gray-800 rounded-xl shadow-md border border-gray-200 dark:border-gray-700 overflow-hidden">
            @csrf

            {{-- Section 1: مشخصات اصلی --}}
            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <h3 class="font-bold text-lg text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                    <span class="w-1.5 h-6 bg-blue-600 rounded-full"></span>
                    مشخصات اصلی آزمون
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">عنوان آزمون</label>
                        <input type="text" name="title" value="{{ old('title') }}"
                            class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                        @error('title')
                            <x-alert type="error" message="{{ $message }}" />
                        @enderror
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">نوع آزمون</label>
                        <select name="type"
                            class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                            <option value="single" @selected(old('type') === 'single')>تک درس</option>
                            <option value="multi" @selected(old('type') === 'multi')>چند درس (کنکور)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">مدت آزمون
                            (دقیقه)</label>
                        <input type="number" name="duration" min="10" value="{{ old('duration', 120) }}"
                            class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 bg-white dark:bg-gray-700 text-gray-900 focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">نمره منفی</label>
                        <input type="number" step="0.25" name="negative_score" value="{{ old('negative_score', 0.25) }}"
                            class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 bg-white dark:bg-gray-700 text-gray-900 focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>
            </div>

            {{-- Section 2: دسترسی و نحوه برگزاری (پابلیک/خصوصی) --}}
            <div class="p-6 border-b border-gray-200 dark:border-gray-700 bg-gray-50/30">
                <h3 class="font-bold text-lg text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                    <span class="w-1.5 h-6 bg-yellow-500 rounded-full"></span>
                    حریم خصوصی و دسترسی آزمون
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">نوع دسترسی</label>

                        <select name="is_public" id="isPublicSelect" onchange="toggleStudentList()"
                            class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 bg-white dark:bg-gray-700 text-gray-900 focus:ring-2 focus:ring-blue-500">
                            <option value="">انتخاب کنید</option>
                            <option value="1" @selected(old('is_public', '1') == '1')>عمومی (همه دانشجویان سایت)</option>
                            <option value="0" @selected(old('is_public') == '0')>خصوصی (انتخاب دانشجویان خاص)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                            استاد آزمون
                        </label>

                        <select name="teacher_id"
                            class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 bg-white dark:bg-gray-700 text-gray-900 focus:ring-2 focus:ring-blue-500">
                            <option value="">انتخاب استاد</option>

                            @foreach ($teachers as $teacher)
                                <option value="{{ $teacher->id }}" @selected(old('teacher_id') == $teacher->id)>
                                    {{ $teacher->name }} - {{ $teacher->email }}
                                </option>
                            @endforeach
                        </select>

                        @error('teacher_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div id="studentSelectionSection" class="hidden">
                        <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">انتخاب دانشجویان
                            مجاز</label>
                        <select name="students[]" multiple
                            class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 bg-white dark:bg-gray-700 text-gray-900 focus:ring-2 focus:ring-blue-500 min-h-[120px]">
                            @foreach ($students as $student)
                                <option value="{{ $student->id }}">{{ $student->name }} ({{ $student->email }})</option>
                            @endforeach
                        </select>
                        <p class="text-xs text-gray-500 mt-1">نگه داشتن کلید Ctrl برای انتخاب چندگانه الزامی است.</p>
                    </div>
                </div>
            </div>

            {{-- Section 3: تنظیمات مالی و درآمدزایی --}}
            <div class="p-6 border-b border-gray-200 dark:border-gray-700 bg-blue-50/10">
                <h3 class="font-bold text-lg text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                    <span class="w-1.5 h-6 bg-emerald-600 rounded-full"></span>
                    تنظیمات مالی و درگاه پرداخت
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">هزینه شرکت در آزمون
                            (تومان)</label>
                        <input type="number" name="price" id="examPrice" value="{{ old('price', 0) }}"
                            oninput="calculateCreatorCost()"
                            class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 bg-white dark:bg-gray-700 text-gray-900 focus:ring-2 focus:ring-blue-500">
                        <p class="text-xs text-gray-500 mt-1">عدد 0 به معنی رایگان بودن آزمون است.</p>
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">پرداخت‌کننده
                            هزینه</label>
                        <select name="payment_type" id="paymentType" onchange="toggleCreatorFields()"
                            class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 bg-white dark:bg-gray-700 text-gray-900 focus:ring-2 focus:ring-blue-500">
                            <option value="student" @selected(old('payment_type') === 'student')>دانشجو (دنگ خود دانشجو)</option>
                            <option value="creator" @selected(old('payment_type') === 'creator')>استاد (پرداخت یکجا توسط استاد)</option>
                        </select>
                    </div>

                    <div id="maxParticipantsSection" class="hidden">
                        <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">حداکثر تعداد
                            شرکت‌کنندگان</label>
                        <input type="number" name="max_participants" id="maxParticipants"
                            value="{{ old('max_participants', 10) }}" oninput="calculateCreatorCost()"
                            class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 bg-white dark:bg-gray-700 text-gray-900 focus:ring-2 focus:ring-blue-500">
                        <div id="creatorTotalCost" class="text-xs text-emerald-600 font-bold mt-2"></div>
                    </div>
                </div>
            </div>

            {{-- Section 4: زمان‌بندی و تصادفی‌سازی --}}
            <div class="p-6 border-b border-gray-200 dark:border-gray-700 bg-gray-50/50">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <div>
                        <h3 class="font-bold text-md text-gray-950 dark:text-white mb-4 flex items-center gap-2">
                            <span class="w-1.5 h-5 bg-blue-600 rounded-full"></span>
                            زمان‌بندی برگزاری
                        </h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">تاریخ
                                    شروع</label>
                                <input data-jdp type="text" name="start_date" value="{{ old('start_date') }}"
                                    class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 bg-white dark:bg-gray-700 text-gray-950">
                            </div>
                            <div>
                                <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">ساعت
                                    شروع</label>
                                <input type="time" name="start_time" value="{{ old('start_time') }}"
                                    class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 bg-white dark:bg-gray-700 text-gray-950">
                            </div>
                            <div>
                                <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">تاریخ
                                    پایان</label>
                                <input data-jdp type="text" name="end_date" value="{{ old('end_date') }}"
                                    class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 bg-white dark:bg-gray-700 text-gray-950">
                            </div>
                            <div>
                                <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">ساعت
                                    پایان</label>
                                <input type="time" name="end_time" value="{{ old('end_time') }}"
                                    class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 bg-white dark:bg-gray-700 text-gray-950">
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col gap-6">
                        <div>
                            <h3 class="font-bold text-md text-gray-950 dark:text-white mb-4 flex items-center gap-2">
                                <span class="w-1.5 h-5 bg-blue-600 rounded-full"></span>
                                تنظیمات آزمون
                            </h3>
                            <div
                                class="flex flex-col gap-3 p-4 bg-white dark:bg-gray-700 rounded-lg border border-gray-200">
                                <label
                                    class="flex items-center gap-2 text-sm text-gray-700 dark:text-gray-300 cursor-pointer">
                                    <input type="checkbox" name="shuffle_questions" value="1"
                                        @checked(old('shuffle_questions')) class="w-4 h-4 text-blue-600 rounded">
                                    تصادفی سازی سوالات
                                </label>
                                <label
                                    class="flex items-center gap-2 text-sm text-gray-700 dark:text-gray-300 cursor-pointer">
                                    <input type="checkbox" name="shuffle_options" value="1"
                                        @checked(old('shuffle_options')) class="w-4 h-4 text-blue-600 rounded">
                                    تصادفی سازی گزینه‌ها
                                </label>
                            </div>
                        </div>

                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">توضیحات
                                آزمون</label>
                            <textarea rows="3" name="description"
                                class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 bg-white dark:bg-gray-700 text-gray-900 focus:ring-2 focus:ring-blue-500">{{ old('description') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Section 5: دروس آزمون --}}
            <div class="p-6">
                <h3 class="font-bold text-lg text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                    <span class="w-1.5 h-6 bg-blue-600 rounded-full"></span>
                    دروس آزمون
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach ($subjects as $subject)
                        <div
                            class="border border-gray-200 dark:border-gray-700 rounded-xl p-4 bg-white dark:bg-gray-800 shadow-sm hover:shadow-md transition-shadow">
                            <div class="flex items-center gap-3 mb-3">
                                <input type="checkbox" name="subjects[{{ $subject->id }}][selected]" value="1"
                                    @checked(old("subjects.{$subject->id}.selected")) class="w-4 h-4 text-blue-600 rounded">
                                <span class="font-medium text-gray-800 dark:text-gray-200 text-sm">
                                    {{ $subject->title }}
                                </span>
                            </div>

                            <div class="grid grid-cols-2 gap-3 pt-2 border-t border-gray-100 dark:border-gray-700">
                                <div>
                                    <label class="block mb-1 text-[11px] text-gray-500">تعداد سوال</label>
                                    <input type="number" min="1" placeholder="تعداد"
                                        name="subjects[{{ $subject->id }}][question_count]"
                                        value="{{ old("subjects.{$subject->id}.question_count") }}"
                                        class="w-full border border-gray-200 dark:border-gray-600 rounded-lg px-2 py-1 text-sm bg-gray-50 dark:bg-gray-700 text-gray-900 focus:ring-1 focus:ring-blue-500">
                                </div>
                                <div>
                                    <label class="block mb-1 text-[11px] text-gray-500">ترتیب نمایش</label>
                                    <input type="number" min="1" placeholder="ترتیب"
                                        name="subjects[{{ $subject->id }}][order]"
                                        value="{{ old("subjects.{$subject->id}.order") }}"
                                        class="w-full border border-gray-200 dark:border-gray-600 rounded-lg px-2 py-1 text-sm bg-gray-50 dark:bg-gray-700 text-gray-900 focus:ring-1 focus:ring-blue-500">
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- دکمه ذخیره و پرداخت --}}
            <div
                class="px-6 py-4 bg-gray-50 dark:bg-gray-900 border-t border-gray-200 dark:border-gray-700 flex justify-end">
                <button type="submit"
                    class="px-6 py-2.5 rounded-lg bg-blue-600 hover:bg-blue-700 text-black font-medium text-sm transition-colors shadow-sm">
                    ذخیره آزمون
                </button>
            </div>
        </form>
    </main>
@endsection

@push('scripts')
    <script src="{{ asset('assets/js/dependencies/app.js') }}"></script>
    <script src="{{ asset('assets/js/plugin/date-picker/datePicker.js') }}"></script>
    <!-- jquery -->
    <script src="{{ asset('assets/js/plugin/jquery/jquery1.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugin/jquery/select2.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (window.jalaliDatepicker) {
                jalaliDatepicker.startWatch();
            }
            toggleStudentList();
            toggleCreatorFields();
        });

        function toggleStudentList() {
            const isPublic = document.getElementById('isPublicSelect').value;
            const section = document.getElementById('studentSelectionSection');
            if (isPublic == '0') {
                section.classList.remove('hidden');
            } else {
                section.classList.add('hidden');
            }
        }

        function toggleCreatorFields() {
            const paymentType = document.getElementById('paymentType').value;
            const section = document.getElementById('maxParticipantsSection');
            if (paymentType === 'creator') {
                section.classList.remove('hidden');
                calculateCreatorCost();
            } else {
                section.classList.add('hidden');
            }
        }

        function calculateCreatorCost() {
            const price = parseFloat(document.getElementById('examPrice').value) || 0;
            const count = parseInt(document.getElementById('maxParticipants').value) || 0;
            const costDiv = document.getElementById('creatorTotalCost');
            if (costDiv) {
                const total = price * count;
                costDiv.innerText = `کل هزینه پرداختی استاد: ${total.toLocaleString()} تومان`;
            }
        }
    </script>
@endpush
