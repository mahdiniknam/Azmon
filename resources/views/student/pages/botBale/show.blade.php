@extends('student.layout.master')

@section('student-title')
    @lang('general.Arya Gostaran Management Panel')
@endsection

@section('student-content')
    <div class="max-w-3xl mx-auto px-4 py-8">
        <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">
            <div class="px-6 py-5 border-b border-slate-100">
                <h1 class="text-xl font-bold text-slate-900">اتصال حساب بله</h1>
                <p class="mt-2 text-sm text-slate-600">
                    حساب بله خود را متصل کنید تا اعلان‌ها و گزارش‌های آزمون برای شما ارسال شود.
                </p>
            </div>

            <div class="p-6 space-y-6">
                @if (session('success'))
                    <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700">
                        {{ session('error') }}
                    </div>
                @endif

                <div class="rounded-2xl bg-slate-50 border border-slate-200 p-5">
                    <h2 class="text-base font-semibold text-slate-900">وضعیت اتصال</h2>

                    @if ($user->bale_chat_id)
                        <div class="mt-4 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                            <div>
                                <p class="text-sm text-emerald-700 font-medium">
                                    حساب بله شما متصل است.
                                </p>
                                <p class="mt-1 text-xs text-slate-500">
                                    Chat ID: {{ $user->bale_chat_id }}
                                </p>
                                @if ($user->bale_linked_at)
                                    <p class="mt-1 text-xs text-slate-500">
                                        تاریخ اتصال: {{ $user->bale_linked_at->format('Y/m/d H:i') }}
                                    </p>
                                @endif
                            </div>

                            <form action="{{ route('student.profile.bale.disconnect') }}" method="POST"
                                onsubmit="return confirm('اتصال حساب بله حذف شود؟');">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="inline-flex items-center justify-center rounded-xl bg-rose-600 px-4 py-2 text-sm font-medium text-white hover:bg-rose-700 transition">
                                    قطع اتصال
                                </button>
                            </form>
                        </div>
                    @else
                        <p class="mt-4 text-sm text-slate-600">
                            هنوز هیچ حساب بله‌ای به پروفایل شما متصل نشده است.
                        </p>
                    @endif
                </div>

                <div class="rounded-2xl border border-slate-200 p-5">
                    <h2 class="text-base font-semibold text-slate-900">دریافت کد اتصال</h2>
                    <p class="mt-2 text-sm text-slate-600 leading-6">
                        برای اتصال حساب، ابتدا کد یک‌بارمصرف بسازید، سپس آن را برای ربات بله ارسال کنید.
                    </p>

                    @php
                        $connectCode = session('bale_connect_code') ?? ($activeBaleCode->code ?? null);
                        $expiresAt = $activeBaleCode->expires_at ?? null;
                    @endphp

                    @if ($connectCode)
                        <div class="mt-4 rounded-2xl bg-sky-50 border border-sky-200 p-5 text-center">
                            <p class="text-sm text-slate-700">کد اتصال شما</p>
                            <div class="mt-3 text-3xl font-extrabold tracking-[0.3em] text-sky-700 dir-ltr">
                                {{ $connectCode }}
                            </div>

                            @if ($expiresAt)
                                <p class="mt-3 text-xs text-slate-500">
                                    اعتبار تا: {{ jdate($expiresAt)->format('Y/m/d H:i') }}
                                </p>
                            @endif

                            <p class="mt-4 text-sm text-slate-600">
                                این کد را در بله برای ربات ارسال کنید:
                            </p>

                            <div
                                class="mt-3 rounded-xl bg-white border border-slate-200 px-4 py-3 text-sm text-slate-800 dir-ltr">
                                connect {{ $connectCode }}
                            </div>
                        </div>
                    @endif

                    <div class="mt-5">
                        <form action="{{route('student.profile.bale.connect')}}" method="POST">
                            @csrf
                            <button type="submit"
                                class="inline-flex items-center justify-center rounded-xl bg-sky-600 px-5 py-2.5 text-sm font-medium text-black hover:bg-sky-700 transition">
                                {{ $connectCode ? 'ساخت کد جدید' : 'ایجاد کد اتصال' }}
                            </button>
                        </form>
                    </div>
                </div>

                <div class="rounded-2xl border border-amber-200 bg-amber-50 p-5">
                    <h2 class="text-base font-semibold text-amber-900">مراحل اتصال</h2>
                    <ol class="mt-3 space-y-2 text-sm text-amber-800 leading-6">
                        <li>1) روی دکمه «ایجاد کد اتصال» بزنید.</li>
                        <li>2) وارد ربات بله شوید.</li>
                        <li>3) پیام `connect کد` را برای ربات ارسال کنید.</li>
                        <li>4) پس از تایید، حساب بله شما به این پروفایل متصل می‌شود.</li>
                    </ol>
                </div>

                @if (!empty($baleBotUsername))
                    <div class="rounded-2xl border border-slate-200 p-5">
                        <h2 class="text-base font-semibold text-slate-900">ورود به ربات</h2>
                        <p class="mt-2 text-sm text-slate-600">
                            برای شروع اتصال، وارد ربات زیر شوید:
                        </p>
                        <div class="mt-3">
                            <a href="{{ $baleBotUsername }}" target="_blank" rel="noopener noreferrer"
                                class="inline-flex items-center justify-center rounded-xl bg-slate-900 px-4 py-2 text-sm font-medium text-white hover:bg-slate-800 transition">
                                باز کردن ربات بله
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('assets/js/dependencies/app.js') }}"></script>
@endpush
