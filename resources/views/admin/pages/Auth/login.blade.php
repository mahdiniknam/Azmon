<!doctype html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale()=='fa' ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@lang('general.Arya Gostaran Management Panel')</title>
    <meta name="description" content="@lang('general.arino_template_description')">
    <meta name="keywords" content="@lang('general.arino_template_keywords')">
    <meta name="robots" content="index, follow">
    <meta name="author" content="@lang('general.arino_author')">
    <meta name="copyright" content="@lang('general.arino_copyright')">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/images/favicon_io/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/images/favicon_io/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/images/favicon_io/favicon-16x16.png') }}">
    <link rel="canonical" href="https://example.com/your-page-url">
    <link rel="stylesheet" href="{{ asset('assets/js/plugin/swiper/swiper-bundle.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">
    <link rel="preload" href="{{ asset('assets/fonts/payda/PeydaWebFaNum-Medium.woff2') }}" as="font" type="font/woff2" crossorigin>
</head>

<body class="bg-light dark:bg-zinc-900 text-text-primary-light dark:text-text-primary-dark transition-colors duration-200">

    <div class="min-h-screen flex flex-col lg:flex-row">
        <!-- Image section -->
        <div class="lg:w-1/2 auth-bg relative hidden lg:flex items-center justify-center p-12">
            <div class="absolute inset-0 bg-black/30 dark:bg-black/50"></div>
            <div class="relative z-10 text-white text-center max-w-md">
                <div class="w-20 h-20 rounded-xl bg-primary-grad flex items-center justify-center mx-auto mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                </div>

                <h2 class="text-3xl font-bold mb-4">@lang('general.welcome_to_site')</h2>
                <p class="text-lg mb-6">@lang('general.welcome_desc')</p>
            </div>
        </div>

        <!-- Login form section -->
        <div class="lg:w-1/2 flex items-center justify-center p-6">
            <div class="w-full max-w-md">
                <!-- Mobile logo -->
                <div class="flex items-center justify-center mb-8 lg:hidden">
                    <div class="w-12 h-12 rounded-md bg-primary-grad flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                    </div>
                    <h1 class="ms-3 text-xl font-bold text-dark dark:text-light">
                        @lang('general.arino_template_short')
                        <span class="text-primary"> @lang('general.arino_brand') </span>
                    </h1>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-soft dark:shadow-soft-dark p-8 border border-gray-100 dark:border-gray-700 fade-in">
                    <div class="text-center mb-8">
                        <h2 class="text-2xl font-bold text-dark dark:text-light mb-2">@lang('general.login_to_account')</h2>
                        <p class="text-gray-500 dark:text-gray-400">@lang('general.choose_login_method')</p>
                    </div>

                    @php
                    $challenge = session('admin_login_challenge');
                    $inChallenge = !empty($challenge) && !empty($challenge['admin_id']);
                    $needsSms = $inChallenge && !empty($challenge['needs_sms']);
                    $needsTotp = $inChallenge && !empty($challenge['needs_totp']);
                    @endphp

                    <form class="space-y-5"
                        id="otp-form"
                        action="{{ $inChallenge ? route('admin.login.verify') : route('admin.login.post') }}"
                        method="post">
                        @csrf

                        {{-- مرحله ۱: یوزرنیم/پسورد/کپچا --}}
                        @if(!$inChallenge)
                        <div>
                            <label for="username" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                @lang('general.username_or_mobile')
                            </label>
                            <div class="relative">
                                <input name="userName" type="text" id="username"
                                    value="{{ old('userName') }}"
                                    class="w-full ps-12 ps-4 py-3 border rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                    placeholder="@lang('general.username_or_mobile_placeholder')" required>
                                <div class="absolute input-icon top-1/2 transform -translate-y-1/2 text-gray-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                            </div>
                            @error('userName')
                            <x-alert type="error" message="{{ $message }}"></x-alert>
                            @enderror
                        </div>

                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                @lang('general.password')
                            </label>
                            <div class="relative">
                                <input type="password" name="password" id="password"
                                    class="w-full ps-12 ps-4 py-3 border rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                    placeholder="@lang('general.password_placeholder')" required>

                                <button type="button"
                                    class="absolute password-toggle top-1/2 transform -translate-y-1/2 text-gray-400"
                                    onclick="togglePassword('password')">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </button>
                            </div>
                            @error('password')
                            <x-alert type="error" message="{{ $message }}"></x-alert>
                            @enderror
                        </div>

                        {{-- Captcha --}}
                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                @lang('general.enter_this_number')
                            </label>

                            <div class="flex items-center gap-3">
                                <img
                                    src="{{ $captcha->inline() }}"
                                    id="captcha-image"
                                    class="h-12 rounded-lg border cursor-pointer bg-white dark:bg-gray-700"
                                    alt="@lang('general.captcha_alt')"
                                    title="@lang('general.captcha_click_to_change')">

                                <input
                                    type="text"
                                    name="captcha"
                                    class="w-full py-3 px-4 border rounded-xl focus:outline-none focus:ring-2 focus:ring-primary
                                        dark:bg-gray-700 dark:border-gray-600 dark:text-white
                                        @error('captcha') border-red-500 focus:ring-red-500 @enderror"
                                    placeholder="@lang('general.enter_this_number')"
                                    required>
                            </div>

                            @error('captcha')
                            <x-alert type="error" message="{{ $message }}"></x-alert>
                            @enderror
                        </div>

                        <div class="flex items-center justify-between">
                            <div class="text-sm">
                                <a href="#" class="font-medium text-primary dark:text-primary-dark hover:underline">
                                    @lang('general.forgot_password')
                                </a>
                            </div>
                        </div>

                        <div>
                            <button type="submit"
                                class="w-full flex justify-center items-center py-3 px-4 border border-transparent rounded-xl shadow-sm text-sm font-medium text-white bg-primary dark:bg-primary-dark hover:bg-primary/90 dark:hover:bg-primary/80 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition-colors">
                                @lang('general.login')
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ms-2" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M3 3a1 1 0 011 1v12a1 1 0 11-2 0V4a1 1 0 011-1zm7.707 3.293a1 1 0 010 1.414L9.414 9H17a1 1 0 110 2H9.414l1.293 1.293a1 1 0 01-1.414 1.414l-3-3a1 1 0 010-1.414l3-3a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>

                        @else
                        {{-- مرحله ۲: OTP / 2FA --}}
                        <div class="rounded-xl border border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 p-4">
                            <p class="text-sm text-gray-700 dark:text-gray-300">
                                @lang('general.password_verified_enter_security_code')
                            </p>
                        </div>

                        @if($needsSms)
                        <div>
                            <label for="sms_otp" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                @lang('general.sms_code')
                            </label>
                            <div class="relative">
                                <input name="sms_otp" type="text" id="sms_otp"
                                    inputmode="numeric" maxlength="6"
                                    class="w-full ps-4 py-3 border rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                    placeholder="@lang('general.six_digits')" required>
                            </div>
                            @error('sms_otp')
                            <x-alert type="error" message="{{ $message }}"></x-alert>
                            @enderror
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">
                                @lang('general.sms_code_hint')
                            </p>
                        </div>
                        @endif

                        @if($needsTotp)
                        <div>
                            <label for="totp_otp" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                @lang('general.google_authenticator_code')
                            </label>
                            <div class="relative">
                                <input name="totp_otp" type="text" id="totp_otp"
                                    inputmode="numeric" maxlength="6"
                                    class="w-full ps-4 py-3 border rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                    placeholder="@lang('general.six_digits')" required>
                            </div>
                            @error('totp_otp')
                            <x-alert type="error" message="{{ $message }}"></x-alert>
                            @enderror
                        </div>
                        @endif

                        @error('general')
                        <x-alert type="error" message="{{ $message }}"></x-alert>
                        @enderror

                        <div class="flex gap-3">
                            <button type="submit"
                                class="w-full flex justify-center items-center py-3 px-4 border border-transparent rounded-xl shadow-sm text-sm font-medium text-white bg-primary dark:bg-primary-dark hover:bg-primary/90 dark:hover:bg-primary/80 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition-colors">
                                @lang('general.confirm_and_login')
                            </button>

                            <a href="{{ route('admin.login', ['reset_challenge' => 1]) }}"
                                class="w-full flex justify-center items-center py-3 px-4 rounded-xl shadow-sm text-sm font-medium border border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                @lang('general.back')
                            </a>
                        </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/js/dependencies/app.js') }}"></script>
    <script>
        const captchaImg = document.getElementById('captcha-image');
        if (captchaImg) {
            captchaImg.addEventListener('click', function() {
                fetch('{{ route("admin.captcha.refresh") }}')
                    .then(response => response.json())
                    .then(data => {
                        captchaImg.src = data.captcha;
                    });
            });
        }
    </script>

</body>

</html>