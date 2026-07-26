@extends('admin.layout.master')

@section('admin-title')
    @lang('general.System settings')
@endsection

@section('admin-content')
    <main class="flex-1 overflow-y-auto p-6 bg-gray-50 dark:bg-gray-900">

        <div class="mb-6 flex flex-row md:flex-row md:items-center md:justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">@lang('general.System settings')</h2>
                <p class="text-gray-600 dark:text-gray-400">@lang('general.Manage system settings')</p>
            </div>
            <button onclick="window.history.back()"
                class="flex items-center px-4 py-2 text-sm font-medium rounded-lg bg-gray-200 text-gray-700 hover:bg-gray-300 shadow-sm dark:bg-gray-700 dark:text-white dark:hover:bg-gray-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 me-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z"
                        clip-rule="evenodd" />
                </svg>
                @lang('general.return')
            </button>
        </div>

        {{-- تب‌بار حدسی --}}
        <div class="mb-6">
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('admin.setting.site.edit') }}"
                    class="px-4 py-2 rounded-lg text-sm border bg-white dark:bg-gray-800 dark:border-gray-700">
                    @lang('general.Site settings')
                </a>
            </div>
        </div>

        @include('components.alerts')
        {{-- Site settings --}}
        <form method="POST" action="{{ route('admin.setting.site.update') }}" enctype="multipart/form-data">
            @csrf

            <div
                class="bg-white dark:bg-gray-800 rounded-xl shadow-md mb-6 p-6 border border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold mb-6">@lang('general.Site settings')</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    {{-- site_name --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            @lang('general.Site name')
                        </label>
                        <input type="text" name="site_name"
                            class="w-full px-3 py-2 border rounded-lg focus:ring-primary focus:border-primary dark:bg-gray-700"
                            value="{{ old('site_name', $settings['site_name'] ?? '') }}">
                    </div>

                    {{-- site_email --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            @lang('general.Site email')
                        </label>
                        <input type="email" name="site_email"
                            class="w-full px-3 py-2 border rounded-lg focus:ring-primary focus:border-primary dark:bg-gray-700"
                            value="{{ old('site_email', $settings['site_email'] ?? '') }}">
                    </div>

                    {{-- site_author --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            @lang('general.Site author')
                        </label>
                        <input type="text" name="site_author"
                            class="w-full px-3 py-2 border rounded-lg focus:ring-primary focus:border-primary dark:bg-gray-700"
                            value="{{ old('site_author', $settings['site_author'] ?? '') }}">
                    </div>

                    {{-- site_copy_right --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            @lang('general.Site copyright')
                        </label>
                        <input type="text" name="site_copy_right"
                            class="w-full px-3 py-2 border rounded-lg focus:ring-primary focus:border-primary dark:bg-gray-700"
                            value="{{ old('site_copy_right', $settings['site_copy_right'] ?? '') }}">
                    </div>

                    {{-- site_des --}}
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            @lang('general.Site description')
                        </label>
                        <textarea name="site_des" rows="4"
                            class="w-full px-3 py-2 border rounded-lg focus:ring-primary focus:border-primary dark:bg-gray-700">{{ old('site_des', $settings['site_des'] ?? '') }}</textarea>
                    </div>

                    {{-- site_logo --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            @lang('general.Site logo')
                        </label>
                        <input type="file" name="site_logo" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700">
                        @if (!empty($settings['site_logo']))
                            <div class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                                <a class="text-primary-600" href="{{ $settings['site_logo'] }}"
                                    target="_blank">@lang('general.Current file')</a>
                            </div>
                        @endif
                    </div>

                    {{-- site_favicon --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            @lang('general.Site favicon')
                        </label>
                        <input type="file" name="site_favicon"
                            class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700">
                        @if (!empty($settings['site_favicon']))
                            <div class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                                <a class="text-primary-600" href="{{ $settings['site_favicon'] }}"
                                    target="_blank">@lang('general.Current file')</a>
                            </div>
                        @endif
                    </div>

                    {{-- site_icon --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            @lang('general.Site icon')
                        </label>
                        <input type="file" name="site_icon" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700">
                        @if (!empty($settings['site_icon']))
                            <div class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                                <a class="text-primary-600" href="{{ $settings['site_icon'] }}"
                                    target="_blank">@lang('general.Current file')</a>
                            </div>
                        @endif
                    </div>

                    {{-- site_login_picture --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            @lang('general.Site login picture')
                        </label>
                        <input type="file" name="site_login_picture"
                            class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700">
                        @if (!empty($settings['site_login_picture']))
                            <div class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                                <a class="text-primary-600" href="{{ $settings['site_login_picture'] }}"
                                    target="_blank">@lang('general.Current file')</a>
                            </div>
                        @endif
                    </div>

                    {{-- terms_pdf --}}
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            @lang('general.Terms pdf')
                        </label>
                        <input type="file" name="terms_pdf" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700">
                        @if (!empty($settings['terms_pdf']))
                            <div class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                                <a class="text-primary-600" href="{{ $settings['terms_pdf'] }}"
                                    target="_blank">@lang('general.Current file')</a>
                            </div>
                        @endif
                    </div>

                </div>

                <div class="mt-6 flex justify-end">
                    <button class="px-6 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-500">
                        @lang('general.Save changes')
                    </button>
                </div>
            </div>
        </form>

    </main>
@endsection

@push('scripts')
    <script src="{{ asset('assets/js/dependencies/app.js') }}"></script>
@endpush
