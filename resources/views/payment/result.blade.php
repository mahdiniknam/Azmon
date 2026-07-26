<!doctype html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0">
    <title>نتیجه تراکنش</title>
    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">
    <link rel="preload" href="{{ asset('assets/fonts/payda/PeydaWebFaNum-Medium.woff2') }}" as="font" type="font/woff2" crossorigin>
</head>
<body class="bg-gray-100 font-sans min-h-screen flex items-center justify-center p-4">

    <div class="bg-white rounded-2xl shadow-xl max-w-md w-full overflow-hidden border border-gray-200">
        
        @if($transaction->status)
            <div class="bg-green-500 text-white text-center py-8 px-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <h2 class="text-2xl font-bold">پرداخت با موفقیت انجام شد</h2>
            </div>
        @else
            <div class="bg-red-500 text-white text-center py-8 px-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <h2 class="text-2xl font-bold">پرداخت ناموفق بود</h2>
            </div>
        @endif
        
        <div class="p-6">
            <div class="space-y-4 mb-8">
                <div class="flex justify-between items-center border-b border-gray-100 pb-3">
                    <span class="text-gray-500">کد پیگیری:</span>
                    <span class="font-mono text-gray-800 font-medium">{{ $transaction->tracking_code }}</span>
                </div>
                <div class="flex justify-between items-center border-b border-gray-100 pb-3">
                    <span class="text-gray-500">مبلغ پرداخت:</span>
                    <span class="text-gray-800 font-medium">{{ number_format($transaction->amount) }} تومان</span>
                </div>
                <div class="flex justify-between items-center border-b border-gray-100 pb-3">
                    <span class="text-gray-500">تاریخ و زمان:</span>
                    <span class="text-gray-800 font-medium" dir="ltr">{{ jdate($transaction->updated_at)->format('Y/m/d H:i') }}</span>
                </div>
            </div>
            
            <div class="text-center">
                @if($transaction->exam_id)
                    <a href="{{ route('student.exams.show', $transaction->exam_id) }}" class="inline-block w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-lg font-medium transition-colors">
                        بازگشت به آزمون
                    </a>
                @else
                    <a href="{{ route('student.payments.wallet') }}" class="inline-block w-full bg-gray-600 hover:bg-gray-700 text-white py-3 rounded-lg font-medium transition-colors">
                        بازگشت به کیف پول
                    </a>
                @endif
            </div>
        </div>
    </div>

</body>
</html>
