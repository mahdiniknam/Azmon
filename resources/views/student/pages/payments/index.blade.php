@extends('student.layout.master')

@section('student-title')
    تاریخچه پرداخت‌ها
@endsection

@section('student-content')
    <main class="flex-1 overflow-y-auto p-6 bg-gray-50 dark:bg-gray-900">
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">تاریخچه پرداخت‌ها</h2>
            <p class="text-gray-600 dark:text-gray-400 mt-1">لیست تمامی تراکنش‌های مالی شما</p>
        </div>

        <div class="bg-white py-6 space-y-4 dark:bg-gray-800 rounded-xl shadow-md overflow-hidden border border-gray-200 dark:border-gray-700">
            <div class="overflow-x-auto">
                <table class="w-full text-start">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">شناسه تراکنش</th>
                            <th class="px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">مبلغ (تومان)</th>
                            <th class="px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">بابت</th>
                            <th class="px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">کد پیگیری</th>
                            <th class="px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">وضعیت</th>
                            <th class="px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">تاریخ</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($transactions as $transaction)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $transaction->id }}</td>
                                <td class="px-6 py-4 whitespace-nowrap font-medium text-primary">{{ number_format($transaction->amount) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                                    {{ $transaction->type === 'deposit' ? 'واریز به حساب / درگاه' : 'پرداخت از کیف پول' }}
                                    @if($transaction->exam)
                                        <br><span class="text-xs text-gray-500 block mt-1">آزمون: {{ $transaction->exam->title }}</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-mono">{{ $transaction->tracking_code }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($transaction->status)
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">موفق</span>
                                    @else
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">ناموفق</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm" dir="ltr">
                                    {{ jdate($transaction->created_at)->format('Y/m/d H:i') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-8 text-center text-gray-500">تا کنون تراکنشی نداشته‌اید.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="px-6 pt-4 border-t border-gray-200 dark:border-gray-700">
                {{ $transactions->links() }}
            </div>
        </div>
    </main>
@endsection
