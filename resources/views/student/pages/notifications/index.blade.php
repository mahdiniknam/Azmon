@extends('admin.layout.master')

@section('admin-title')
    @lang('general.Arya Gostaran Management Panel') / @lang('general.notification_center')
@endsection

@section('admin-content')
    <main class="flex-1 overflow-y-auto p-6 bg-gray-50 dark:bg-gray-900">

        {{-- Page header --}}
        <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">@lang('general.notification_center')</h2>
                <p class="text-gray-600 dark:text-gray-400">@lang('general.notification_center_subtitle')</p>
            </div>

            <div class="mt-4 md:mt-0 flex items-center space-x-4 space-x-reverse">

                {{-- Mark all (based on filters) --}}
                <form action="{{ route('admin.notifications.mark_all_read', request()->query()) }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="px-4 py-2 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg flex items-center hover:bg-gray-50 dark:hover:bg-gray-700">
                        <svg class="w-5 h-5 me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                        @lang('general.mark_all_read') ({{ $unreadCount }})
                    </button>
                </form>

                {{-- Create --}}
                <a href="{{ route('admin.notifications.create') }}"
                    class="flex items-center px-4 py-2 text-sm font-medium rounded-lg bg-primary-600 text-white hover:bg-primary-500 shadow-sm dark:bg-primary-500 dark:hover:bg-primary-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 me-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"
                            clip-rule="evenodd" />
                    </svg>
                    @lang('general.new_notification')
                </a>
            </div>
        </div>

        {{-- flash messages --}}
        @if (session('success'))
            <x-alert type="success" message="{{ session('success') }}"></x-alert>
        @elseif (session('error'))
            <x-alert type="error" message="{{ session('error') }}"></x-alert>
        @endif

        {{-- Filters --}}
        <form method="GET"
            class="mb-6 bg-white dark:bg-gray-800 rounded-xl shadow-md p-4 border border-gray-200 dark:border-gray-700">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">

                {{-- Type --}}
                <div>
                    <label class="block text-sm font-medium mb-2 text-gray-700 dark:text-gray-200">@lang('general.notification_type')</label>
                    <select name="type" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600">
                        <option value="">@lang('general.all_types')</option>
                        <option value="internal" @selected(request('type') === 'internal')>@lang('general.notification_type_internal')</option>
                        <option value="email" @selected(request('type') === 'email')>@lang('general.notification_type_email')</option>
                        <option value="sms" @selected(request('type') === 'sms')>@lang('general.notification_type_sms')</option>
                    </select>
                </div>

                {{-- Read status --}}
                <div>
                    <label
                        class="block text-sm font-medium mb-2 text-gray-700 dark:text-gray-200">@lang('general.read_status')</label>
                    <select name="read" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600">
                        <option value="">@lang('general.all_statuses')</option>
                        <option value="0" @selected(request('read') === '0')>@lang('general.unread')</option>
                        <option value="1" @selected(request('read') === '1')>@lang('general.read')</option>
                    </select>
                </div>

                {{-- Range --}}
                <div>
                    <label
                        class="block text-sm font-medium mb-2 text-gray-700 dark:text-gray-200">@lang('general.time_range')</label>
                    <select name="range" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600">
                        <option value="">@lang('general.all_times')</option>
                        <option value="7days" @selected(request('range') === '7days')>@lang('general.last_7_days')</option>
                        <option value="1month" @selected(request('range') === '1month')>@lang('general.last_1_month')</option>
                    </select>
                </div>

                <div class="self-end">
                    <button class="w-full px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700">
                        @lang('general.apply_filter')
                    </button>
                </div>
            </div>
        </form>

        {{-- List --}}
        <div
            class="bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden border border-gray-200 dark:border-gray-700">

            @forelse($notifications as $notification)
                @php
                    $isUnread = !$notification->read;
                    $title = $notification->title;
                    $desc = $notification->description;
                @endphp

                <div
                    class="p-6 border-b border-gray-200 dark:border-gray-700 {{ $isUnread ? 'bg-primary-50 dark:bg-primary-900/20' : '' }}">
                    <div class="flex items-start">

                        {{-- left icon --}}
                        <div class="flex-shrink-0 mt-1">
                            @if ($isUnread)
                                <span class="w-3 h-3 bg-primary-600 rounded-full animate-pulse inline-block"></span>
                            @else
                                <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                            @endif
                        </div>

                        <div class="ms-4 flex-1">
                            <div class="flex items-center justify-between">
                                <h3 class="font-medium text-gray-900 dark:text-white">
                                    {{ $title ?: __('general.untitled_notification') }}
                                </h3>
                                <div class="text-xs text-gray-500 dark:text-gray-400 flex items-center gap-2">
                                    {{-- گیرنده --}}
                                    @if ($notification->user)
                                        <a href="{{ route('admin.users.show', $notification->user) }}"
                                            class="inline-flex items-center px-2 py-1 rounded-full bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-200">
                                            @lang('general.receiver'):

                                            {{ $notification->user->FullName ?? ($notification->user->name ?? ($notification->user->email ?? '#' . $notification->user->id)) }}
                                            <span class="ms-1 opacity-70">(#{{ $notification->user->id }})</a>
                                        </a>
                                    @else
                                        @lang('general.all_users')
                                    @endif


                                    {{-- تاریخ --}}
                                    <span>
                                        {{ jdate($notification->created_at, 'Y/m/d H:i') }}
                                    </span>
                                </div>

                            </div>

                            <p class="mt-2 text-gray-600 dark:text-gray-300">
                                {{ $desc ?: '-' }}
                            </p>

                            <div class="mt-4 flex items-center space-x-4 space-x-reverse">
                                <a href="{{ route('admin.notifications.show', $notification) }}"
                                    class="text-primary-600 hover:text-primary-800 dark:text-primary-400 dark:hover:text-primary-300 text-sm">
                                    @lang('general.view_details')
                                </a>

                                @if ($isUnread)
                                    <form action="{{ route('admin.notifications.read', $notification) }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                            class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300 text-sm">
                                            @lang('general.mark_as_read')
                                        </button>
                                    </form>
                                @else
                                    <form action="{{ route('admin.notifications.unread', $notification) }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                            class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300 text-sm">
                                            @lang('general.mark_as_unread')
                                        </button>
                                    </form>
                                @endif
                            </div>

                            {{-- badges: channels --}}
                            <div class="mt-3 flex flex-wrap gap-2">
                                @foreach ($notification->type ?? [] as $t)
                                    <span
                                        class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-200">
                                        @lang('general.notification_type_' . $t)
                                    </span>
                                @endforeach
                            </div>

                        </div>
                    </div>
                </div>

            @empty
                <div class="p-8 text-center text-gray-500 dark:text-gray-400">
                    @lang('general.no_notifications_found')
                </div>
            @endforelse

            {{-- pagination --}}
            <div class="bg-white dark:bg-gray-800 px-6 pt-4 border-t border-gray-200 dark:border-gray-700">
                {{ $notifications->links() }}
            </div>
        </div>

    </main>
@endsection

@push('scripts')
    <script src="{{ asset('assets/js/dependencies/app.js') }}"></script>
@endpush
