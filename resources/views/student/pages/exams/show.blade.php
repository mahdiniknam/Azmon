@extends('student.layout.master')

@section('student-title')
    جزئیات آزمون
@endsection

@section('student-content')
    <main class="flex-1 overflow-y-auto bg-gray-50 p-6 dark:bg-gray-900">
        <div class="mx-auto max-w-5xl space-y-6">
            {{-- Header --}}
            <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                <div>
                    <h2 class="text-2xl font-extrabold tracking-tight text-gray-900 dark:text-white">
                        جزئیات آزمون
                    </h2>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                        اطلاعات کامل آزمون «{{ $exam->title }}» را در این بخش مشاهده می‌کنید.
                    </p>
                </div>

                <a href="{{ route('student.exams.index') }}"
                    class="inline-flex items-center justify-center rounded-xl border border-gray-300 bg-white px-5 py-2.5 text-sm font-medium text-gray-700 transition hover:bg-gray-100 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-200 dark:hover:bg-gray-700">
                    بازگشت به لیست آزمون‌ها
                </a>
            </div>

            {{-- Main Card --}}
            <div
                class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm dark:border-gray-700 dark:bg-gray-800">
                {{-- Top Section --}}
                <div class="border-b border-gray-200 px-6 py-5 dark:border-gray-700">
                    <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
                        <div class="space-y-3">
                            <div class="flex flex-wrap items-center gap-3">
                                <h3 class="text-xl font-bold text-gray-900 dark:text-white">
                                    {{ $exam->title }}
                                </h3>

                                @if (($exam->price ?? 0) > 0)
                                    <span
                                        class="inline-flex items-center rounded-full bg-yellow-100 px-3 py-1 text-xs font-semibold text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300">
                                        آزمون پولی
                                    </span>
                                @else
                                    <span
                                        class="inline-flex items-center rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700 dark:bg-green-900/30 dark:text-green-300">
                                        آزمون رایگان
                                    </span>
                                @endif

                                @if (($my_attempts_count ?? 0) > 0)
                                    <span
                                        class="inline-flex items-center rounded-full bg-blue-100 px-3 py-1 text-xs font-semibold text-blue-700 dark:bg-blue-900/30 dark:text-blue-300">
                                        شرکت کرده‌اید
                                    </span>
                                @endif
                            </div>

                            <p class="text-sm leading-7 text-gray-600 dark:text-gray-300">
                                {{ $exam->description ?: 'برای این آزمون توضیحی ثبت نشده است.' }}
                            </p>
                        </div>

                        <div class="min-w-[220px] rounded-xl bg-gray-50 p-4 dark:bg-gray-900/40">
                            <p class="mb-2 text-xs font-semibold text-gray-500 dark:text-gray-400">
                                وضعیت هزینه
                            </p>

                            @if (($exam->price ?? 0) > 0)
                                <div class="text-2xl font-extrabold text-yellow-600 dark:text-yellow-400">
                                    {{ number_format($exam->price) }}
                                    <span class="text-sm font-medium text-gray-500 dark:text-gray-400">تومان</span>
                                </div>
                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                    برای شروع آزمون نیاز به پرداخت دارید.
                                </p>
                            @else
                                <div class="text-2xl font-extrabold text-green-600 dark:text-green-400">
                                    رایگان
                                </div>
                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                    بدون نیاز به پرداخت می‌توانید آزمون را شروع کنید.
                                </p>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Details Grid --}}
                <div class="grid grid-cols-1 gap-4 px-6 py-6 sm:grid-cols-2 xl:grid-cols-3">
                    <div class="rounded-xl border border-gray-200 bg-gray-50 p-4 dark:border-gray-700 dark:bg-gray-900/40">
                        <p class="mb-1 text-sm text-gray-500 dark:text-gray-400">استاد / سازنده</p>
                        <p class="font-semibold text-gray-900 dark:text-white">
                            {{ $exam->teacher->name ?? ($exam->createdBy->name ?? 'نامشخص') }}
                        </p>
                    </div>

                    <div class="rounded-xl border border-gray-200 bg-gray-50 p-4 dark:border-gray-700 dark:bg-gray-900/40">
                        <p class="mb-1 text-sm text-gray-500 dark:text-gray-400">مدت زمان آزمون</p>
                        <p class="font-semibold text-gray-900 dark:text-white">
                            {{ $exam->duration }} دقیقه
                        </p>
                    </div>

                    <div class="rounded-xl border border-gray-200 bg-gray-50 p-4 dark:border-gray-700 dark:bg-gray-900/40">
                        <p class="mb-1 text-sm text-gray-500 dark:text-gray-400">تعداد سوالات</p>
                        <p class="font-semibold text-gray-900 dark:text-white">
                            {{ $exam->questions_count ?? $exam->questions()->count() }} سوال
                        </p>
                    </div>

                    <div class="rounded-xl border border-gray-200 bg-gray-50 p-4 dark:border-gray-700 dark:bg-gray-900/40">
                        <p class="mb-1 text-sm text-gray-500 dark:text-gray-400">هزینه آزمون</p>
                        <p class="font-semibold text-gray-900 dark:text-white">
                            @if (($exam->price ?? 0) > 0)
                                {{ number_format($exam->price) }} تومان
                            @else
                                <span class="text-green-600 dark:text-green-400">رایگان</span>
                            @endif
                        </p>
                    </div>

                    <div class="rounded-xl border border-gray-200 bg-gray-50 p-4 dark:border-gray-700 dark:bg-gray-900/40">
                        <p class="mb-1 text-sm text-gray-500 dark:text-gray-400">تعداد دفعات شرکت شما</p>
                        <p class="font-semibold text-gray-900 dark:text-white">
                            {{ $my_attempts_count ?? 0 }} بار
                        </p>
                    </div>

                    <div class="rounded-xl border border-gray-200 bg-gray-50 p-4 dark:border-gray-700 dark:bg-gray-900/40">
                        <p class="mb-1 text-sm text-gray-500 dark:text-gray-400">وضعیت دسترسی</p>
                        <p class="font-semibold text-gray-900 dark:text-white">
                            @if (($exam->price ?? 0) > 0 && !auth()->user()->hasPaidForExam($exam))
                                نیازمند پرداخت
                            @else
                                مجاز به شروع آزمون
                            @endif
                        </p>
                    </div>
                </div>

                {{-- Action Section --}}
                <div class="border-t border-gray-200 bg-gray-50 px-6 py-5 dark:border-gray-700 dark:bg-gray-900/30">
                    <div class="flex flex-col gap-3 sm:flex-row sm:items-center">

                        {{-- شرط 1: اگر آزمون پولی است و هنوز پرداخت نکرده --}}
                        @if (($exam->price ?? 0) > 0 && !auth()->user()->hasPaidForExam($exam))
                            <a href="{{ route('payment.checkout', $exam) }}"
                                class="inline-flex items-center justify-center rounded-xl bg-yellow-500 px-6 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:ring-offset-2 dark:focus:ring-offset-gray-900">
                                پرداخت هزینه و شرکت در آزمون
                            </a>

                            {{-- شرط 2: اگر قبلاً در این آزمون شرکت کرده است --}}
                        @elseif(($my_attempts_count ?? 0) > 0)
                            <div
                                class="flex w-full items-center justify-between rounded-xl bg-blue-50 p-4 border border-blue-100 dark:bg-blue-900/20 dark:border-blue-800">
                                <div class="flex items-center text-blue-700 dark:text-blue-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <span class="text-sm font-medium">شما قبلاً در این آزمون شرکت کرده‌اید.</span>
                                </div>
                                <a href="{{ route('student.attempts.result', $exam) }}"
                                    class="text-sm font-bold text-blue-600 hover:underline dark:text-blue-400">
                                    مشاهده نتیجه
                                </a>
                            </div>

                            {{-- شرط 3: آزمون رایگان یا پرداخت شده، و اولین بار است که شرکت می‌کند --}}
                        @else
                            <form action="{{ route('student.exams.start', $exam) }}" method="POST"
                                class="w-full sm:w-auto">
                                @csrf
                                <button type="submit"
                                    class="inline-flex w-full sm:w-auto items-center justify-center rounded-xl bg-green-600 px-6 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-400 focus:ring-offset-2 dark:focus:ring-offset-gray-900">
                                    شروع آزمون
                                </button>
                            </form>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
