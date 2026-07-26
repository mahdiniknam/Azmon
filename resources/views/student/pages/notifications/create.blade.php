@extends('admin.layout.master')

@section('admin-title')
    @lang('general.Arya Gostaran Management Panel') / @lang('general.new_notification')
@endsection

@section('admin-content')
    <main class="flex-1 overflow-y-auto p-6 bg-gray-50 dark:bg-gray-900">

        <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">@lang('general.new_notification')</h2>
                <p class="text-gray-600 dark:text-gray-400">@lang('general.new_notification_subtitle')</p>
            </div>
        </div>

        {{-- errors --}}
        @if ($errors->any())
            <x-alert type="error" message="{{ __('general.form_has_errors') }}"></x-alert>
        @endif

        <form action="{{ route('admin.notifications.store') }}" method="POST"
            class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 border border-gray-200 dark:border-gray-700 space-y-6">
            @csrf

            {{-- User --}}
            <div>
                <div class="flex items-center justify-between mb-1">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        @lang('general.User')
                    </label>

                    <div class="flex items-center gap-2">
                        <button type="button" id="btnSelectAllUsers"
                            class="px-3 py-1 text-xs rounded-md bg-gray-200 text-gray-700 hover:bg-gray-300 dark:bg-gray-700 dark:text-white dark:hover:bg-gray-600">
                            @lang('general.select_all_users')
                        </button>

                        <button type="button" id="btnClearAllUsers"
                            class="px-3 py-1 text-xs rounded-md bg-gray-200 text-gray-700 hover:bg-gray-300 dark:bg-gray-700 dark:text-white dark:hover:bg-gray-600">
                            @lang('general.clear_all_users')
                        </button>
                    </div>
                </div>

                <select name="user_ids[]" id="user_ids" multiple
                    class="select2 w-full px-4 py-2  border border-gray-300 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}"
                            {{ collect(old('user_ids', []))->contains($user->id) ? 'selected' : '' }}>
                            {{ $user->FullName }} ({{ $user->id }})
                        </option>
                    @endforeach
                </select>

                @error('user_ids')
                    <x-alert type="error" message="{{ $message }}"></x-alert>
                @enderror
                @error('user_ids.*')
                    <x-alert type="error" message="{{ $message }}"></x-alert>
                @enderror
            </div>

            {{-- Channels --}}
            <div>
                <label class="block text-sm font-medium mb-2 text-gray-700 dark:text-gray-200">@lang('general.channels')</label>
                <div class="flex flex-wrap gap-4">
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="channels[]" value="internal" class="rounded border-gray-300"
                            @checked(in_array('internal', old('channels', []), true))>
                        <span class="ms-2 text-sm">@lang('general.notification_type_internal')</span>
                    </label>

                    <label class="inline-flex items-center">
                        <input type="checkbox" name="channels[]" value="email" class="rounded border-gray-300"
                            @checked(in_array('email', old('channels', []), true))>
                        <span class="ms-2 text-sm">@lang('general.notification_type_email')</span>
                    </label>

                    <label class="inline-flex items-center">
                        <input type="checkbox" name="channels[]" value="sms" class="rounded border-gray-300"
                            @checked(in_array('sms', old('channels', []), true))>
                        <span class="ms-2 text-sm">@lang('general.notification_type_sms')</span>
                    </label>
                </div>

                @error('channels')
                    <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                @enderror
            </div>

            {{-- Translations --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label
                        class="block text-sm font-medium mb-2 text-gray-700 dark:text-gray-200">@lang('general.title_fa')</label>
                    <input name="title[fa]" value="{{ old('title.fa') }}"
                        class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600"
                        placeholder="@lang('general.title_fa_placeholder')">
                    @error('title')
                        <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="md:col-span-2">
                    <label
                        class="block text-sm font-medium mb-2 text-gray-700 dark:text-gray-200">@lang('general.description_fa')</label>
                    <textarea name="description[fa]" rows="4"
                        class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600" placeholder="@lang('general.description_fa_placeholder')">{{ old('description.fa') }}</textarea>
                </div>
            </div>
            <div class="flex items-center justify-end gap-3">
                <a href="{{ route('admin.notifications.index') }}"
                    class="px-4 py-2 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700">
                    @lang('general.back')
                </a>

                <button type="submit" class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700">
                    @lang('general.create')
                </button>
            </div>

        </form>

    </main>
@endsection

@push('scripts')
    <script src="{{ asset('assets/js/dependencies/app.js') }}"></script>
    <script src="{{ asset('assets/js/plugin/jquery/jquery1.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugin/jquery/select2.js') }}"></script>

    <script>
        $(document).ready(function() {
            const $userSelect = $('#user_ids');

            $userSelect.select2({
                placeholder: "@lang('general.select_user')",
                allowClear: true,
                width: '100%'
            });

            // Select all
            $('#btnSelectAllUsers').on('click', function() {
                const allValues = $userSelect.find('option').map(function() {
                    return $(this).val();
                }).get();

                $userSelect.val(allValues).trigger('change');
            });

            // Clear all
            $('#btnClearAllUsers').on('click', function() {
                $userSelect.val(null).trigger('change');
            });
        });
    </script>
@endpush
