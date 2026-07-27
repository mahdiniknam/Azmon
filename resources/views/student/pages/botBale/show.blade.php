@extends('student.layout.master')

@section('student-title')
    @lang('general.Arya Gostaran Management Panel')
@endsection

@section('student-content')
    <div class="mx-auto w-full max-w-5xl px-4 py-5">
        <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">
            {{-- Header --}}
            <div class="border-b border-slate-100 px-5 py-4 sm:px-6">
                <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h1 class="text-lg sm:text-xl font-black text-slate-900">اتصال حساب بله</h1>
                        <p class="mt-1 text-sm text-slate-500">
                            برای دریافت اعلان‌ها، گزارش آزمون و پیام‌های سامانه، حساب بله خود را متصل کنید.
                        </p>
                    </div>

                    @if (!empty($baleBotUsername))
                        <a href="{{ $baleBotUsername }}" target="_blank" rel="noopener noreferrer"
                            class="inline-flex items-center justify-center rounded-xl bg-[#1379f0] px-4 py-2 text-sm font-semibold text-black shadow-sm transition hover:bg-blue-600">
                            باز کردن ربات بله
                        </a>
                    @endif
                </div>
            </div>

            <div class="p-4 sm:p-5 lg:p-6">
                {{-- Alerts --}}
                <div class="space-y-3">
                    @if (session('success'))
                        <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700">
                            {{ session('error') }}
                        </div>
                    @endif
                </div>

                @php
                    $connectCode = session('bale_connect_code') ?? ($activeBaleCode->code ?? null);
                    $expiresAt = $activeBaleCode->expires_at ?? null;
                @endphp

                {{-- Main Grid --}}
                <div class="mt-4 grid grid-cols-1 gap-4 xl:grid-cols-3">
                    {{-- Right/Main Section --}}
                    <div class="xl:col-span-2 space-y-4">
                        {{-- Connection Status --}}
                        <div class="rounded-2xl border border-slate-200 bg-slate-50/70 p-4">
                            <div class="flex items-start justify-between gap-3">
                                <div>
                                    <h2 class="text-sm font-bold text-slate-900">وضعیت اتصال</h2>
                                    <p class="mt-1 text-xs text-slate-500">
                                        وضعیت فعلی اتصال حساب بله به پروفایل شما
                                    </p>
                                </div>

                                <div>
                                    @if ($user->bale_chat_id)
                                        <span
                                            class="inline-flex rounded-full border border-emerald-200 bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-700">
                                            متصل
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex rounded-full border border-slate-200 bg-white px-3 py-1 text-xs font-semibold text-slate-600">
                                            متصل نیست
                                        </span>
                                    @endif
                                </div>
                            </div>

                            @if ($user->bale_chat_id)
                                <div class="mt-4 grid grid-cols-1 gap-3 sm:grid-cols-2">
                                    <div class="rounded-xl border border-slate-200 bg-white px-4 py-3">
                                        <div class="text-xs text-slate-500">Chat ID</div>
                                        <div class="mt-1 text-sm font-bold text-slate-800 dir-ltr">
                                            {{ $user->bale_chat_id }}
                                        </div>
                                    </div>

                                    <div class="rounded-xl border border-slate-200 bg-white px-4 py-3">
                                        <div class="text-xs text-slate-500">تاریخ اتصال</div>
                                        <div class="mt-1 text-sm font-bold text-slate-800">
                                            {{ $user->bale_linked_at ? jdate($user->bale_linked_at)->format('Y/m/d H:i') : '---' }}
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-4 flex flex-wrap gap-2">
                                    <a href="{{ $baleBotUsername ?? '#' }}" target="_blank" rel="noopener noreferrer"
                                        class="inline-flex items-center justify-center rounded-xl border border-slate-300 bg-white px-4 py-2 text-sm font-medium text-slate-700 transition hover:bg-slate-50">
                                        ورود به ربات
                                    </a>

                                    <form action="{{ route('student.profile.bale.disconnect') }}" method="POST"
                                        onsubmit="return confirm('اتصال حساب بله حذف شود؟');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="inline-flex items-center justify-center rounded-xl bg-rose-600 px-4 py-2 text-sm font-medium text-white transition hover:bg-rose-700">
                                            قطع اتصال
                                        </button>
                                    </form>
                                </div>
                            @else
                                <div
                                    class="mt-4 rounded-xl border border-dashed border-slate-300 bg-white px-4 py-4 text-sm text-slate-600">
                                    هنوز هیچ حساب بله‌ای به پروفایل شما متصل نشده است.
                                </div>
                            @endif
                        </div>

                        {{-- Connect Code --}}
                        <div class="rounded-2xl border border-sky-200 bg-gradient-to-br from-sky-50 to-white p-4">
                            <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                                <div>
                                    <h2 class="text-sm font-bold text-slate-900">کد اتصال</h2>
                                    <p class="mt-1 text-xs text-slate-500">
                                        ابتدا کد یک‌بارمصرف بسازید و آن را برای ربات بله ارسال کنید.
                                    </p>
                                </div>

                                <form action="{{ route('student.profile.bale.connect') }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="inline-flex items-center justify-center rounded-xl bg-[#1379f0] px-4 py-2 text-sm font-semibold text-black shadow-sm transition hover:bg-blue-600">
                                        {{ $connectCode ? 'ساخت کد جدید' : 'ایجاد کد اتصال' }}
                                    </button>
                                </form>
                            </div>

                            @if ($connectCode)
                                <div class="mt-4 grid grid-cols-1 gap-3 lg:grid-cols-[1fr_auto]">
                                    <div class="rounded-2xl border border-sky-200 bg-white px-4 py-4">
                                        <div class="text-xs text-slate-500">کد فعال شما</div>
                                        <div
                                            class="mt-2 text-2xl sm:text-3xl font-black tracking-[0.35em] text-sky-700 dir-ltr">
                                            {{ $connectCode }}
                                        </div>

                                        @if ($expiresAt)
                                            <div class="mt-3 text-xs text-slate-500">
                                                اعتبار تا:
                                                <span class="font-semibold text-slate-700">
                                                    {{ jdate($expiresAt)->format('Y/m/d H:i') }}
                                                </span>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="rounded-2xl border border-slate-200 bg-slate-900 px-4 py-4 text-white">
                                        <div class="text-xs text-slate-300">پیام آماده برای ارسال</div>
                                        <div class="mt-2 rounded-xl bg-white/10 px-3 py-3 text-sm font-semibold dir-ltr">
                                            connect {{ $connectCode }}
                                        </div>
                                        <div class="mt-3 text-xs leading-6 text-slate-300">
                                            یا اگر webhook جدیدت را گذاشتی، می‌توانی فقط خود کد را هم بفرستی.
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div
                                    class="mt-4 rounded-2xl border border-dashed border-sky-300 bg-white px-4 py-5 text-sm text-slate-600">
                                    هنوز کدی ساخته نشده است. برای شروع، روی دکمه
                                    <span class="font-bold text-slate-800">ایجاد کد اتصال</span>
                                    بزنید.
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Left/Side Section --}}
                    <div class="space-y-4">
                        {{-- Steps --}}
                        <div class="rounded-2xl border border-amber-200 bg-amber-50 p-4">
                            <h2 class="text-sm font-bold text-amber-900">مراحل اتصال</h2>

                            <div class="mt-3 space-y-2">
                                <div class="flex items-start gap-3 rounded-xl bg-white/70 px-3 py-2">
                                    <span
                                        class="mt-0.5 inline-flex h-6 w-6 items-center justify-center rounded-full bg-amber-200 text-xs font-bold text-amber-900">1</span>
                                    <p class="text-sm text-amber-900">کد اتصال بسازید.</p>
                                </div>

                                <div class="flex items-start gap-3 rounded-xl bg-white/70 px-3 py-2">
                                    <span
                                        class="mt-0.5 inline-flex h-6 w-6 items-center justify-center rounded-full bg-amber-200 text-xs font-bold text-amber-900">2</span>
                                    <p class="text-sm text-amber-900">وارد ربات بله شوید.</p>
                                </div>

                                <div class="flex items-start gap-3 rounded-xl bg-white/70 px-3 py-2">
                                    <span
                                        class="mt-0.5 inline-flex h-6 w-6 items-center justify-center rounded-full bg-amber-200 text-xs font-bold text-amber-900">3</span>
                                    <p class="text-sm text-amber-900">پیام <span class="font-bold dir-ltr">connect کد</span>
                                        را ارسال کنید.</p>
                                </div>

                                <div class="flex items-start gap-3 rounded-xl bg-white/70 px-3 py-2">
                                    <span
                                        class="mt-0.5 inline-flex h-6 w-6 items-center justify-center rounded-full bg-amber-200 text-xs font-bold text-amber-900">4</span>
                                    <p class="text-sm text-amber-900">پس از تایید، گزارش‌ها در بله برای شما ارسال می‌شود.
                                    </p>
                                </div>
                            </div>
                        </div>

                        {{-- Tips --}}
                        <div class="rounded-2xl border border-slate-200 bg-white p-4">
                            <h2 class="text-sm font-bold text-slate-900">نکات مهم</h2>

                            <ul class="mt-3 space-y-2 text-sm text-slate-600">
                                <li class="rounded-xl bg-slate-50 px-3 py-2">
                                    کد اتصال یک‌بارمصرف است.
                                </li>
                                <li class="rounded-xl bg-slate-50 px-3 py-2">
                                    بعد از انقضا باید کد جدید بسازید.
                                </li>
                                <li class="rounded-xl bg-slate-50 px-3 py-2">
                                    هر حساب بله فقط به یک کاربر متصل می‌شود.
                                </li>
                            </ul>
                        </div>

                        {{-- Bot CTA --}}
                        @if (!empty($baleBotUsername))
                            <div class="rounded-2xl border border-slate-200 bg-slate-950 p-4 text-white">
                                <h2 class="text-sm font-bold">ورود سریع به ربات</h2>
                                <p class="mt-2 text-xs leading-6 text-slate-300">
                                    برای استارت ربات و ارسال کد اتصال، از دکمه زیر استفاده کنید.
                                </p>

                                <a href="{{ $baleBotUsername }}" target="_blank" rel="noopener noreferrer"
                                    class="mt-4 inline-flex w-full items-center justify-center rounded-xl bg-[#1379f0] px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-blue-600">
                                    باز کردن ربات بله
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('scripts')
    <script src="{{ asset('assets/js/dependencies/app.js') }}"></script>
@endpush
