@extends('admin.layout.master')

@section('admin-title')
    گزارشات مالی
@endsection

@section('admin-content')
    <main class="flex-1 overflow-y-auto p-6 bg-gray-50 dark:bg-gray-900">
        <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">گزارشات مالی</h2>
                <p class="text-gray-600 dark:text-gray-400">تاریخچه تراکنش‌های سیستم</p>
            </div>
            
            <div class="mt-4 md:mt-0 bg-white dark:bg-gray-800 p-4 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
                <span class="text-gray-500 dark:text-gray-400">مجموع درآمد سیستم:</span>
                <span class="font-bold text-xl text-green-600 ml-2">{{ number_format($totalIncome) }} تومان</span>
            </div>
        </div>

        <div class="bg-white py-6 space-y-4 dark:bg-gray-800 rounded-xl shadow-md overflow-hidden border border-gray-200 dark:border-gray-700">
            <div class="px-6 pb-4 border-b border-gray-200 dark:border-gray-700">
                <form action="{{ route('admin.reports.financial') }}" method="GET" class="flex gap-4 items-end">
                    <div>
                        <label class="block text-sm text-gray-700 dark:text-gray-300 mb-1">وضعیت تراکنش</label>
                        <select name="status" class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-lg shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                            <option value="">همه</option>
                            <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>موفق</option>
                            <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>ناموفق</option>
                        </select>
                    </div>
                    <button type="submit" class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-primary-600">فیلتر</button>
                    <a href="{{ route('admin.reports.financial') }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-300">حذف فیلتر</a>
                </form>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-start">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">شناسه</th>
                            <th class="px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">کاربر</th>
                            <th class="px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">مبلغ (تومان)</th>
                            <th class="px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">نوع تراکنش</th>
                            <th class="px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">کد پیگیری</th>
                            <th class="px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">وضعیت</th>
                            <th class="px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">تاریخ</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($transactions as $transaction)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $transaction->id }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $transaction->user->name ?? 'کاربر حذف شده' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap font-medium">{{ number_format($transaction->amount) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $transaction->type === 'deposit' ? 'واریز' : 'برداشت' }}
                                    @if($transaction->exam_id)
                                        <br><span class="text-xs text-blue-500">برای آزمون: {{ $transaction->exam->title ?? $transaction->exam_id }}</span>
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
                                <td colspan="7" class="px-6 py-8 text-center text-gray-500">هیچ تراکنشی یافت نشد.</td>
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
