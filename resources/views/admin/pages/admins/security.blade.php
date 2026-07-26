@extends('admin.layout.master')

@section('admin-title')
@lang('general.Arya Gostaran Management Panel') / @lang('general.security')
@endsection

@section('admin-content')
<main class="flex-1 overflow-y-auto p-6 bg-gray-50 dark:bg-gray-900">
    <!-- Header -->
    <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">@lang('general.security') - {{ $admin->fullName }}</h2>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">@lang('general.security_description')</p>
        </div>
        <div class="mt-4 md:mt-0">
            <button onclick="window.history.back()"
                class="flex items-center px-4 py-2 text-sm font-medium rounded-lg bg-gray-200 text-gray-700 hover:bg-gray-300 shadow-sm dark:bg-gray-700 dark:text-white dark:hover:bg-gray-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 me-2" viewBox="0 0 20 20"
                    fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z"
                        clip-rule="evenodd" />
                </svg>
                @lang('general.return')
            </button>
        </div>
    </div>

    <!-- Messages -->
    @if(session('success'))
    <div class="mb-6 animate-fade-in">
        <x-alert type="success" message="{{ session('success') }}"></x-alert>
    </div>
    @elseif (session('error'))
    <div class="mb-6 animate-fade-in">
        <x-alert type="error" message="{{ session('error') }}"></x-alert>
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-3 space-y-6">
            <!-- Google 2FA Section -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden transition-all duration-300 hover:shadow-md dark:hover:shadow-gray-900/30">
                <div class="p-6 border-b border-gray-100 dark:border-gray-700 bg-gradient-to-r from-blue-50/50 to-indigo-50/50 dark:from-blue-900/10 dark:to-indigo-900/10">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div class="flex items-start gap-4">
                            <div class="flex-shrink-0 w-12 h-12 rounded-xl bg-gradient-to-br from-blue-100 to-blue-200 dark:from-blue-900/30 dark:to-blue-800/30 flex items-center justify-center">
                                <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-1">@lang('general.google_2fa')</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400">@lang('general.google_2fa_description')</p>
                            </div>
                        </div>
                        <div>
                            @if($admin->two_factor_enabled)
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                @lang('general.active')
                            </span>
                            @else
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-red-900 dark:text-red-200">
                                @lang('general.disabled')
                            </span>
                            @endif
                        </div>
                    </div>

                    @if(!$twoFactorDevices->count())
                    <div class="mt-6">
                        <form method="POST" action="{{ route('admin.security.generate-2fa', $admin) }}">
                            @csrf
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2.5 text-sm font-medium rounded-lg bg-gradient-to-r from-blue-600 to-indigo-600 text-white hover:from-blue-700 hover:to-indigo-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition-all duration-200 shadow-sm">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                                @lang('general.activate_google_2fa')
                            </button>
                        </form>
                    </div>
                    @endif
                </div>

                @error('otp')
                <div class="px-6 pt-4">
                    <x-alert type="error" message="{{ $message }}"></x-alert>
                </div>
                @enderror

                <!-- 2FA Devices Table -->
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300 uppercase tracking-wider">@lang('general.registered_devices')</h4>
                        <span class="text-xs text-gray-500 dark:text-gray-400">{{ $twoFactorDevices->count() }} @lang('general.device')</span>
                    </div>

                    @if($twoFactorDevices->count())
                    <div class="overflow-hidden rounded-lg border border-gray-200 dark:border-gray-700">
                        <table class="w-full text-start">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-4 py-3 text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider text-start">@lang('general.id')</th>
                                    <th class="px-4 py-3 text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider text-start">@lang('general.status')</th>
                                    <th class="px-4 py-3 text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider text-start">@lang('general.last_used')</th>
                                    <th class="px-4 py-3 text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider text-start">@lang('general.operations')</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                                @foreach($twoFactorDevices as $device)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                    <td class="px-4 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                                        #{{ $device->id }}
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        @if($device->is_enabled)
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                            @lang('general.active')
                                        </span>
                                        @else
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-red-900 dark:text-red-200">
                                            @lang('general.inactive')
                                        </span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-400">
                                        @if($device->last_used_at)
                                        <div class="flex items-center">
                                            <svg class="w-4 h-4 text-gray-400 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            {{ $device->last_used_at->diffForHumans() }}
                                        </div>
                                        @else
                                        <span class="text-gray-400 dark:text-gray-500">@lang('general.never_used')</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm">
                                        <div class="flex items-center gap-2">
                                            <form action="{{ route('admin.security.toggle-2fa', $admin) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="device_id" value="{{ $device->id }}">
                                                <button type="submit"
                                                    onclick="return confirm('@lang('general.are_you_sure')')"
                                                    class="inline-flex items-center px-3 py-1.5 text-xs font-medium rounded-lg border transition-colors
                                                    @if($device->is_enabled)
                                                    border-yellow-200 bg-yellow-50 text-yellow-800 hover:bg-yellow-100 dark:border-yellow-900 dark:bg-yellow-900/20 dark:text-yellow-400 dark:hover:bg-yellow-900/30
                                                    @else
                                                    border-blue-200 bg-blue-50 text-blue-800 hover:bg-blue-100 dark:border-blue-900 dark:bg-blue-900/20 dark:text-blue-400 dark:hover:bg-blue-900/30
                                                    @endif">
                                                    @if($device->is_enabled)
                                                    @lang('general.deactivate')
                                                    @else
                                                    @lang('general.activate')
                                                    @endif
                                                </button>
                                            </form>

                                            <form action="{{ route('admin.security.delete-2fa', $admin) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <input type="hidden" name="device_id" value="{{ $device->id }}">
                                                <button type="submit"
                                                    onclick="return confirm('@lang('general.are_you_sure')')"
                                                    class="inline-flex items-center px-3 py-1.5 text-xs font-medium rounded-lg border border-red-200 bg-red-50 text-red-800 hover:bg-red-100 dark:border-red-900 dark:bg-red-900/20 dark:text-red-400 dark:hover:bg-red-900/30 transition-colors">
                                                    @lang('general.delete')
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="text-center py-8">
                        <div class="mx-auto w-16 h-16 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mb-4">
                            <svg class="w-8 h-8 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                        </div>
                        <p class="text-gray-500 dark:text-gray-400 text-sm">@lang('general.no_2fa_device_found')</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Active Devices Section -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden transition-all duration-300 hover:shadow-md dark:hover:shadow-gray-900/30">
                <div class="p-6 border-b border-gray-100 dark:border-gray-700 bg-gradient-to-r from-emerald-50/50 to-green-50/50 dark:from-emerald-900/10 dark:to-green-900/10">
                    <div class="flex items-start gap-4">
                        <div class="flex-shrink-0 w-12 h-12 rounded-xl bg-gradient-to-br from-emerald-100 to-green-200 dark:from-emerald-900/30 dark:to-green-800/30 flex items-center justify-center">
                            <svg class="w-6 h-6 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-1">@lang('general.active_devices')</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400">@lang('general.active_devices_description')</p>
                        </div>
                        <span class="px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300">
                            {{ $activeSessions->count() }} @lang('general.device')
                        </span>
                    </div>
                </div>

                <div class="p-6">
                    @if($activeSessions->count())
                    <div class="overflow-hidden rounded-lg border border-gray-200 dark:border-gray-700">
                        <table class="w-full text-start">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-4 py-3 text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider text-start">@lang('general.device')</th>
                                    <th class="px-4 py-3 text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider text-start">@lang('general.operating_system')</th>
                                    <th class="px-4 py-3 text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider text-start">@lang('general.last_activity')</th>
                                    <th class="px-4 py-3 text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider text-start">@lang('general.operations')</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                                @foreach($activeSessions as $session)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                    <td class="px-4 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="flex-shrink-0">
                                                @if(str_contains(strtolower($session->device), 'mobile'))
                                                <div class="w-10 h-10 rounded-lg bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center">
                                                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                                    </svg>
                                                </div>
                                                @elseif(str_contains(strtolower($session->device), 'tablet'))
                                                <div class="w-10 h-10 rounded-lg bg-indigo-100 dark:bg-indigo-900/30 flex items-center justify-center">
                                                    <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                                    </svg>
                                                </div>
                                                @else
                                                <div class="w-10 h-10 rounded-lg bg-gray-100 dark:bg-gray-700 flex items-center justify-center">
                                                    <svg class="w-5 h-5 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                                    </svg>
                                                </div>
                                                @endif
                                            </div>
                                            <div>
                                                <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $session->device }}</p>
                                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">{{ $session->ip_address }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-4 text-sm text-gray-600 dark:text-gray-400">
                                        {{ $session->platform }} {{ $session->platform_version ?? '' }}
                                    </td>
                                    <td class="px-4 py-4">
                                        <div class="flex items-center text-sm text-gray-600 dark:text-gray-400">
                                            <svg class="w-4 h-4 text-gray-400 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            {{ $session->last_activity->diffForHumans() }}
                                        </div>
                                    </td>
                                    <td class="px-4 py-4">
                                        <form action="{{ route('admin.security.logout-device', $admin) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <input type="hidden" name="session_id" value="{{ $session->id }}">
                                            <button type="submit"
                                                onclick="return confirm('@lang('general.are_you_sure')')"
                                                class="flex items-center px-4 py-2 text-sm font-medium rounded-lg bg-gray-200 text-gray-700 hover:bg-gray-300 shadow-sm dark:bg-gray-700 dark:text-white dark:hover:bg-gray-600">
                                                <svg class="w-3 h-3 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                                </svg>
                                                @lang('general.logout_device')
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="text-center py-8">
                        <div class="mx-auto w-16 h-16 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mb-4">
                            <svg class="w-8 h-8 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <p class="text-gray-500 dark:text-gray-400 text-sm">@lang('general.no_active_device_found')</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- SMS System Section -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden transition-all duration-300 hover:shadow-md dark:hover:shadow-gray-900/30">
                <div class="p-6 border-b border-gray-100 dark:border-gray-700 bg-gradient-to-r from-purple-50/50 to-pink-50/50 dark:from-purple-900/10 dark:to-pink-900/10">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div class="flex items-start gap-4">
                            <div class="flex-shrink-0 w-12 h-12 rounded-xl bg-gradient-to-br from-purple-100 to-pink-200 dark:from-purple-900/30 dark:to-pink-800/30 flex items-center justify-center">
                                <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-1">@lang('general.sms_system')</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400">@lang('general.sms_system_description')</p>
                            </div>
                        </div>
                        <div>
                            @if($admin->otp_enabled)
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                @lang('general.active')
                            </span>
                            @else
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-red-900 dark:text-red-200">
                                @lang('general.disabled')
                            </span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="p-6">
                    <form action="{{ route('admin.security.toggle-sms', $admin) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                            <div class="flex-1">
                                <h4 class="text-sm font-medium text-gray-900 dark:text-white mb-1">@lang('general.sms_notification_status')</h4>
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    @if($admin->otp_enabled)
                                    @lang('general.sms_enabled_description')
                                    @else
                                    @lang('general.sms_disabled_description')
                                    @endif
                                </p>
                            </div>
                            <div class="flex items-center gap-3">
                                <button type="button"
                                    onclick="testSMS()"
                                    class="flex items-center px-4 py-2 text-sm font-medium rounded-lg bg-gray-200 text-gray-700 hover:bg-gray-300 shadow-sm dark:bg-gray-700 dark:text-white dark:hover:bg-gray-600">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                                    </svg>
                                    @lang('general.test_sms')
                                </button>

                                <button type="submit"
                                    class="flex items-center px-4 py-2 text-sm font-medium rounded-lg bg-gray-200 text-gray-700 hover:bg-gray-300 shadow-sm dark:bg-gray-700 dark:text-white dark:hover:bg-gray-600
                                    @if($admin->otp_enabled)
                                    bg-gradient-to-r from-red-500 to-pink-500 hover:from-red-600 hover:to-pink-600 text-white focus:ring-red-500
                                    @else
                                    bg-gradient-to-r from-emerald-500 to-green-500 hover:from-emerald-600 hover:to-green-600 text-white focus:ring-emerald-500
                                    @endif">
                                    @if($admin->otp_enabled)
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    @lang('general.disable_sms')
                                    @else
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    @lang('general.enable_sms')
                                    @endif
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        @include('admin.pages.admins.side')
    </div>
