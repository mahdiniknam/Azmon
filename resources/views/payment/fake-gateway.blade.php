<!doctype html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0">
    <title>درگاه پرداخت آزمایشی</title>
    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">
    <link rel="preload" href="{{ asset('assets/fonts/payda/PeydaWebFaNum-Medium.woff2') }}" as="font" type="font/woff2" crossorigin>
</head>
<body class="bg-gray-100 font-sans min-h-screen flex items-center justify-center p-4">

    <div class="bg-white rounded-2xl shadow-2xl max-w-lg w-full overflow-hidden border border-gray-200 relative">
        <!-- Top bar pattern -->
        <div class="bg-blue-600 h-2 w-full"></div>
        
        <div class="p-8 text-center">
            <img src="{{ asset('assets/images/bank-logo.png') }}" alt="Bank Logo" class="h-16 mx-auto mb-4 bg-gray-200 rounded-full w-16" onerror="this.src='data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAyNCAyNCIgZmlsbD0ibm9uZSIgc3Ryb2tlPSIjM2I4MmY2IiBzdHJva2Utd2lkdGg9IjIiPjxwYXRoIHN0cm9rZS1saW5lY2FwPSJyb3VuZCIgc3Ryb2tlLWxpbmVqb2luPSJyb3VuZCIgZD0iTTEyIDF2MjJtLTEwLThoMjBtLTEwLTEwSDFtMjAgMGgtOSIgLz48L3N2Zz4='">
            
            <h2 class="text-2xl font-bold text-gray-800 mb-6">درگاه پرداخت الکترونیک سپهر (آزمایشی)</h2>
            
            <div class="bg-gray-50 rounded-xl p-5 mb-8 text-right border border-gray-200 space-y-3">
                <div class="flex justify-between border-b border-gray-200 pb-2">
                    <span class="text-gray-500">پذیرنده:</span>
                    <span class="font-medium">سامانه آزمون‌ساز آنلاین</span>
                </div>
                <div class="flex justify-between border-b border-gray-200 pb-2">
                    <span class="text-gray-500">شماره پیگیری تراکنش:</span>
                    <span class="font-mono text-gray-700 tracking-wider">{{ $transaction->tracking_code }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">مبلغ پرداخت:</span>
                    <span class="font-bold text-xl text-blue-600">{{ number_format($transaction->amount) }} <span class="text-sm font-normal text-gray-500">تومان</span></span>
                </div>
            </div>
            
            <p class="text-sm text-yellow-600 mb-8 bg-yellow-50 p-3 rounded-lg border border-yellow-200">این یک درگاه پرداخت شبیه‌ساز است و هیچ پولی از حساب شما کسر نمی‌شود.</p>
            
            <div class="grid grid-cols-2 gap-4">
                <form action="{{ route('payment.callback', $transaction) }}" method="POST">
                    @csrf
                    <input type="hidden" name="success" value="0">
                    <button type="submit" class="w-full bg-red-500 hover:bg-red-600 text-white py-3 rounded-lg font-medium transition-colors">
                        انصراف / پرداخت ناموفق
                    </button>
                </form>
                
                <form action="{{ route('payment.callback', $transaction) }}" method="POST">
                    @csrf
                    <input type="hidden" name="success" value="1">
                    <button type="submit" class="w-full bg-green-500 hover:bg-green-600 text-white py-3 rounded-lg font-medium transition-colors">
                        تکمیل خرید / موفق
                    </button>
                </form>
            </div>
        </div>
    </div>

</body>
</html>
