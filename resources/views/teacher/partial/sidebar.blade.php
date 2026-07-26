<div class="hidden lg:flex lg:flex-shrink-0">
    <div class="flex flex-col w-72 bg-white dark:bg-gray-800 border-e border-gray-200 dark:border-gray-700 shadow-sm">
        <div class="flex items-center justify-center h-20 p-4 border-b border-gray-200 dark:border-gray-700">
            <h1 class="ms-3 text-xl font-bold text-dark dark:text-light">پنل <span class="text-primary">استاد</span></h1>
        </div>
        <div class="flex flex-col flex-grow p-4 overflow-y-auto">
            <nav class="space-y-1">
                <a href="{{ route('teacher.dashboard') }}" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ request()->routeIs('teacher.dashboard') ? 'bg-primary-50 dark:bg-primary-900/30 text-primary-600 dark:text-primary-400 active' : '' }}">
                    داشبورد
                </a>
                <a href="{{ route('teacher.subjects.index') }}" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ request()->routeIs('teacher.subjects.*') ? 'bg-primary-50 text-primary-600' : '' }}">
                    مدیریت دروس
                </a>
                <a href="{{ route('teacher.questions.index') }}" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ request()->routeIs('teacher.questions.*') ? 'bg-primary-50 text-primary-600' : '' }}">
                    مدیریت سوالات
                </a>
                <a href="{{ route('teacher.exams.index') }}" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ request()->routeIs('teacher.exams.*') ? 'bg-primary-50 text-primary-600' : '' }}">
                    مدیریت آزمون‌ها
                </a>
                <a href="{{ route('teacher.reports.index') }}" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ request()->routeIs('teacher.reports.*') ? 'bg-primary-50 text-primary-600' : '' }}">
                    گزارشات
                </a>
            </nav>
        </div>
    </div>
</div>