</main>

<!-- 2FA Modal -->
@if(session('show2faModal') && session('twoFactorData'))
<div id="google2fa-modal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm">
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl w-full max-w-md transform transition-all duration-300 scale-100">
        <!-- Header -->
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">@lang('general.google_2fa_verification')</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">@lang('general.google_2fa_modal_description')</p>
                </div>
                <button type="button" onclick="close2faModal()"
                    class="inline-flex items-center justify-center w-10 h-10 rounded-lg
                        bg-white/80 hover:bg-white border border-gray-200 text-gray-700
                        dark:bg-gray-800/60 dark:hover:bg-gray-800 dark:border-gray-700 dark:text-gray-200
                        transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Content -->
        <div class="p-6">
            <!-- QR Code -->
            <div class="mb-6">
                <div class="flex flex-col items-center justify-center">
                    <div class="bg-white p-4 rounded-lg border border-gray-200 dark:border-gray-700 mb-4">
                        {!! QrCode::size(200)->generate(session('twoFactorData')['qrUrl']) !!}
                    </div>
                    <div class="text-center">
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">@lang('general.scan_qr_code')</p>
                        <div class="inline-flex items-center px-3 py-1 rounded-lg bg-gray-100 dark:bg-gray-700">
                            <code class="text-sm font-mono text-gray-800 dark:text-gray-300">{{ session('twoFactorData')['secret'] }}</code>
                            <button type="button" onclick="copySecret()"
                                class="flex items-center px-4 py-2 text-sm font-medium rounded-lg bg-gray-200 text-gray-700 hover:bg-gray-300 shadow-sm dark:bg-gray-700 dark:text-white dark:hover:bg-gray-600">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- OTP Form -->
            <form action="{{ route('admin.security.verify-2fa', $admin) }}" method="POST">
                @csrf
                <input type="hidden" name="secret" value="{{ session('twoFactorData')['secret'] }}">

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            @lang('general.enter_otp')
                        </label>
                        <input type="text" name="otp" maxlength="6" pattern="\d{6}" required
                            class="w-full px-4 py-3 text-lg text-center font-mono rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:focus:ring-blue-500 transition-all"
                            placeholder="123456"
                            autocomplete="off"
                            oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                        @error('otp')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex gap-3">
                        <button type="button" onclick="close2faModal()"
                            class="flex-1 px-4 py-3 text-sm font-medium rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors">
                            @lang('general.cancel')
                        </button>
                        <button type="submit"
                            class="flex-1 px-4 py-3 text-sm font-medium rounded-lg bg-gradient-to-r from-blue-600 to-indigo-600 text-white hover:from-blue-700 hover:to-indigo-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition-all">
                            @lang('general.verify')
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Footer Tips -->
        <div class="p-4 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/50 rounded-b-2xl">
            <div class="flex items-start text-sm text-gray-600 dark:text-gray-400">
                <svg class="w-4 h-4 text-blue-500 dark:text-blue-400 mt-0.5 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <p>@lang('general.otp_tip')</p>
            </div>
        </div>
    </div>
