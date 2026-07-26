<!doctype html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0">
    <title>صورتحساب و پرداخت</title>
    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">
    <link rel="preload" href="{{ asset('assets/fonts/payda/PeydaWebFaNum-Medium.woff2') }}" as="font" type="font/woff2" crossorigin>
</head>
<body class="bg-gray-100 dark:bg-gray-900 font-sans min-h-screen flex items-center justify-center p-4">

    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl max-w-md w-full overflow-hidden border border-gray-200 dark:border-gray-700">
        <div class="bg-primary text-white text-center py-6 px-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
            </svg>
            <h2 class="text-2xl font-bold">صورتحساب آزمون</h2>
        </div>

        <div class="p-6 space-y-6">
            <div class="space-y-3 pb-6 border-b border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-300">
                <div class="flex justify-between items-center">
                    <span>عنوان آزمون:</span>
                    <span class="font-medium text-gray-900 dark:text-white">{{ $exam->title }}</span>
                </div>
                <div class="flex justify-between items-center text-lg font-bold">
                    <span>مبلغ قابل پرداخت:</span>
                    <span class="text-primary">{{ number_format($amount) }} تومان</span>
                </div>
            </div>

            <div class="space-y-4">
                @if(session('error'))
                    <div class="bg-red-100 text-red-700 p-3 rounded-lg text-sm mb-4">
                        {{ session('error') }}
                    </div>
                @endif

                <div class="bg-gray-50 dark:bg-gray-700/50 p-4 rounded-xl border border-gray-200 dark:border-gray-600 flex justify-between items-center">
                    <span class="text-gray-600 dark:text-gray-300">موجودی کیف پول شما:</span>
                    <span class="font-bold text-gray-900 dark:text-white">{{ number_format($user->wallet_balance ?? 0) }} تومان</span>
                </div>

                <div class="grid grid-cols-1 gap-3 pt-2">
                    <form action="{{ route('payment.wallet-pay', $exam) }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-lg font-medium transition-colors {{ ($user->wallet_balance ?? 0) < $amount ? 'opacity-50 cursor-not-allowed' : '' }}" {{ ($user->wallet_balance ?? 0) < $amount ? 'disabled' : '' }}>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            پرداخت از کیف پول
                        </button>
                    </form>

                    <form action="{{ route('payment.pay', $exam) }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full flex items-center justify-center gap-2 bg-green-600 hover:bg-green-700 text-white py-3 rounded-lg font-medium transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                            </svg>
                            پرداخت آنلاین از درگاه
                        </button>
                    </form>
                </div>
            </div>

            <div class="text-center pt-2">
                <a href="{{ route('student.exams.show', $exam) }}" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 text-sm underline">انصراف و بازگشت</a>
            </div>
        </div>
    </div>

</body>
</html>
