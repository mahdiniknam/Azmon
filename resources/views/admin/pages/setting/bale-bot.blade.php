@extends('admin.layout.master')

@section('admin-title')
    تنظیمات ربات بله
@endsection

@section('admin-content')
    <main class="flex-1 overflow-y-auto p-6 bg-gray-50 dark:bg-gray-900">
        <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">تنظیمات ربات بله</h2>
                <p class="text-gray-600 dark:text-gray-400">تنظیمات اتصال به ربات پیام‌رسان بله برای اعلان‌ها</p>
            </div>
        </div>

        <div class="bg-white py-6 dark:bg-gray-800 rounded-xl shadow-md overflow-hidden border border-gray-200 dark:border-gray-700">
            <div class="px-6 pb-2 border-b border-gray-200 dark:border-gray-700">
                <h3 class="font-bold text-lg mb-4 relative pb-4 before:absolute before:start-0 before:bottom-0 before:size-2 before:rounded-full before:bg-primary after:absolute after:w-40 after:h-2 after:bottom-0 after:start-4 after:bg-primary after:rounded-lg">
                    پیکربندی ربات
                </h3>
            </div>
            
            <div class="p-6">
                <form action="#" method="POST" class="space-y-6 max-w-2xl">
                    @csrf
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">توکن ربات (Bot Token)</label>
                            <input type="text" name="bale_bot_token" value="{{ old('bale_bot_token', $settings['bale_bot_token'] ?? '') }}" class="w-full border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-lg p-2.5 focus:ring-primary focus:border-primary" placeholder="مثال: 123456789:ABCdefGHIjklMNOpqrSTUvwxYZ">
                            <p class="text-xs text-gray-500 mt-1">این توکن را از بات‌فادر در پیام‌رسان بله دریافت کنید.</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">شناسه چت مدیر (Chat ID)</label>
                            <input type="text" name="bale_admin_chat_id" value="{{ old('bale_admin_chat_id', $settings['bale_admin_chat_id'] ?? '') }}" class="w-full border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-lg p-2.5 focus:ring-primary focus:border-primary" placeholder="مثال: 123456789">
                            <p class="text-xs text-gray-500 mt-1">شناسه عددی کاربری شما در بله برای دریافت گزارشات ادمین.</p>
                        </div>
                        
                        <div class="flex items-center pt-4">
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="bale_bot_enabled" value="1" class="sr-only peer" {{ ($settings['bale_bot_enabled'] ?? false) ? 'checked' : '' }}>
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-[-100%] rtl:peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-primary"></div>
                                <span class="ms-3 text-sm font-medium text-gray-700 dark:text-gray-300">فعال‌سازی ربات بله</span>
                            </label>
                        </div>
                    </div>

                    <div class="pt-6 border-t border-gray-200 dark:border-gray-700">
                        <button type="submit" class="bg-primary hover:bg-primary-600 text-white font-medium py-2.5 px-6 rounded-lg transition-colors">
                            ذخیره تنظیمات
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>
@endsection
