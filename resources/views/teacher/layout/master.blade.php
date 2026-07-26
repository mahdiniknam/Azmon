<!doctype html>
<html lang="fa" dir="{{ app()->getLocale()=='fa' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('teacher-title')</title>
    <meta name="description" content="پنل استاد آزمون ساز آنلاین">
    <link rel="stylesheet" href="{{ asset('assets/css/select2.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/datePicker.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">
    <link rel="preload" href="{{ asset('assets/fonts/payda/PeydaWebFaNum-Medium.woff2') }}" as="font" type="font/woff2" crossorigin>
</head>
<body class="bg-light dark:bg-background-dark text-text-primary-light dark:text-text-primary-dark transition-colors duration-200">
    <div class="flex h-screen overflow-hidden max-w-[1920px] mx-auto">
        <!-- sidebar -->
        @include('teacher.partial.sidebar')
        <!-- main content -->
        <div class="flex flex-col flex-1 overflow-hidden">
            <!-- header -->
            @include('teacher.partial.header')
            <!-- component alert -->
            @include('components.alerts')
            <!-- page content -->
            @yield('teacher-content')
        </div>
    </div>
    
    <script src="{{ asset('assets/js/plugin/jquery/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugin/jalalidatepicker/jalalidatepicker.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugin/select2/select2.min.js') }}"></script>
    @yield('scripts')
</body>
</html>
