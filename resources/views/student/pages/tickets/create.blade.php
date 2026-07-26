@extends('admin.layout.master')

@section('admin-title')
@lang('general.Arya Gostaran Management Panel') / @lang('general.create_ticket')
@endsection

@section('admin-content')
<main class="flex-1 overflow-y-auto p-6 bg-gray-50 dark:bg-gray-900">

    <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">@lang('general.create_ticket')</h2>
            <p class="text-gray-600 dark:text-gray-400">@lang('general.enter_ticket_info')</p>
        </div>

        <div class="mt-4 md:mt-0">
            <button onclick="window.history.back()"
                class="flex items-center px-4 py-2 text-sm font-medium rounded-lg bg-gray-200 text-gray-700 hover:bg-gray-300 shadow-sm dark:bg-gray-700 dark:text-white dark:hover:bg-gray-600">
                @lang('general.return')
            </button>
        </div>
    </div>

    <form action="{{ route('admin.tickets.store') }}" method="post" enctype="multipart/form-data"
        class="bg-white py-6 space-y-4 dark:bg-gray-800 rounded-xl shadow-md dark:shadow-gray-700 overflow-hidden border border-gray-200 dark:border-gray-700">
        @csrf

        @if(session('success'))
            <x-alert type="success" message="{{ session('success') }}"></x-alert>
        @elseif(session('error'))
            <x-alert type="error" message="{{ session('error') }}"></x-alert>
        @endif

        <div class="px-6 border-b border-gray-200 dark:border-gray-700">
            <h3 class="font-bold text-lg mb-4 relative pb-4 before:absolute before:start-0 before:bottom-0 before:size-2 before:rounded-full before:bg-primary after:absolute after:w-40 after:h-2 after:bottom-0 after:start-4 after:bg-primary after:rounded-lg">
                @lang('general.ticket_info')
            </h3>
        </div>

        <div class="px-6 grid grid-cols-1 md:grid-cols-2 gap-6">

            {{-- انتخاب کاربر (برای ساخت توسط Admin) --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">@lang('general.User')</label>
                <select name="user_id"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    <option value="">@lang('general.select_user')</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ (string)old('user_id') === (string)$user->id ? 'selected' : '' }}>
                            {{ $user->FullName }} ({{ $user->id }})
                        </option>
                    @endforeach
                </select>
                @error('user_id') <x-alert type="error" message="{{ $message }}"></x-alert> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">@lang('general.Department')</label>
                <select name="department_id"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    @foreach($departments as $department)
                        <option value="{{ $department->id }}" {{ (string)old('department_id') === (string)$department->id ? 'selected' : '' }}>
                            {{ $department->name }}
                        </option>
                    @endforeach
                </select>
                @error('department_id') <x-alert type="error" message="{{ $message }}"></x-alert> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">@lang('general.title')</label>
                <input name="title" type="text" value="{{ old('title') }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                @error('title') <x-alert type="error" message="{{ $message }}"></x-alert> @enderror
            </div>

            {{-- <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">@lang('general.Priority')</label>
                <select name="priority"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    <option value="1" {{ old('priority') == 1 ? 'selected' : '' }}>@lang('general.Low')</option>
                    <option value="2" {{ old('priority', 2) == 2 ? 'selected' : '' }}>@lang('general.Medium')</option>
                    <option value="3" {{ old('priority') == 3 ? 'selected' : '' }}>@lang('general.High')</option>
                </select>
                @error('priority') <x-alert type="error" message="{{ $message }}"></x-alert> @enderror
            </div> --}}

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">@lang('general.Description')</label>
                <textarea name="description" rows="5"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">{{ old('description') }}</textarea>
                @error('description') <x-alert type="error" message="{{ $message }}"></x-alert> @enderror
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">@lang('general.attachment')</label>
                <input type="file" name="files[]" multiple
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                @error('files.*') <x-alert type="error" message="{{ $message }}"></x-alert> @enderror
            </div>

        </div>

        <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 flex justify-end">
            <button type="submit"
                class="px-4 py-2 text-sm font-medium rounded-lg bg-primary-600 text-white hover:bg-primary-500 shadow-sm dark:bg-primary-500 dark:hover:bg-primary-600">
                @lang('general.save')
            </button>
        </div>

    </form>
</main>
@endsection
@push('scripts')
<script src="{{ asset('assets/js/dependencies/app.js') }}"></script>
@endpush
