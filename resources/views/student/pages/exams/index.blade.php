@extends('student.layout.master')

@section('student-title')
    @lang('general.Arya Gostaran Management Panel') / لیست آزمون ها
@endsection

@section('student-content')
    <main class="flex-1 overflow-y-auto p-6 bg-gray-50 dark:bg-gray-900">
        <!-- header page -->
        <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">مدیریت آزمون ها</h2>
                <p class="text-gray-600 dark:text-gray-400">لیست آزمون ها</p>
            </div>
        </div>
        {{-- @include('admin.pages.filter', ['filters' => $filters, 'back' => route('admin.users.index')]) --}}
        <!-- Users list -->
        <div
            class="bg-white py-6 space-y-4 dark:bg-gray-800 rounded-xl shadow-md dark:shadow-gray-700 overflow-hidden border border-gray-200 dark:border-gray-700">
            <div class="px-6 pb-2 border-b border-gray-200 flex-wrap dark:border-gray-700 flex items-center justify-between">
                <h3
                    class="font-bold text-lg mb-4 relative pb-4 before:absolute before:start-0 before:bottom-0 before:size-2 before:rounded-full before:bg-primary after:absolute after:w-40 after:h-2 after:bottom-0 after:start-4 after:bg-primary after:rounded-lg">
                    لیست آزمون ها
                </h3>
            </div>
            <!-- Users table -->
            <div class="overflow-x-auto">
                <table class="w-full text-start">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th
                                class="px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                شناسه آزمون</th>
                            <th
                                class="px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                عنوان آزمون</th>
                            <th
                                class="px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                نوع آزمون</th>
                            <th
                                class="px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                قیمت آزمون (تومان)</th>
                            <th
                                class="px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                دسترسی آزمون</th>
                            <th
                                class="px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                تاریخ ایجاد</th>
                            <th
                                class="px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                @lang('general.operations')</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                        <!-- Users -->
                        @foreach ($exams as $exam)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                                    {{ $exam->id }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="ms-4">
                                            <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                {{ $exam->title }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                    {{ $exam->type }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                    {{ number_format($exam->price) }} </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if ($exam->is_public === 0)
                                        <span
                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                            خصوصی
                                        </span>
                                    @elseif ($exam->is_public === 1)
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

                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ jdate($exam->created_at)->format('Y/m/d - H:i') }}
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex items-center gap-4">
                                        @if (($exam->price ?? 0) > 0 && !auth()->user()->hasPaidForExam($exam))
                                            <a href="{{ route('payment.checkout', $exam) }}"
                                                class="inline-flex items-center rounded-lg bg-yellow-500 px-4 py-2 text-white hover:bg-yellow-600">
                                                پرداخت و شرکت در آزمون
                                            </a>
                                        @elseif ($exam->my_attempts_count > 0)
                                            <a href="{{ route('student.attempts.history') }}"
                                                class="inline-flex items-center rounded-lg bg-blue-600 px-4 py-2 text-white hover:bg-blue-700">
                                                مشاهده نتیجه
                                            </a>
                                            <a href="{{ route('student.exams.show', $exam) }}"
                                                class="inline-flex items-center rounded-lg bg-green-600 px-4 py-2 text-white hover:bg-green-700">
                                                جزئیات 
                                            </a>
                                        @else
                                            <a href="{{ route('student.exams.show', $exam) }}"
                                                class="inline-flex items-center rounded-lg bg-green-600 px-4 py-2 text-white hover:bg-green-700">
                                                شرکت در آزمون
                                            </a>
                                        @endif
                                    </div>
                                </td>


                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="bg-white dark:bg-gray-800 px-6 pt-4 border-t border-gray-200 dark:border-gray-700">
                <div class="flex flex-col md:flex-row items-center justify-between gap-4">

                    {{-- Info --}}
                    <div>
                        <p class="text-sm text-gray-700 dark:text-gray-300">
                            @lang('general.showing')
                            <span class="font-medium">{{ $exams->firstItem() }}</span>
                            @lang('general.to')
                            <span class="font-medium">{{ $exams->lastItem() }}</span>
                            @lang('general.from')
                            <span class="font-medium">{{ $exams->total() }}</span>
                            @lang('general.User')
                        </p>
                    </div>

                    {{-- Pagination buttons --}}
                    <div class="flex flex-wrap items-center gap-2">

                        {{-- Previous --}}
                        @if ($exams->onFirstPage())
                            <span
                                class="px-3 py-1 border rounded-lg text-sm text-gray-400 border-gray-300 dark:border-gray-600">
                                @lang('general.previous')
                            </span>
                        @else
                            <a href="{{ $exams->previousPageUrl() }}"
                                class="px-3 py-1 border rounded-lg text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 border-gray-300 dark:border-gray-600">
                                @lang('general.previous')
                            </a>
                        @endif

                        {{-- Pages --}}
                        @foreach ($exams->getUrlRange(1, $exams->lastPage()) as $page => $url)
                            @if ($page == $exams->currentPage())
                                <span
                                    class="px-3 py-1 border rounded-lg text-sm font-medium text-white bg-primary-600 dark:bg-primary-500 border-primary-600 dark:border-primary-500">
                                    {{ $page }}
                                </span>
                            @else
                                <a href="{{ $url }}"
                                    class="px-3 py-1 border rounded-lg text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 border-gray-300 dark:border-gray-600">
                                    {{ $page }}
                                </a>
                            @endif
                        @endforeach

                        {{-- Next --}}
                        @if ($exams->hasMorePages())
                            <a href="{{ $exams->nextPageUrl() }}"
                                class="px-3 py-1 border rounded-lg text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 border-gray-300 dark:border-gray-600">
                                @lang('general.next')
                            </a>
                        @else
                            <span
                                class="px-3 py-1 border rounded-lg text-sm text-gray-400 border-gray-300 dark:border-gray-600">
                                @lang('general.next')
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@push('scripts')
    <script src="{{ asset('assets/js/dependencies/app.js') }}"></script>
@endpush
