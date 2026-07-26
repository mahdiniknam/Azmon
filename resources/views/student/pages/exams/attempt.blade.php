<!doctype html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>آزمون: {{ $exam->title }}</title>

    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">
    <link rel="preload" href="{{ asset('assets/fonts/payda/PeydaWebFaNum-Medium.woff2') }}" as="font"
        type="font/woff2" crossorigin>
</head>

<body class="min-h-screen bg-gray-100 font-sans text-gray-900 dark:bg-gray-900 dark:text-white">

    @php
        $totalQuestions = count($ordered);
    @endphp

    <div class="flex min-h-screen flex-col">

        {{-- Header --}}
        <header
            class="sticky top-0 z-30 border-b border-gray-200 bg-white/95 backdrop-blur dark:border-gray-700 dark:bg-gray-800/95">
            <div
                class="mx-auto flex max-w-7xl flex-col gap-4 px-4 py-4 sm:px-6 lg:px-8 md:flex-row md:items-center md:justify-between">
                <div class="min-w-0">
                    <h1 class="truncate text-lg font-extrabold text-gray-900 dark:text-white sm:text-xl">
                        {{ $exam->title }}
                    </h1>
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400 sm:text-sm">
                        تعداد سوالات: {{ $totalQuestions }} |
                        مدت آزمون: {{ $exam->duration }} دقیقه
                    </p>
                </div>

                <div class="flex flex-wrap items-center gap-3">
                    <div
                        class="inline-flex items-center gap-2 rounded-xl bg-blue-100 px-4 py-2 font-mono text-base font-bold text-blue-800 dark:bg-blue-900/40 dark:text-blue-100 sm:text-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span id="timer">--:--</span>
                    </div>

                    <form action="{{ route('student.attempts.finish', $attempt) }}" method="POST" id="finish-form">
                        @csrf
                        <button type="button" onclick="confirmFinish()"
                            class="inline-flex items-center justify-center rounded-xl bg-red-500 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-400 focus:ring-offset-2 dark:focus:ring-offset-gray-900">
                            ثبت نهایی و پایان
                        </button>
                    </form>
                </div>
            </div>
        </header>

        {{-- Main Layout --}}
        <div class="mx-auto flex w-full max-w-7xl flex-1 flex-col gap-6 px-4 py-6 sm:px-6 lg:px-8 xl:flex-row">

            {{-- Questions Navigator --}}
            <aside class="order-1 xl:order-2 xl:w-80 xl:shrink-0">
                <div
                    class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-700 dark:bg-gray-800 xl:sticky xl:top-24">
                    <div class="mb-4">
                        <h2 class="text-base font-extrabold text-gray-900 dark:text-white sm:text-lg">
                            نقشه سوالات
                        </h2>
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400 sm:text-sm">
                            برای جابه‌جایی سریع بین سوالات از این بخش استفاده کنید.
                        </p>
                    </div>

                    <div class="grid grid-cols-5 gap-2 sm:grid-cols-6 xl:grid-cols-5">
                        @foreach ($ordered as $index => $question)
                            <button type="button" onclick="goToQuestion({{ $index }})"
                                id="nav-btn-{{ $index }}"
                                class="flex aspect-square items-center justify-center rounded-xl border text-sm font-bold transition
                                    {{ $index === 0
                                        ? 'border-primary bg-primary text-white'
                                        : 'border-gray-300 bg-white text-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-200 dark:hover:bg-gray-700' }}">
                                {{ $index + 1 }}
                            </button>
                        @endforeach
                    </div>

                    <div
                        class="mt-6 space-y-3 border-t border-gray-200 pt-4 text-xs text-gray-600 dark:border-gray-700 dark:text-gray-300 sm:text-sm">
                        <div class="flex items-center gap-2">
                            <span class="h-4 w-4 rounded bg-green-500"></span>
                            <span>پاسخ داده شده</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="h-4 w-4 rounded bg-primary"></span>
                            <span>سوال فعلی</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="h-4 w-4 rounded border border-gray-300 dark:border-gray-600"></span>
                            <span>پاسخ داده نشده</span>
                        </div>
                    </div>
                </div>
            </aside>

            {{-- Question Content --}}
            <main class="order-2 min-w-0 flex-1 xl:order-1">
                <div class="space-y-6">

                    @foreach ($ordered as $index => $question)
                        <section id="question-{{ $index }}"
                            class="question-slide {{ $index === 0 ? 'block' : 'hidden' }}">
                            <div
                                class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm dark:border-gray-700 dark:bg-gray-800">
                                {{-- Question header --}}
                                <div class="border-b border-gray-200 px-5 py-4 dark:border-gray-700 sm:px-6">
                                    <div class="flex items-start gap-3">
                                        <span
                                            class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-primary text-sm font-bold text-white">
                                            {{ $index + 1 }}
                                        </span>
                                        <div class="min-w-0">
                                            <p class="text-xs font-medium text-gray-500 dark:text-gray-400 sm:text-sm">
                                                سوال {{ $index + 1 }} از {{ $totalQuestions }}
                                            </p>
                                            <h2
                                                class="mt-1 text-base font-bold leading-8 text-gray-900 dark:text-white sm:text-lg">
                                                {{ $question->question_text }}
                                            </h2>
                                        </div>
                                    </div>
                                </div>

                                {{-- Options --}}
                                <div class="px-5 py-5 sm:px-6 sm:py-6">
                                    <div class="space-y-3">
                                        @php
                                            $selectedOptionId = optional($attempt->answers->firstWhere('question_id', $question->id))->option_id;
                                        @endphp
                                        @foreach ($question->options as $option)
                                            <label
                                                class="group flex cursor-pointer items-start gap-3 rounded-xl border border-gray-200 bg-white p-4 transition hover:border-primary hover:bg-blue-50/40 dark:border-gray-700 dark:bg-gray-800 dark:hover:border-primary dark:hover:bg-gray-700/40">
                                                <input type="radio" name="q_{{ $question->id }}"
                                                    value="{{ $option->id }}"
                                                    class="mt-1 h-5 w-5 shrink-0 border-gray-300 text-primary focus:ring-primary"
                                                    {{ $selectedOptionId == $option->id ? 'checked' : '' }}
                                                    onchange="submitAnswer({{ $question->id }}, {{ $option->id }}, {{ $index }})">
                                                <span
                                                    class="text-sm leading-7 text-gray-800 dark:text-gray-100 sm:text-base">
                                                    {{ $option->option_text }}
                                                </span>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </section>
                    @endforeach

                    {{-- Navigation --}}
                    <div
                        class="sticky bottom-0 z-20 border-t border-gray-200 bg-gray-100/95 py-4 backdrop-blur dark:border-gray-700 dark:bg-gray-900/95">
                        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                            <button type="button" id="prev-btn" onclick="prevQuestion()"
                                class="hidden inline-flex items-center justify-center rounded-xl bg-gray-200 px-5 py-3 text-sm font-semibold text-gray-800 transition hover:bg-gray-300 dark:bg-gray-700 dark:text-white dark:hover:bg-gray-600">
                                سوال قبلی
                            </button>

                            <div class="text-center text-xs text-gray-500 dark:text-gray-400 sm:text-sm">
                                سوال
                                <span id="current-question-label">1</span>
                                از
                                {{ $totalQuestions }}
                            </div>

                            <button type="button" id="next-btn" onclick="nextQuestion()"
                                class="{{ $totalQuestions <= 1 ? 'hidden' : 'inline-flex' }} items-center justify-center rounded-xl bg-primary px-5 py-3 text-sm font-semibold text-white transition hover:bg-primary-600">
                                سوال بعدی
                            </button>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script>
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const suspiciousUrl = '{{ route('student.attempts.suspicious', $attempt) }}';
        const answerUrl = '{{ route('student.attempts.answers.store', $attempt) }}';
        const totalQuestions = {{ $totalQuestions }};
        let currentQuestion = 0;

        // Timer
        let durationSeconds = {{ $exam->duration * 60 }};
        let startTime = new Date("{{ $attempt->started_at }}").getTime();

        function updateTimer() {
            let now = new Date().getTime();
            let elapsed = Math.floor((now - startTime) / 1000);
            let remaining = durationSeconds - elapsed;

            if (remaining <= 0) {
                document.getElementById('timer').innerText = "00:00";
                document.getElementById('finish-form').submit();
                return;
            }

            let minutes = Math.floor(remaining / 60);
            let seconds = remaining % 60;

            document.getElementById('timer').innerText =
                (minutes < 10 ? "0" : "") + minutes + ":" + (seconds < 10 ? "0" : "") + seconds;
        }

        setInterval(updateTimer, 1000);
        updateTimer();

        function resetCurrentNavStyle() {
            document.querySelectorAll('[id^="nav-btn-"]').forEach((el) => {
                const isAnswered = el.classList.contains('bg-green-500');

                if (!isAnswered) {
                    el.classList.remove('bg-primary', 'text-white', 'border-primary');
                    el.classList.add('border-gray-300', 'bg-white', 'text-gray-700', 'dark:border-gray-600',
                        'dark:bg-gray-800', 'dark:text-gray-200');
                }
            });
        }

        function goToQuestion(index) {
            if (index < 0 || index >= totalQuestions) return;

            document.querySelectorAll('.question-slide').forEach((el) => {
                el.classList.add('hidden');
                el.classList.remove('block');
            });

            const currentSlide = document.getElementById('question-' + index);
            currentSlide.classList.remove('hidden');
            currentSlide.classList.add('block');

            resetCurrentNavStyle();

            const navBtn = document.getElementById('nav-btn-' + index);
            if (!navBtn.classList.contains('bg-green-500')) {
                navBtn.classList.remove('border-gray-300', 'bg-white', 'text-gray-700', 'dark:border-gray-600',
                    'dark:bg-gray-800', 'dark:text-gray-200');
                navBtn.classList.add('bg-primary', 'text-white', 'border-primary');
            }

            currentQuestion = index;

            document.getElementById('current-question-label').innerText = index + 1;
            document.getElementById('prev-btn').classList.toggle('hidden', currentQuestion === 0);
            document.getElementById('next-btn').classList.toggle('hidden', currentQuestion === totalQuestions - 1);

            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        }

        function nextQuestion() {
            goToQuestion(currentQuestion + 1);
        }

        function prevQuestion() {
            goToQuestion(currentQuestion - 1);
        }

        // ضد تقلب ساده
        document.addEventListener('visibilitychange', function() {
            if (document.hidden) {
                reportSuspicious('tab_switch');
            }
        });

        document.addEventListener('contextmenu', function(e) {
            e.preventDefault();
            reportSuspicious('right_click');
        });

        document.addEventListener('copy', function(e) {
            e.preventDefault();
            reportSuspicious('copy');
        });

        document.addEventListener('cut', function(e) {
            e.preventDefault();
            reportSuspicious('copy');
        });

        document.addEventListener('selectstart', function(e) {
            e.preventDefault();
        });

        // اینسپکت / F12
        document.addEventListener('keydown', function(e) {
            if (
                e.key === 'F12' ||
                (e.ctrlKey && e.shiftKey && (e.key === 'I' || e.key === 'i' || e.key === 'J' || e.key === 'j' || e.key === 'C' || e.key === 'c')) ||
                (e.ctrlKey && (e.key === 'u' || e.key === 'U'))
            ) {
                e.preventDefault();
                reportSuspicious('inspect');
            }
        });

        // اگه پنل دولوپر باز باشه
        setInterval(function() {
            var w = window.outerWidth - window.innerWidth;
            var h = window.outerHeight - window.innerHeight;
            if (w > 160 || h > 160) {
                reportSuspicious('inspect');
            }
        }, 2000);

        function reportSuspicious(type) {
            fetch(suspiciousUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    type: type,
                    payload: {}
                })
            }).catch(function(e) {
                console.error(e);
            });
        }

        function markAnswered(index) {
            const navBtn = document.getElementById('nav-btn-' + index);

            navBtn.classList.remove(
                'bg-primary',
                'border-primary',
                'border-gray-300',
                'bg-white',
                'text-gray-700',
                'dark:border-gray-600',
                'dark:bg-gray-800',
                'dark:text-gray-200'
            );

            navBtn.classList.add('bg-green-500', 'text-white', 'border-green-500');
        }

        function submitAnswer(questionId, optionId, index) {
            markAnswered(index);

            fetch(answerUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    question_id: questionId,
                    question_option_id: optionId
                })
            }).catch((e) => console.error(e));
        }

        function confirmFinish() {
            if (confirm('آیا از پایان آزمون اطمینان دارید؟ این عملیات غیرقابل بازگشت است.')) {
                document.getElementById('finish-form').submit();
            }
        }
    </script>
</body>

</html>
