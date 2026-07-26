<!doctype html>
<html lang="fa"
    dir="{{ app()->getLocale()=='fa' ? 'rtl' : 'ltr' }}">
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
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/images/favicon_io/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/images/favicon_io/favicon-16x16.png') }}">
    <link rel="canonical" href="https://example.com/admin-panel">
    <link rel="stylesheet" href="{{ asset('assets/js/plugin/swiper/swiper-bundle.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/select2.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/datePicker.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">
    <link rel="preload" href="{{ asset('assets/fonts/payda/PeydaWebFaNum-Medium.woff2') }}" as="font" type="font/woff2" crossorigin>
    
</head>

<body class="bg-light dark:bg-background-dark text-text-primary-light dark:text-text-primary-dark transition-colors duration-200">
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
        role="dialog"
        aria-labelledby="cart-title"
        aria-modal="true">
        <!-- Header -->
        <header class="border-b p-3 flex items-center justify-between border-gray-400">
            <h2 id="cart-title" class="font-bold text-base">@lang('general.Your messages')</h2>
            <button
                onclick="closeOffcanvas()"
                class="cursor-pointer"
                aria-label="بستن ">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                </svg>
            </button>
        </header>
        <!-- message Items -->
        <main class="relative space-y-4 divide-y divide-gray-200 p-3 overflow-y-scroll h-full">
            <!-- message one -->
            <div class="bg-white last:mb-20 border border-gray-400 rounded-2xl shadow-md dark:bg-card-dark dark:text-white overflow-hidden p-5 space-y-3">
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
            </div>
            <!-- message two -->
            <div class="bg-white last:mb-20 border border-gray-400 rounded-2xl shadow-md dark:bg-card-dark dark:text-white overflow-hidden p-5 space-y-3">
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
            </div>
        </main>
    </div>
    <!-- Overlay -->
    <div class="overlay transition fixed inset-0 z-40 bg-black/70 hidden"
        onclick="closeOffcanvas()"
        role="presentation"
        aria-hidden="true"></div>

    <!-- /canvas message -->

    <!-- start canvas language -->
    <div id="offcanvas-language-left"
        class="offcanvas invisible dark:bg-background-dark dark:text-white fixed top-0 end-0 sm:w-100 w-[80%] h-full bg-white shadow-lg transform -translate-x-full transition-transform opacity-0 z-50"
        role="dialog"
        aria-labelledby="language-title"
        aria-modal="true">

        <!-- Header -->
        <header class="border-b p-3 flex items-center justify-between border-gray-400">
            <h2 id="language-title" class="font-bold text-base">
                @lang('general.Language')
            </h2>
            <button onclick="closeOffcanvas()" class="cursor-pointer" aria-label="بستن">
                <svg xmlns="http://www.w3.org/2000/svg" class="size-8" fill="none" viewBox="0 0 24 24"
                    stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M6 18 18 6M6 6l12 12" />
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

            @foreach($languages as $key => $label)
            <a href="{{ url('lang/'.$key) }}"
                class="flex items-center justify-between p-4 border border-gray-300 rounded-xl shadow-sm
                      hover:bg-gray-100 dark:hover:bg-gray-700
                      dark:bg-card-dark dark:border-gray-600">

                <span class="text-sm font-medium">
                    {{ $label }}
                </span>

                @if(app()->getLocale() === $key)
                <span class="px-2 py-0.5 rounded-full text-xs font-medium bg-primary-grad text-white">
                    @lang('general.Active')
                </span>
                @endif
            </a>
            @endforeach

        </main>
    </div>
    <!-- Overlay -->
    <div class="overlay transition fixed inset-0 z-40 bg-black/70 hidden"
        onclick="closeOffcanvas()"
        role="presentation"
        aria-hidden="true"></div>
    <!-- /canvas language -->


    <!-- start canvas responsive menu -->

    <div id="offcanvas-responsive-menu-right"
        class="offcanvas invisible dark:bg-background-dark dark:text-white fixed top-0 start-0 sm:w-100 w-[80%] h-full bg-white shadow-lg transform -translate-x-full transition-transform opacity-0 z-50"
        role="dialog"
        aria-labelledby="cart-title"
        aria-modal="true">
        <!-- Header -->
        <header class="border-b p-3 flex items-center justify-between border-gray-400">
            <h2 class="font-bold text-base">پنل ادمین</h2>
            <button
                onclick="closeOffcanvas()"
                class="cursor-pointer"
                aria-label="بستن ">
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
                        <h1 class="ms-3 text-xl font-bold text-dark dark:text-light">پنل <span class="text-primary">مدیریت </span>
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
                                onclick="toggleMenu('users-menu-admin', 'users-arrow-icon-admin')">
                                <span class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline me-2" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                    </svg>
                                    مدیریت کاربران
                                </span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform duration-300"
                                    id="users-arrow-icon-admin" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            <div id="users-menu-admin" class="hidden me-6 space-y-1">
                                <a href="{{ route('admin.users.index') }}"
                                    class="block text-sm px-4 py-2 text-gray-900 rounded hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline me-1" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                    لیست کاربران
                                </a>
                                <a href="{{ route('admin.users.create') }}"
                                    class="block text-sm px-4 py-2 text-gray-900 rounded hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline me-1" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                    </svg>
                                    افزودن کاربر
                                </a>
                                <a href="admin-panel-user-roles.html"
                                    class="block text-sm px-4 py-2 text-gray-900 rounded hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline me-1" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                    </svg>
                                    نقش‌های کاربری
                                </a>
                            </div>
                        </div>

                        <!-- Products Management -->
                        <div class="space-y-1">
                            <button type="button"
                                class="w-full flex items-center justify-between px-4 py-3 text-sm font-medium text-gray-900 rounded-lg hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700"
                                onclick="toggleMenu('products-menu-admin', 'products-arrow-icon-admin')">
                                <span class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline me-2" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                    </svg>
                                    مدیریت محصولات
                                </span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform duration-300"
                                    id="products-arrow-icon-admin" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            <div id="products-menu-admin" class="hidden me-6 space-y-1">
                                <a href="admin-panel-products-list.html"
                                    class="block text-sm px-4 py-2 text-gray-900 rounded hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline me-1" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                                    </svg>
                                    لیست محصولات
                                </a>
                                <a href="admin-panel-add-product.html"
                                    class="block text-sm px-4 py-2 text-gray-900 rounded hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline me-1" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                    </svg>
                                    افزودن محصول
                                </a>
                                <a href="admin-panel-categories.html"
                                    class="block text-sm px-4 py-2 text-gray-900 rounded hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline me-1" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z" />
                                    </svg>
                                    دسته‌بندی‌ها
                                </a>
                                <a href="admin-panel-attributes.html"
                                    class="block text-sm px-4 py-2 text-gray-900 rounded hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline me-1" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                    </svg>
                                    ویژگی‌ها
                                </a>
                                <a href="admin-panel-product-reviews.html"
                                    class="block text-sm px-4 py-2 text-gray-900 rounded hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline me-1" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                    </svg>
                                    نظرات محصولات
                                </a>
                            </div>
                        </div>

                        <!-- Orders Management -->
                        <div class="space-y-1">
                            <button type="button"
                                class="w-full flex items-center justify-between px-4 py-3 text-sm font-medium text-gray-900 rounded-lg hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700"
                                onclick="toggleMenu('orders-menu-admin', 'orders-arrow-icon-admin')">
                                <span class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline me-2" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                    </svg>
                                    مدیریت سفارشات
                                </span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform duration-300"
                                    id="orders-arrow-icon-admin" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            <div id="orders-menu-admin" class="hidden me-6 space-y-1">
                                <a href="admin-panel-orders-list.html"
                                    class="block text-sm px-4 py-2 text-gray-900 rounded hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline me-1" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                    لیست سفارشات
                                </a>
                                <a href="admin-panel-order-details.html"
                                    class="block text-sm px-4 py-2 text-gray-900 rounded hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline me-1" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    جزئیات سفارش
                                </a>
                                <a href="admin-panel-order-status.html"
                                    class="block text-sm px-4 py-2 text-gray-900 rounded hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline me-1" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    وضعیت سفارشات
                                </a>
                            </div>
                        </div>

                        <!-- Discounts -->
                        <a href="admin-panel-discounts.html"
                            class="block px-4 py-3 text-sm font-medium text-gray-900 rounded-lg hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline me-2" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            تخفیف‌ها و کوپن‌ها
                        </a>

                        <!-- Transactions -->
                        <a href="admin-panel-transactions.html"
                            class="block px-4 py-3 text-sm font-medium text-gray-900 rounded-lg hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline me-2" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            تراکنش‌ها
                        </a>

                        <!-- Reports -->
                        <div class="space-y-1">
                            <button type="button"
                                class="w-full flex items-center justify-between px-4 py-3 text-sm font-medium text-gray-900 rounded-lg hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700"
                                onclick="toggleMenu('reports-menu-admin', 'reports-arrow-icon-admin')">
                                <span class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline me-2" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    گزارشات
                                </span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform duration-300"
                                    id="reports-arrow-icon-admin" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            <div id="reports-menu-admin" class="hidden me-6 space-y-1">
                                <a href="admin-panel-sales-report.html"
                                    class="block text-sm px-4 py-2 text-gray-900 rounded hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline me-1" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                    </svg>
                                    گزارش فروش
                                </a>
                                <a href="admin-panel-customer-report.html"
                                    class="block text-sm px-4 py-2 text-gray-900 rounded hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline me-1" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                    </svg>
                                    گزارش مشتریان
                                </a>
                                <a href="admin-panel-product-report.html"
                                    class="block text-sm px-4 py-2 text-gray-900 rounded hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline me-1" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                    </svg>
                                    گزارش محصولات
                                </a>
                            </div>
                        </div>

                        <!-- Settings -->
                        <a href="admin-panel-settings.html"
                            class="block px-4 py-3 text-sm font-medium text-gray-900 rounded-lg hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline me-2" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            تنظیمات سیستم
                        </a>

                        <!-- Backup -->
                        <a href="admin-panel-backup.html"
                            class="block px-4 py-3 text-sm font-medium text-gray-900 rounded-lg hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline me-2" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19.21 12.04l-1.53-.11-.3-1.5A5.484 5.484 0 0012 6C9.94 6 8.08 7.14 7.12 8.96l-.5.95-1.07.11A3.99 3.99 0 002 13c0 2.21 1.79 4 4 4h13c1.65 0 3-1.35 3-3 0-1.55-1.22-2.86-2.79-2.96z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 12v9m0-9l-3 3m3-3l3 3" />
                            </svg>
                            پشتیبان‌گیری
                        </a>

                        <!-- Logs -->
                        <a href="admin-panel-logs.html"
                            class="block px-4 py-3 text-sm font-medium text-gray-900 rounded-lg hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline me-2" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            لاگ‌های سیستم
                        </a>
                    </nav>

                    <!-- Admin Info -->
                    <div class="mt-auto p-4 bg-gray-50 dark:bg-gray-900 rounded-xl">
                        <div class="flex items-center">
                            <div class="relative">
                                <img class="h-12 w-12 rounded-full border-2 border-white dark:border-gray-800 shadow"
                                    src="assets/images/user/user.png" alt="Admin avatar">
                                <span class="absolute bottom-0 start-0 w-3 h-3 rounded-full bg-green-500 dark:bg-green-400 border-2 border-white dark:border-gray-800"></span>
                            </div>
                            <div class="ms-3">
                                <p class="text-sm font-medium text-gray-900 dark:text-white">مدیر سیستم</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">دسترسی: مدیرکل</p>
                            </div>
                        </div>
                        <button class="mt-4 w-full flex items-center justify-center px-4 py-2 text-sm text-gray-600 dark:text-gray-300 bg-white dark:bg-gray-700 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600 border border-gray-200 dark:border-gray-600">
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
    <div class="overlay transition fixed inset-0 z-40 bg-black/70 hidden"
        onclick="closeOffcanvas()"
        role="presentation"
        aria-hidden="true"></div>

    <!-- /canvas responsive menu -->

    <!-- start canvas notification -->

    <div id="offcanvas-notification-left"
        class="offcanvas invisible dark:bg-background-dark dark:text-white fixed top-0 end-0 sm:w-100 w-[80%] h-full bg-white shadow-lg transform -translate-x-full transition-transform opacity-0 z-50"
        role="dialog"
        aria-labelledby="cart-title"
        aria-modal="true">
        <!-- Header -->
        <header class="border-b p-3 flex items-center justify-between border-gray-400">
            <h2 class="font-bold text-base">@lang('general.Your notifications')</h2>
            <button
                onclick="closeOffcanvas()"
                class="cursor-pointer"
                aria-label="بستن ">
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
                                <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z" />
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
    <div class="overlay transition fixed inset-0 z-40 bg-black/70 hidden"
        onclick="closeOffcanvas()"
        role="presentation"
        aria-hidden="true"></div>

    <!-- /canvas notification -->

    @stack('scripts')

</body>

</html>
