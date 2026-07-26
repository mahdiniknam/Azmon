@extends('student.layout.master')

@section('student-title')
    کیف پول من
@endsection

@section('student-content')
    <main class="flex-1 overflow-y-auto p-6 bg-gray-50 dark:bg-gray-900">
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">کیف پول من</h2>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Wallet Card -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl shadow-lg p-6 text-black relative overflow-hidden border border-gray-100">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-primary/10 rounded-full -mr-10 -mt-10"></div>
                    <div class="absolute bottom-0 left-0 w-24 h-24 bg-blue-500/10 rounded-full -ml-8 -mb-8"></div>

                    <div class="relative z-10">
                        <div class="flex items-center justify-between mb-8">
                            <span class="text-gray-700 font-medium">موجودی فعلی</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-primary" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                            </svg>
                        </div>

                        <div class="mb-6">
                            <span class="text-3xl font-bold tracking-wider text-black">
                                {{ number_format($user->wallet_balance ?? 0) }}
                            </span>
                            <span class="text-gray-600 mr-1">تومان</span>
                        </div>

                        <div class="flex items-center justify-between text-sm text-gray-600">
                            <span>کاربر: {{ $user->name }}</span>
                            <span>{{ jdate()->format('Y/m/d') }}</span>
                        </div>
                    </div>
                </div>


                <div
                    class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 mt-6 border border-gray-200 dark:border-gray-700">
                    <h3 class="font-bold text-lg mb-4">افزایش موجودی</h3>

                    @if (session('error'))
                        <div class="mb-3 rounded-lg bg-red-100 p-3 text-sm text-red-700">{{ session('error') }}</div>
                    @endif
                    @if (session('success'))
                        <div class="mb-3 rounded-lg bg-green-100 p-3 text-sm text-green-700">{{ session('success') }}</div>
                    @endif

                    <form action="{{ route('student.payments.wallet.charge') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-sm text-gray-700 dark:text-gray-300 mb-2">مبلغ مورد نظر (تومان)</label>
                            <input type="number" name="amount" min="1000" step="1000" required
                                value="{{ old('amount') }}"
                                class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-lg shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50"
                                placeholder="مثال: 50000">
                            @error('amount')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                        <button type="submit"
                            class="w-full bg-green-600 hover:bg-green-700 text-white py-2 rounded-lg font-medium transition">
                            پرداخت و شارژ (زرین‌پال)
                        </button>
                    </form>
                </div>
            </div>

            <!-- Recent Transactions -->
            <div class="lg:col-span-2">
                <div
                    class="bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden border border-gray-200 dark:border-gray-700">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
                        <h3 class="font-bold text-lg">تراکنش‌های اخیر</h3>
                        <a href="{{ route('student.payments.index') }}" class="text-sm text-primary hover:underline">مشاهده
                            همه</a>
                    </div>

                    <div class="p-6">
                        @if ($recentTransactions->count() > 0)
                            <div class="space-y-4">
                                @foreach ($recentTransactions as $transaction)
                                    <div
                                        class="flex items-center justify-between p-4 rounded-lg border border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50">
                                        <div class="flex items-center gap-4">
                                            @if ($transaction->type === 'deposit')
                                                <div class="bg-green-100 text-green-600 p-3 rounded-full">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                                        viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                                                    </svg>
                                                </div>
                                            @else
                                                <div class="bg-red-100 text-red-600 p-3 rounded-full">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                                        viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                                                    </svg>
                                                </div>
                                            @endif
                                            <div>
                                                <p class="font-medium text-gray-900 dark:text-white">
                                                    {{ $transaction->type === 'deposit' ? 'افزایش موجودی / پرداخت' : 'کسر از کیف پول' }}
                                                </p>
                                                <p class="text-sm text-gray-500" dir="ltr">
                                                    {{ jdate($transaction->created_at)->format('Y/m/d H:i') }}</p>
                                            </div>
                                        </div>
                                        <div class="text-left">
                                            <p class="font-bold {{ $transaction->type === 'deposit' ? 'text-green-600' : 'text-red-600' }}"
                                                dir="ltr">
                                                {{ $transaction->type === 'deposit' ? '+' : '-' }}
                                                {{ number_format($transaction->amount) }}
                                            </p>
                                            <p class="text-xs text-gray-500 mt-1">
                                                @if ($transaction->status)
                                                    <span class="text-green-500">موفق</span>
                                                @else
                                                    <span class="text-red-500">ناموفق</span>
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400 mb-4"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <p class="text-gray-500">هیچ تراکنشی یافت نشد.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
