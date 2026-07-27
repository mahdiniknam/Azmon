<div class="hidden lg:flex lg:flex-shrink-0">
    <div class="flex flex-col w-72 bg-white dark:bg-gray-800 border-e border-gray-200 dark:border-gray-700 shadow-sm">
        <!-- logo -->
        <div class="flex items-center justify-center h-20 p-4 border-b border-gray-200 dark:border-gray-700">
            <div class="flex items-center">
                <div class="w-10 h-10 rounded-md bg-primary-grad flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
                <h1 class="ms-3 text-xl font-bold text-dark dark:text-light">@lang('general.Panel') <span
                        class="text-primary">دانشجو</span>
                </h1>
            </div>
        </div>

        <!-- menu -->
        <div class="flex flex-col flex-grow p-4 overflow-y-auto">
            <nav class="space-y-1">
                <!-- Exam Management -->
                {{-- Exam list --}}
                <a href="{{ route('student.exams.index') }}"
                    class="block text-sm px-4 py-2 rounded {{ request()->routeIs('student.exams.index') ? 'bg-primary-50 dark:bg-primary-900/30 text-primary-600 dark:text-primary-400 active' : 'text-gray-900 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline me-1" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2" />
                    </svg>
                    لیست آزمون ها
                </a>

                <a href="{{ route('student.attempts.history') }}"
                    class="block text-sm px-4 py-2 rounded {{ request()->routeIs('student.attempts.history') ? 'bg-primary-50 dark:bg-primary-900/30 text-primary-600 dark:text-primary-400 active' : 'text-gray-900 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline me-1" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    تاریخچه آزمون‌ها
                </a>
                <!-- Financial Management -->
                <a href="{{ route('student.payments.wallet') }}"
                    class="block text-sm px-4 py-2 rounded {{ request()->routeIs('student.payments.wallet') ? 'bg-primary-50 dark:bg-primary-900/30 text-primary-600 dark:text-primary-400 active' : 'text-gray-900 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline me-1" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                    </svg>
                    کیف پول
                </a>

                <a href="{{ route('student.payments.index') }}"
                    class="block text-sm px-4 py-2 rounded {{ request()->routeIs('student.payments.index') ? 'bg-primary-50 dark:bg-primary-900/30 text-primary-600 dark:text-primary-400 active' : 'text-gray-900 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline me-1" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    تاریخچه پرداخت‌ها
                </a>

                  <a href="{{ route('student.show.setting.bot') }}"
                    class="block text-sm px-4 py-2 rounded {{ request()->routeIs('student.payments.index') ? 'bg-primary-50 dark:bg-primary-900/30 text-primary-600 dark:text-primary-400 active' : 'text-gray-900 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline me-1" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                   اتصال به ربات بله
                </a>


            </nav>

            <!-- Admin Info -->
            <div class="mt-auto p-4 bg-gray-50 dark:bg-gray-900 rounded-xl">
                <div class="flex items-center">
                    <div class="relative">
                        <img class="h-12 w-12 rounded-full border-2 border-white dark:border-gray-800 shadow"
                            src="{{ asset('assets/images/user/user.png') }}" alt="Admin avatar">
                        <span
                            class="absolute bottom-0 start-0 w-3 h-3 rounded-full bg-green-500 dark:bg-green-400 border-2 border-white dark:border-gray-800"></span>
                    </div>
                    <div class="ms-3">
                        <p class="text-sm font-medium text-gray-900 dark:text-white">
                            {{ auth('web')->user()->name }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">دانشجو</p>
                    </div>
                </div>
                <button
                    class="mt-4 w-full flex items-center justify-center px-4 py-2 text-sm text-gray-600 dark:text-gray-300 bg-white dark:bg-gray-700 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600 border border-gray-200 dark:border-gray-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 me-2" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M3 3a1 1 0 00-1 1v12a1 1 0 102 0V4a1 1 0 00-1-1zm10.293 9.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L14.586 9H7a1 1 0 100 2h7.586l-1.293 1.293z"
                            clip-rule="evenodd" />
                    </svg>
                    @lang('general.Exit from the account')
                </button>
            </div>
        </div>
    </div>
</div>
