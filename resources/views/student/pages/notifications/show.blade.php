@extends('admin.layout.master')

@section('admin-title')
    @lang('general.Arya Gostaran Management Panel') / @lang('general.notification_details')
@endsection

@section('admin-content')
    <main class="flex-1 overflow-y-auto p-6 bg-gray-50 dark:bg-gray-900">

        <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">@lang('general.notification_details')</h2>
                <p class="text-gray-600 dark:text-gray-400">
                    @lang('general.notification_id'): {{ $notification->id }}
                </p>
            </div>

            <div class="mt-4 md:mt-0 flex items-center gap-3">
                <a href="{{ route('admin.notifications.index') }}"
                    class="px-4 py-2 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700">
                    @lang('general.back')
                </a>

                @if(!$notification->read)
                    <form action="{{ route('admin.notifications.read', $notification) }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700">
                            @lang('general.mark_as_read')
                        </button>
                    </form>
                @else
                    <form action="{{ route('admin.notifications.unread', $notification) }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="px-4 py-2 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700">
                            @lang('general.mark_as_unread')
                        </button>
                    </form>
                @endif
            </div>
        </div>

        {{-- flash --}}
        @if (session('success'))
            <x-alert type="success" message="{{ session('success') }}"></x-alert>
        @elseif (session('error'))
            <x-alert type="error" message="{{ session('error') }}"></x-alert>
        @endif

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 border border-gray-200 dark:border-gray-700 space-y-6">

            {{-- main --}}
            <div>
                <h3 class="font-bold text-lg text-gray-900 dark:text-white mb-2">
                    {{ $notification->title ?: __('general.untitled_notification') }}
                </h3>

                <p class="text-gray-600 dark:text-gray-300">
                    {{ $notification->description ?: '-' }}
                </p>
            </div>

            {{-- meta info --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="p-4 rounded-xl border border-gray-200 dark:border-gray-700">
                    <div class="text-xs text-gray-500 dark:text-gray-400">@lang('general.created_at')</div>
                    <div class="mt-1 text-sm text-gray-900 dark:text-white">{{ jdate($notification->created_at, 'Y/m/d H:i') }}</div>
                </div>

                <div class="p-4 rounded-xl border border-gray-200 dark:border-gray-700">
                    <div class="text-xs text-gray-500 dark:text-gray-400">@lang('general.read_status')</div>
                    <div class="mt-1 text-sm text-gray-900 dark:text-white">
                        {{ $notification->read ? __('general.read') : __('general.unread') }}
                    </div>
                </div>

                <div class="p-4 rounded-xl border border-gray-200 dark:border-gray-700">
                    <div class="text-xs text-gray-500 dark:text-gray-400">@lang('general.channels')</div>
                    <div class="mt-2 flex flex-wrap gap-2">
                        @foreach(($notification->type ?? []) as $t)
                            <span class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-200">
                                @lang('general.notification_type_'.$t)
                            </span>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>

    </main>
@endsection

@push('scripts')
    <script src="{{ asset('assets/js/dependencies/app.js') }}"></script>
@endpush
