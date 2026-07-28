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
                <h1 class="ms-3 text-xl font-bold text-dark dark:text-light">پنل <span
                        class="text-primary">مدیر </span>
                </h1>
            </div>
        </div>

        <!-- menu -->
        <div class="flex flex-col flex-grow p-4 overflow-y-auto">
            <nav class="space-y-1">
                <!-- Dashboard -->
                <a href="{{ route('admin.dashboard') }}"
                    class="flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ request()->routeIs('admin.dashboard') ? 'bg-primary-50 dark:bg-primary-900/30 text-primary-600 dark:text-primary-400 active' : '' }}  ">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline me-2" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    @lang('general.The counter')
                    @if (request()->routeIs('admin.dashboard'))
                        <span class="ms-auto w-2 h-2 rounded-full bg-primary-600 dark:bg-primary-400"></span>
                    @endif
                </a>
                <!-- Users Management -->
                <div class="space-y-1">
                    <button type="button"
                        class="w-full flex items-center justify-between px-4 py-3 text-sm font-medium rounded-lg"
                        onclick="toggleMenu('users-menu', 'users-arrow-icon')">
                        <span class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline me-2" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                            @lang('general.Users Management')
                        </span>
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="h-4 w-4 transition-transform duration-300 {{ request()->routeIs('admin.users.*') ? 'rotate-180' : '' }}"
                            id="users-arrow-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                            </path>
                        </svg>
                    </button>
                    <div id="users-menu"
                        class="{{ request()->routeIs('admin.users.*') ? '' : 'hidden' }} me-6 space-y-1">
                        <a href="{{ route('admin.users.index') }}"
                            class="block text-sm px-4 py-2 rounded {{ request()->routeIs('admin.users.index') ? 'bg-primary-50 dark:bg-primary-900/30 text-primary-600 dark:text-primary-400 active' : 'text-gray-900 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline me-1" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                            @lang('general.Users list')
                        </a>
                        <a href="{{ route('admin.users.create') }}"
                            class="block text-sm px-4 py-2 rounded {{ request()->routeIs('admin.users.create') ? 'bg-primary-50 dark:bg-primary-900/30 text-primary-600 dark:text-primary-400 active' : 'text-gray-900 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline me-1" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            @lang('general.Add the user')
                        </a>
                    </div>
                </div>

                <!-- Admins Management -->
                <div class="space-y-1">
                    <button type="button"
                        class="w-full flex items-center justify-between px-4 py-3 text-sm font-medium rounded-lg"
                        onclick="toggleMenu('admins-menu', 'admins-arrow-icon')">
                        <span class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline me-2" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                            @lang('general.Admins Management')
                        </span>
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="h-4 w-4 transition-transform duration-300 {{ request()->routeIs('admin.admins.*') ? 'rotate-180' : '' }}"
                            id="admins-arrow-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                            </path>
                        </svg>
                    </button>
                    <div id="admins-menu"
                        class="{{ request()->routeIs('admin.admins.*', 'admin.roles.index') ? '' : 'hidden' }} me-6 space-y-1">
                        <a href="{{ route('admin.admins.index') }}"
                            class="block text-sm px-4 py-2 rounded {{ request()->routeIs('admin.admins.index') ? 'bg-primary-50 dark:bg-primary-900/30 text-primary-600 dark:text-primary-400 active' : 'text-gray-900 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline me-1" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                            @lang('general.Admins list')
                        </a>
                        <a href="{{ route('admin.admins.create') }}"
                            class="block text-sm px-4 py-2 rounded {{ request()->routeIs('admin.admins.create') ? 'bg-primary-50 dark:bg-primary-900/30 text-primary-600 dark:text-primary-400 active' : 'text-gray-900 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline me-1" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            @lang('general.Add the admin')
                        </a>
                        <a href="{{ route('admin.roles.index') }}"
                            class="block text-sm px-4 py-2 rounded {{ request()->routeIs('admin.roles.index') ? 'bg-primary-50 dark:bg-primary-900/30 text-primary-600 dark:text-primary-400 active' : 'text-gray-900 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline me-1" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            @lang('general.manage_role')
                        </a>
                    </div>
                </div>

                 <!-- Subject Management -->
                <div class="space-y-1">
                    <button type="button"
                        class="w-full flex items-center justify-between px-4 py-3 text-sm font-medium rounded-lg"
                        onclick="toggleMenu('subjects-menu', 'subjects-arrow-icon')">
                        <span class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline me-2" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 8h10M7 12h6m-8 8h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            مدیریت درس ها
                        </span>
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="h-4 w-4 transition-transform duration-300 {{ request()->routeIs('admin.subjects.*') ? 'rotate-180' : '' }}"
                            id="subjects-arrow-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                            </path>
                        </svg>
                    </button>

                    <div id="subjects-menu"
                        class="{{ request()->routeIs('admin.subjects.*') ? '' : 'hidden' }} me-6 space-y-1">

                        {{-- Tickets list --}}
                        <a href="{{ route('admin.subjects.index') }}"
                            class="block text-sm px-4 py-2 rounded {{ request()->routeIs('admin.subjects.index') ? 'bg-primary-50 dark:bg-primary-900/30 text-primary-600 dark:text-primary-400 active' : 'text-gray-900 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline me-1" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2" />
                            </svg>
                         لیست درس ها
                        </a>

                        {{-- Create ticket (اختیاری) --}}
                        <a href="{{ route('admin.subjects.create') }}"
                            class="block text-sm px-4 py-2 rounded {{ request()->routeIs('admin.subjects.create') ? 'bg-primary-50 dark:bg-primary-900/30 text-primary-600 dark:text-primary-400 active' : 'text-gray-900 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline me-1" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                           ایجاد درس جدید
                        </a>
                    </div>
                </div>

                  <!-- Question Management -->
                <div class="space-y-1">
                    <button type="button"
                        class="w-full flex items-center justify-between px-4 py-3 text-sm font-medium rounded-lg"
                        onclick="toggleMenu('questions-menu', 'questions-arrow-icon')">
                        <span class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline me-2" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 8h10M7 12h6m-8 8h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            مدیریت سوالات
                        </span>
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="h-4 w-4 transition-transform duration-300 {{ request()->routeIs('admin.questions.*') ? 'rotate-180' : '' }}"
                            id="questions-arrow-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                            </path>
                        </svg>
                    </button>

                    <div id="questions-menu"
                        class="{{ request()->routeIs('admin.questions.*') ? '' : 'hidden' }} me-6 space-y-1">

                        {{-- Question list --}}
                        <a href="{{ route('admin.questions.index') }}"
                            class="block text-sm px-4 py-2 rounded {{ request()->routeIs('admin.questions.index') ? 'bg-primary-50 dark:bg-primary-900/30 text-primary-600 dark:text-primary-400 active' : 'text-gray-900 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline me-1" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2" />
                            </svg>
                         لیست سوالات
                        </a>

                        {{-- Create quetions (اختیاری) --}}
                        <a href="{{ route('admin.questions.create') }}"
                            class="block text-sm px-4 py-2 rounded {{ request()->routeIs('admin.questions.create') ? 'bg-primary-50 dark:bg-primary-900/30 text-primary-600 dark:text-primary-400 active' : 'text-gray-900 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline me-1" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                           ایجاد سوال جدید
                        </a>
                    </div>
                </div>

                   <!-- Exam Management -->
                <div class="space-y-1">
                    <button type="button"
                        class="w-full flex items-center justify-between px-4 py-3 text-sm font-medium rounded-lg"
                        onclick="toggleMenu('exams-menu', 'exams-arrow-icon')">
                        <span class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline me-2" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 8h10M7 12h6m-8 8h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            مدیریت آزمون ها
                        </span>
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="h-4 w-4 transition-transform duration-300 {{ request()->routeIs('admin.exams.*') ? 'rotate-180' : '' }}"
                            id="exams-arrow-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                            </path>
                        </svg>
                    </button>

                    <div id="exams-menu"
                        class="{{ request()->routeIs('admin.exams.*') ? '' : 'hidden' }} me-6 space-y-1">

                        {{-- Exam list --}}
                        <a href="{{ route('admin.exams.index') }}"
                            class="block text-sm px-4 py-2 rounded {{ request()->routeIs('admin.exams.index') ? 'bg-primary-50 dark:bg-primary-900/30 text-primary-600 dark:text-primary-400 active' : 'text-gray-900 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline me-1" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2" />
                            </svg>
                         لیست آزمون ها
                        </a>

                        {{-- Create exams --}}
                        <a href="{{ route('admin.exams.create') }}"
                            class="block text-sm px-4 py-2 rounded {{ request()->routeIs('admin.exams.create') ? 'bg-primary-50 dark:bg-primary-900/30 text-primary-600 dark:text-primary-400 active' : 'text-gray-900 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline me-1" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                           ایجاد آزمون جدید
                        </a>
                    </div>
                </div>             

                <!-- Settings -->
                <a href="{{ route('admin.setting.index') }}"
                    class="block px-4 py-3 text-sm font-medium text-gray-900 rounded-lg hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline me-2" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    @lang('general.System settings')
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
                            {{ auth('admin')->user()->full_name }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">@lang('general.Access: Director General')</p>
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