</div>
@endif

<!-- OTP Action Modal -->
@if(session('showOtpModal'))
<div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm">
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl w-full max-w-sm transform transition-all duration-300 scale-100">
        <div class="p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">@lang('general.confirm_action')</h3>
            <form action="{{ route('admin.security.verify-2fa-action') }}" method="POST">
                @csrf
                <input type="hidden" name="device_id" value="{{ session('twoFactorDeviceId') }}">
                <input type="hidden" name="action" value="{{ session('twoFactorAction') }}">

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            @lang('general.enter_otp_to_continue')
                        </label>
                        <input type="text" name="otp" maxlength="6" pattern="\d{6}" required
                            class="w-full px-4 py-3 text-center font-mono rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                            placeholder="000000"
                            autocomplete="off"
                            autofocus>
                    </div>

                    <div class="flex gap-3">
                        <button type="button" onclick="closeModal(this)"
                            class="flex-1 px-4 py-3 text-sm font-medium rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors">
                            @lang('general.cancel')
                        </button>
                        <button type="submit"
                            class="flex-1 px-4 py-3 text-sm font-medium rounded-lg bg-gradient-to-r from-blue-600 to-indigo-600 text-white hover:from-blue-700 hover:to-indigo-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all">
                            @lang('general.confirm')
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endif
@endsection
@push('scripts')
<script src="{{ asset('assets/js/dependencies/app.js') }}"></script>
<script>
    function close2faModal() {
        const modal = document.getElementById('google2fa-modal');
        if (modal) {
            modal.classList.add('opacity-0', 'scale-95');
            setTimeout(() => modal.remove(), 200);
        }
    }

    function closeModal(element) {
        const modal = element.closest('.fixed');
        if (modal) {
            modal.classList.add('opacity-0', 'scale-95');
            setTimeout(() => modal.remove(), 200);
        }
    }

    function copySecret() {
        const secret = "{{ session('twoFactorData.secret') ?? '' }}";
        navigator.clipboard.writeText(secret).then(() => {
            // Show notification
            const button = event.currentTarget;
            const originalHTML = button.innerHTML;
            button.innerHTML = `
            <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
        `;
            setTimeout(() => {
                button.innerHTML = originalHTML;
            }, 2000);
        });
    }

    function testSMS() {
        // Implement SMS test functionality
        alert("@lang('general.sms_test_functionality')");
    }

    // Close modal on ESC key
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            close2faModal();
            const modals = document.querySelectorAll('.fixed.bg-black\\/50');
            modals.forEach(modal => {
                const cancelBtn = modal.querySelector('button[onclick*="close"]');
                if (cancelBtn) cancelBtn.click();
            });
        }
    });
</script>
@endpush
