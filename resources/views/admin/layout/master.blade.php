<!doctype html>
<html lang="fa" dir="{{ app()->getLocale() == 'fa' ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('admin-title')</title>
    <meta name="description" content="پنل مدیریت سیستم آزمون ساز آنلاین   ">
    <meta name="keywords" content="پنل مدیریت سیستم آزمون ساز آنلاین">
    <meta name="robots" content="noindex, nofollow">
    <meta name="author" content="آزمون ساز آنلاین">
    <meta name="copyright" content="تمامی حقوق متعلق به آزمون ساز آنلاین است.">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/images/favicon_io/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32"
        href="{{ asset('assets/images/favicon_io/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16"
        href="{{ asset('assets/images/favicon_io/favicon-16x16.png') }}">
    <link rel="canonical" href="https://example.com/admin-panel">
    <link rel="stylesheet" href="{{ asset('assets/js/plugin/swiper/swiper-bundle.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/select2.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/datePicker.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">
    <link rel="preload" href="{{ asset('assets/fonts/payda/PeydaWebFaNum-Medium.woff2') }}" as="font"
        type="font/woff2" crossorigin>

</head>

<body
    class="bg-light dark:bg-background-dark text-text-primary-light dark:text-text-primary-dark transition-colors duration-200">
    <div class="flex h-screen overflow-hidden max-w-[1920px] mx-auto">
        <!-- sidebar -->
        @include('admin.partial.sidebar')
        <!-- main content -->
        <div class="flex flex-col flex-1 overflow-hidden">
            <!-- header -->
            @include('admin.partial.header')
            <!-- component alert -->
            @include('components.alerts')
            <!-- <x-alerts /> -->
            <!-- page content -->
            @yield('admin-content')
        </div>
    </div>

    <!-- start canvas message -->

    <div id="offcanvas-user-message-left"
        class="offcanvas invisible dark:bg-background-dark dark:text-white fixed top-0 end-0 sm:w-100 w-[80%] h-full bg-white shadow-lg transform -translate-x-full transition-transform opacity-0 z-50"
        role="dialog" aria-labelledby="cart-title" aria-modal="true">
        <!-- Header -->
        <header class="border-b p-3 flex items-center justify-between border-gray-400">
            <h2 id="cart-title" class="font-bold text-base">@lang('general.Your messages')</h2>
            <button onclick="closeOffcanvas()" class="cursor-pointer" aria-label="بستن ">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                </svg>
            </button>
        </header>
        <!-- message Items -->
        <main class="relative space-y-4 divide-y divide-gray-200 p-3 overflow-y-scroll h-full">
            <!-- message one -->
            {{-- <div class="bg-white last:mb-20 border border-gray-400 rounded-2xl shadow-md dark:bg-card-dark dark:text-white overflow-hidden p-5 space-y-3">
                <div class="flex items-start space-x-3 rtl:space-x-reverse">
                    <div class="flex flex-col space-y-2">
                        <div class="flex items-center space-x-2">
                            <img class="h-12 w-12 rounded-full" src="assets/images/user/user.jpg" alt="آواتار کاربر">
                            <p class="text-sm  text-gray-900 dark:text-white">کاربر مهمان</p>
                            <span class="px-2 py-0.5 rounded-full text-xs font-medium bg-primary-grad text-white text-primary-800 ">جدید</span>
                        </div>
                        <p class="mt-1 dark:text-white ms-3 text-sm text-gray-600">
                            سلام! این یک پیغام شبیه به توئیت است که می‌توانید برای چت یا نظرات استفاده کنید.
                        </p>
                        <div class="mt-2 flex items-center space-x-4 text-gray-500 text-sm">
                            <div class="flex items-center">
                                <svg class="me-1 h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                </svg>
                                ۲ دقیقه پیش
                            </div>
                            <button class="text-primary hover:text-primary-700 dark:text-primary-400 dark:hover:text-primary-500 font-medium">پاسخ</button>
                        </div>
                    </div>
                </div>
            </div> --}}
            <!-- message two -->
            {{-- <div class="bg-white last:mb-20 border border-gray-400 rounded-2xl shadow-md dark:bg-card-dark dark:text-white overflow-hidden p-5 space-y-3">
                <div class="flex items-start space-x-3 rtl:space-x-reverse">
                    <div class="flex flex-col space-y-2">
                        <div class="flex items-center space-x-2">
                            <img class="h-12 w-12 rounded-full" src="assets/images/user/user.jpg" alt="آواتار کاربر">
                            <p class="text-sm  text-gray-900 dark:text-white">کاربر مهمان</p>
                            <span class="px-2 py-0.5 rounded-full text-xs font-medium bg-primary-grad text-white text-primary-800 ">جدید</span>
                        </div>
                        <p class="mt-1 dark:text-white ms-3 text-sm text-gray-600">
                            سلام! این یک پیغام شبیه به توئیت است که می‌توانید برای چت یا نظرات استفاده کنید.
                        </p>
                        <div class="mt-2 flex items-center space-x-4 text-gray-500 text-sm">
                            <div class="flex items-center">
                                <svg class="me-1 h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                </svg>
                                ۲ دقیقه پیش
                            </div>
                            <button class="text-primary hover:text-primary-700 dark:text-primary-400 dark:hover:text-primary-500 font-medium">پاسخ</button>
                        </div>
                    </div>
                </div>
            </div> --}}
        </main>
    </div>
    <!-- Overlay -->
    <div class="overlay transition fixed inset-0 z-40 bg-black/70 hidden" onclick="closeOffcanvas()" role="presentation"
        aria-hidden="true"></div>

    <!-- /canvas message -->

    <!-- start canvas language -->
    <div id="offcanvas-language-left"
        class="offcanvas invisible dark:bg-background-dark dark:text-white fixed top-0 end-0 sm:w-100 w-[80%] h-full bg-white shadow-lg transform -translate-x-full transition-transform opacity-0 z-50"
        role="dialog" aria-labelledby="language-title" aria-modal="true">

        <!-- Header -->
        <header class="border-b p-3 flex items-center justify-between border-gray-400">
            <h2 id="language-title" class="font-bold text-base">
                @lang('general.Language')
            </h2>
            <button onclick="closeOffcanvas()" class="cursor-pointer" aria-label="بستن">
                <svg xmlns="http://www.w3.org/2000/svg" class="size-8" fill="none" viewBox="0 0 24 24"
                    stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                </svg>
            </button>
        </header>

        <!-- Language Items -->
        <main class="relative space-y-3 p-3 overflow-y-auto h-full">

            @php
                $languages = [
                    'fa' => 'فارسی',
                    'en' => 'English',
                    'ar' => 'العربية',
                    'de' => 'Deutsch',
                    'es' => 'Español',
                    'ru' => 'Русский',
                    'zh' => '中文',
                ];
            @endphp

            @foreach ($languages as $key => $label)
                <a href="{{ url('lang/' . $key) }}"
                    class="flex items-center justify-between p-4 border border-gray-300 rounded-xl shadow-sm
                      hover:bg-gray-100 dark:hover:bg-gray-700
                      dark:bg-card-dark dark:border-gray-600">

                    <span class="text-sm font-medium">
                        {{ $label }}
                    </span>

                    @if (app()->getLocale() === $key)
                        <span class="px-2 py-0.5 rounded-full text-xs font-medium bg-primary-grad text-white">
                            @lang('general.Active')
                        </span>
                    @endif
                </a>
            @endforeach

        </main>
    </div>
    <!-- Overlay -->
    <div class="overlay transition fixed inset-0 z-40 bg-black/70 hidden" onclick="closeOffcanvas()" role="presentation"
        aria-hidden="true"></div>
    <!-- /canvas language -->


    <!-- start canvas responsive menu -->

    <div id="offcanvas-responsive-menu-right"
        class="offcanvas invisible dark:bg-background-dark dark:text-white fixed top-0 start-0 sm:w-100 w-[80%] h-full bg-white shadow-lg transform -translate-x-full transition-transform opacity-0 z-50"
        role="dialog" aria-labelledby="cart-title" aria-modal="true">
        <!-- Header -->
        <header class="border-b p-3 flex items-center justify-between border-gray-400">
            <h2 class="font-bold text-base">پنل ادمین</h2>
            <button onclick="closeOffcanvas()" class="cursor-pointer" aria-label="بستن ">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                </svg>
            </button>
        </header>
        <!-- menu Items -->
        <main class="p-3 overflow-y-scroll h-full">
            <div class="flex pb-10 rounded flex-col w-full h-full bg-card-light dark:bg-card-dark">
                <!-- logo -->
                <div class="flex items-center justify-center h-20 p-4 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex items-center">
                        <div class="w-10 h-10 rounded-md bg-primary-grad flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <h1 class="ms-3 text-xl font-bold text-dark dark:text-light">پنل <span
                                class="text-primary">مدیریت </span>
                        </h1>
                    </div>
                </div>

                <!-- menu -->
                <div class="flex flex-col flex-grow p-4 overflow-y-auto">
                    <nav class="space-y-1">
                        <!-- Dashboard -->
                        <a href="{{ route('admin.dashboard') }}"
                            class="flex items-center px-4 py-3 text-sm font-medium rounded-lg bg-primary-50 dark:bg-primary-900/30 text-primary-600 dark:text-primary-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline me-2" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                            پیشخوان
                            <span class="ms-auto w-2 h-2 rounded-full bg-primary-600 dark:bg-primary-400"></span>
                        </a>

                        <!-- Users Management -->
                        <div class="space-y-1">
                            <button type="button"
                                class="w-full flex items-center justify-between px-4 py-3 text-sm font-medium text-gray-900 rounded-lg hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700"
                                onclick="toggleMenu('users-menu-mobile', 'users-arrow-icon-mobile')">
                                <span class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline me-2"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                    </svg>
                                    مدیریت کاربران
                                </span>
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="h-4 w-4 transition-transform duration-300" id="users-arrow-icon-mobile"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>

                            <div id="users-menu-mobile" class="hidden me-6 space-y-1">
                                <a href="{{ route('admin.users.index') }}"
                                    class="block text-sm px-4 py-2 text-gray-900 rounded hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline me-1"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                    لیست کاربران
                                </a>

                                <a href="{{ route('admin.users.create') }}"
                                    class="block text-sm px-4 py-2 text-gray-900 rounded hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline me-1"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                    </svg>
                                    افزودن کاربر
                                </a>

                                <a href="admin-panel-user-roles.html"
                                    class="block text-sm px-4 py-2 text-gray-900 rounded hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline me-1"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                    </svg>
                                    نقش‌های کاربری
                                </a>
                            </div>
                        </div>

                        <!-- Admins Management -->
                        <div class="space-y-1">
                            <button type="button"
                                class="w-full flex items-center justify-between px-4 py-3 text-sm font-medium text-gray-900 rounded-lg hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700"
                                onclick="toggleMenu('admins-menu-mobile', 'admins-arrow-icon-mobile')">
                                <span class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline me-2"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                    </svg>
                                    مدیریت مدیران
                                </span>
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="h-4 w-4 transition-transform duration-300" id="admins-arrow-icon-mobile"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>

                            <div id="admins-menu-mobile" class="hidden me-6 space-y-1">
                                <a href="{{ route('admin.admins.index') }}"
                                    class="block text-sm px-4 py-2 text-gray-900 rounded hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline me-1"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                    لیست مدیران
                                </a>

                                <a href="{{ route('admin.admins.create') }}"
                                    class="block text-sm px-4 py-2 text-gray-900 rounded hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline me-1"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                    </svg>
                                    افزودن ادمین
                                </a>

                                <a href="{{ route('admin.roles.index') }}"
                                    class="block text-sm px-4 py-2 rounded {{ request()->routeIs('admin.roles.index') ? 'bg-primary-50 dark:bg-primary-900/30 text-primary-600 dark:text-primary-400 active' : 'text-gray-900 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline me-1"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
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
                                onclick="toggleMenu('subjects-menu-mobile', 'subjects-arrow-icon-mobile')">
                                <span class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline me-2"
                                        fill="none" viewBox="0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M7 8h10M7 12h6m-8 8h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    مدیریت درس ها
                                </span>
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="h-4 w-4 transition-transform duration-300 {{ request()->routeIs('admin.subjects.*') ? 'rotate-180' : '' }}"
                                    id="subjects-arrow-icon-mobile" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>

                            <div id="subjects-menu-mobile"
                                class="{{ request()->routeIs('admin.subjects.*') ? '' : 'hidden' }} me-6 space-y-1">
                                <a href="{{ route('admin.subjects.index') }}"
                                    class="block text-sm px-4 py-2 rounded {{ request()->routeIs('admin.subjects.index') ? 'bg-primary-50 dark:bg-primary-900/30 text-primary-600 dark:text-primary-400 active' : 'text-gray-900 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline me-1"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2" />
                                    </svg>
                                    لیست درس ها
                                </a>

                                <a href="{{ route('admin.subjects.create') }}"
                                    class="block text-sm px-4 py-2 rounded {{ request()->routeIs('admin.subjects.create') ? 'bg-primary-50 dark:bg-primary-900/30 text-primary-600 dark:text-primary-400 active' : 'text-gray-900 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline me-1"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
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
                                onclick="toggleMenu('questions-menu-mobile', 'questions-arrow-icon-mobile')">
                                <span class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline me-2"
                                        fill="none" viewBox="0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M7 8h10M7 12h6m-8 8h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    مدیریت سوالات
                                </span>
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="h-4 w-4 transition-transform duration-300 {{ request()->routeIs('admin.questions.*') ? 'rotate-180' : '' }}"
                                    id="questions-arrow-icon-mobile" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>

                            <div id="questions-menu-mobile"
                                class="{{ request()->routeIs('admin.questions.*') ? '' : 'hidden' }} me-6 space-y-1">
                                <a href="{{ route('admin.questions.index') }}"
                                    class="block text-sm px-4 py-2 rounded {{ request()->routeIs('admin.questions.index') ? 'bg-primary-50 dark:bg-primary-900/30 text-primary-600 dark:text-primary-400 active' : 'text-gray-900 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline me-1"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2" />
                                    </svg>
                                    لیست سوالات
                                </a>

                                <a href="{{ route('admin.questions.create') }}"
                                    class="block text-sm px-4 py-2 rounded {{ request()->routeIs('admin.questions.create') ? 'bg-primary-50 dark:bg-primary-900/30 text-primary-600 dark:text-primary-400 active' : 'text-gray-900 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline me-1"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
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
                                onclick="toggleMenu('exams-menu-mobile', 'exams-arrow-icon-mobile')">
                                <span class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline me-2"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M7 8h10M7 12h6m-8 8h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    مدیریت آزمون ها
                                </span>
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="h-4 w-4 transition-transform duration-300 {{ request()->routeIs('admin.exams.*') ? 'rotate-180' : '' }}"
                                    id="exams-arrow-icon-mobile" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>

                            <div id="exams-menu-mobile"
                                class="{{ request()->routeIs('admin.exams.*') ? '' : 'hidden' }} me-6 space-y-1">
                                <a href="{{ route('admin.exams.index') }}"
                                    class="block text-sm px-4 py-2 rounded {{ request()->routeIs('admin.exams.index') ? 'bg-primary-50 dark:bg-primary-900/30 text-primary-600 dark:text-primary-400 active' : 'text-gray-900 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline me-1"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2" />
                                    </svg>
                                    لیست آزمون ها
                                </a>

                                <a href="{{ route('admin.exams.create') }}"
                                    class="block text-sm px-4 py-2 rounded {{ request()->routeIs('admin.exams.create') ? 'bg-primary-50 dark:bg-primary-900/30 text-primary-600 dark:text-primary-400 active' : 'text-gray-900 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline me-1"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
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
                                <p class="text-sm font-medium text-gray-900 dark:text-white">مدیر سیستم</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">دسترسی: مدیرکل</p>
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
                            خروج از حساب
                        </button>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <!-- Overlay -->
    <div class="overlay transition fixed inset-0 z-40 bg-black/70 hidden" onclick="closeOffcanvas()"
        role="presentation" aria-hidden="true"></div>

    <!-- /canvas responsive menu -->

    <!-- start canvas notification -->

    <div id="offcanvas-notification-left"
        class="offcanvas invisible dark:bg-background-dark dark:text-white fixed top-0 end-0 sm:w-100 w-[80%] h-full bg-white shadow-lg transform -translate-x-full transition-transform opacity-0 z-50"
        role="dialog" aria-labelledby="cart-title" aria-modal="true">
        <!-- Header -->
        <header class="border-b p-3 flex items-center justify-between border-gray-400">
            <h2 class="font-bold text-base">@lang('general.Your notifications')</h2>
            <button onclick="closeOffcanvas()" class="cursor-pointer" aria-label="بستن ">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                </svg>
            </button>
        </header>
        <!-- notification Items -->
        <main class="relative space-y-4 divide-y divide-gray-200 p-3 overflow-y-scroll h-full">
            <!-- گروه اعلان‌ها -->
            <div class="space-y-3">
                <!-- notification 1 -->
                <div class="bg-white dark:bg-card-dark rounded-lg shadow-md overflow-hidden border border-gray-300">
                    <div class="p-3 flex items-start">
                        <div class="flex-shrink-0 bg-primary-100 p-1 rounded-full">
                            <svg class="h-5 w-5 text-primary-600" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z" />
                            </svg>
                        </div>
                        <div class="ms-3 flex-1">
                            <p class="text-sm font-bold text-gray-900 dark:text-white">یادآوری قرارملاقات</p>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-300">جلسه امروز ساعت 14:30 در اتاق
                                کنفرانس</p>
                        </div>
                        <button class="me-2 text-gray-400 hover:text-gray-500">
                            <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- notification 2 -->
                <div class="bg-white dark:bg-card-dark rounded-lg shadow-md overflow-hidden border border-gray-300">
                    <div class="p-3 flex items-start">
                        <div class="flex-shrink-0 bg-green-100 p-1 rounded-full">
                            <svg class="h-5 w-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="ms-3 flex-1">
                            <p class="text-sm font-bold text-gray-900 dark:text-white">پرداخت موفق</p>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-300">تراکنش شما با موفقیت انجام شد. کد
                                رهگیری: 458712</p>
                        </div>
                        <button class="me-2 text-gray-400 hover:text-gray-500">
                            <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <!-- Overlay -->
    <div class="overlay transition fixed inset-0 z-40 bg-black/70 hidden" onclick="closeOffcanvas()"
        role="presentation" aria-hidden="true"></div>

    <!-- /canvas notification -->

    @stack('scripts')

</body>

</html>
