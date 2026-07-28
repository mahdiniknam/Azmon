@extends('admin.layout.master')

@section('admin-title')
    @lang('general.Arya Gostaran Management Panel')
@endsection

@section('admin-content')
   <main class="flex-1 overflow-y-auto p-6 bg-gray-50 dark:bg-gray-900">
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">خلاصه گزارشات سیستم</h2>
            <p class="text-gray-600 dark:text-gray-400">نمای کلی وضعیت مالی و آزمون‌ها</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-md border border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-gray-500 dark:text-gray-400 font-medium">مجموع درآمد</h3>
                    <span class="bg-green-100 text-green-800 p-2 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </span>
                </div>
                <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ number_format($totalIncome) }} <span class="text-sm font-normal text-gray-500">تومان</span></p>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-md border border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-gray-500 dark:text-gray-400 font-medium">تعداد کل آزمون‌ها</h3>
                    <span class="bg-blue-100 text-blue-800 p-2 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                        </svg>
                    </span>
                </div>
                <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ number_format($totalExams) }} <span class="text-sm font-normal text-gray-500">آزمون</span></p>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-md border border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-gray-500 dark:text-gray-400 font-medium">تراکنش‌های موفق</h3>
                    <span class="bg-purple-100 text-purple-800 p-2 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </span>
                </div>
                <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ number_format($successfulTransactions) }} <span class="text-sm font-normal text-gray-500">مورد</span></p>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-md border border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-gray-500 dark:text-gray-400 font-medium">تراکنش‌های ناموفق</h3>
                    <span class="bg-red-100 text-red-800 p-2 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </span>
                </div>
                <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ number_format($failedTransactions) }} <span class="text-sm font-normal text-gray-500">مورد</span></p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-md border border-gray-200 dark:border-gray-700">
                <h3 class="font-bold text-lg mb-4 border-b pb-2">دسترسی سریع</h3>
                <div class="space-y-3 mt-4">
                    <a href="{{ route('admin.reports.financial') }}" class="flex items-center p-3 bg-gray-50 dark:bg-gray-700 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600 transition">
                        <span class="bg-primary-100 text-primary-700 p-2 rounded-lg ml-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </span>
                        <span class="font-medium text-gray-700 dark:text-gray-200">گزارش کامل مالی</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </a>
                    <a href="{{ route('admin.reports.exams') }}" class="flex items-center p-3 bg-gray-50 dark:bg-gray-700 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600 transition">
                        <span class="bg-blue-100 text-blue-700 p-2 rounded-lg ml-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </span>
                        <span class="font-medium text-gray-700 dark:text-gray-200">گزارش آزمون‌ها و شرکت‌کنندگان</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </main>
@endsection

@push('scripts')
    <script src="{{ asset('assets/js/plugin/chart-js/chart.js') }}"></script>
    <script src="{{ asset('assets/js/dependencies/app.js') }}"></script>

    <!-- chart -->
    <script>
        // Display the current date in Persian format
        document.getElementById('currentDate').textContent = new Date().toLocaleDateString('fa-IR');

        // General settings for Chart.js to support RTL
        Chart.defaults.font.family = 'payda, sans-serif';
        Chart.defaults.layout.padding = {
            right: 20
        };

        // Create the chart for admin with dual Y-axis
        const ctx = document.getElementById('salesChart').getContext('2d');
        const salesChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['فروردین', 'اردیبهشت', 'خرداد', 'تیر', 'مرداد', 'شهریور', 'مهر', 'آبان', 'آذر', 'دی',
                    'بهمن', 'اسفند'
                ],
                datasets: [{
                        label: 'تعداد سفارشات',
                        data: [125, 142, 112, 108, 165, 189, 210, 225, 198, 175, 160, 210],
                        backgroundColor: 'rgba(59, 130, 246, 0.7)',
                        borderColor: 'rgba(59, 130, 246, 1)',
                        borderWidth: 1,
                        yAxisID: 'y'
                    },
                    {
                        label: 'درآمد (میلیون تومان)',
                        data: [18.5, 21.3, 19.8, 20.1, 25.7, 28.9, 31.2, 33.5, 29.8, 26.5, 24.0, 31.5],
                        backgroundColor: 'rgba(16, 185, 129, 0.7)',
                        borderColor: 'rgba(16, 185, 129, 1)',
                        borderWidth: 1,
                        yAxisID: 'y1'
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            boxWidth: 12,
                            padding: 20
                        }
                    },
                    title: {
                        display: true,
                        text: 'آمار فروش ماهانه',
                        font: {
                            size: 16
                        }
                    },
                    tooltip: {
                        callbacks: {
                            title: function(context) {
                                return context[0].label;
                            },
                            label: function(context) {
                                if (context.dataset.label === 'درآمد (میلیون تومان)') {
                                    return 'مبلغ: ' + context.raw.toLocaleString('fa-IR') + ' میلیون تومان';
                                }
                                return 'تعداد: ' + context.raw.toLocaleString('fa-IR');
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'تعداد سفارشات'
                        },
                        ticks: {
                            stepSize: 50,
                            callback: function(value) {
                                return value.toLocaleString('fa-IR');
                            }
                        }
                    },
                    y1: {
                        beginAtZero: true,
                        position: 'right',
                        title: {
                            display: true,
                            text: 'درآمد (میلیون تومان)'
                        },
                        grid: {
                            drawOnChartArea: false
                        },
                        ticks: {
                            callback: function(value) {
                                return value.toLocaleString('fa-IR');
                            }
                        }
                    }
                }
            }
        });
    </script>
@endpush
