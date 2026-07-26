@extends('teacher.layout.master')
@section('teacher-title', 'نتایج آزمون')
@section('teacher-content')
<main class="flex-1 overflow-y-auto p-6 bg-gray-50 dark:bg-gray-900">
    <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">نتایج آزمون: {{ $exam->title }}</h2>
            <p class="text-gray-600 dark:text-gray-400">لیست شرکت کنندگان و نمرات و تقلب‌ها</p>
        </div>
        <div class="mt-4 md:mt-0">
            <a href="{{ route('teacher.reports.index') }}" class="px-4 py-2 text-sm font-medium rounded-lg bg-gray-600 text-white hover:bg-gray-500 shadow-sm">بازگشت</a>
        </div>
    </div>

    <div class="bg-white py-6 space-y-4 rounded-xl shadow-md border border-gray-200">
        <div class="overflow-x-auto">
            <table class="w-full text-start">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">نام دانشجو</th>
                        <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">ایمیل/موبایل</th>
                        <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">نمره</th>
                        <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">وضعیت</th>
                        <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">تقلب</th>
                        <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">زمان شرکت</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($participants as $participant)
                    <tr>
                        <td class="px-6 py-4 text-sm text-gray-900">{{ $participant->user->name ?? 'نامشخص' }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900">{{ $participant->user->email ?? ($participant->user->phone ?? '-') }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900">{{ $participant->score ?? '-' }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900">
                            @if($participant->status == 'finished')
                                پایان یافته
                            @else
                                در حال انجام
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm">
                            @if(($participant->suspicious_events_count ?? 0) > 0)
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-700">
                                    {{ $participant->suspicious_events_count }} مورد
                                </span>
                                <div class="mt-1 text-xs text-gray-500">
                                    @foreach($participant->suspiciousEvents->groupBy('type') as $type => $items)
                                        <div>{{ $type }}: {{ $items->count() }}</div>
                                    @endforeach
                                </div>
                            @else
                                <span class="text-green-600 text-xs">بدون مورد</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900">{{ $participant->started_at ? jdate($participant->started_at)->format('Y/m/d H:i') : '-' }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="px-6 py-4 text-center">شرکت کننده‌ای یافت نشد.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</main>
@endsection
