<header class="flex items-center justify-between h-20 px-6 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
    <div class="flex items-center">
        <h2 class="text-xl font-bold text-gray-800 dark:text-white">پنل استاد</h2>
    </div>
    <div class="flex items-center gap-4">
        <span class="text-sm font-medium text-gray-700 dark:text-gray-200">{{ auth()->user()->name ?? 'استاد عزیز' }}</span>
        <form method="POST" action="{{ route('teacher.logout') ?? '#' }}">
            @csrf
            <button type="submit" class="text-sm text-red-600 hover:text-red-800">خروج</button>
        </form>
    </div>
</header>
