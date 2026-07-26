@extends('admin.layout.master')

@section('admin-title')
@lang('general.Arya Gostaran Management Panel') / @lang('general.email_provider_settings')
@endsection

@section('admin-content')
<main class="flex-1 overflow-y-auto p-6 bg-gray-50 dark:bg-gray-900">

    <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">@lang('general.email_provider_settings')</h2>
            <p class="text-gray-600 dark:text-gray-400">@lang('general.manage_email_provider_settings')</p>
        </div>

        <div class="mt-4 md:mt-0">
            <button onclick="window.history.back()"
                class="flex items-center px-4 py-2 text-sm font-medium rounded-lg bg-gray-200 text-gray-700 hover:bg-gray-300 shadow-sm dark:bg-gray-700 dark:text-white dark:hover:bg-gray-600">
                @lang('general.return')
            </button>
        </div>
    </div>

    <form action="{{ route('admin.setting.email.update') }}" method="post"
        class="bg-white py-6 space-y-4 dark:bg-gray-800 rounded-xl shadow-md dark:shadow-gray-700 overflow-hidden border border-gray-200 dark:border-gray-700">
        @csrf
        @method('PUT')

        @if(session('success'))
            <x-alert type="success" message="{{ session('success') }}"></x-alert>
        @elseif(session('error'))
            <x-alert type="error" message="{{ session('error') }}"></x-alert>
        @endif

        <div class="px-6 border-b border-gray-200 dark:border-gray-700">
            <h3 class="font-bold text-lg mb-4 relative pb-4 before:absolute before:start-0 before:bottom-0 before:size-2 before:rounded-full before:bg-primary after:absolute after:w-40 after:h-2 after:bottom-0 after:start-4 after:bg-primary after:rounded-lg">
                @lang('general.email_provider_settings')
            </h3>
        </div>

        <div class="px-6 grid grid-cols-1 md:grid-cols-2 gap-6">

            {{-- Provider --}}
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                    @lang('general.email_provider') <span class="text-red-500">*</span>
                </label>

                <select name="email_provider" id="email_provider"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    @foreach($providers as $key => $provider)
                        <option value="{{ $key }}" {{ old('email_provider', $activeProvider) === $key ? 'selected' : '' }}>
                            {{ $provider['title'] }}
                        </option>
                    @endforeach
                </select>

                @error('email_provider')
                    <x-alert type="error" message="{{ $message }}"></x-alert>
                @enderror
            </div>

            {{-- Fields --}}
            @php
                $selected = old('email_provider', $activeProvider);
                $providerFields = $providers[$selected]['fields'] ?? [];
            @endphp

            @foreach($providerFields as $fieldKey => $meta)
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        {{ $meta['label'] }}
                        @if($meta['required'] ?? false) <span class="text-red-500">*</span> @endif
                    </label>

                    <input
                        type="{{ $meta['type'] ?? 'text' }}"
                        name="fields[{{ $fieldKey }}]"
                        value="{{ old("fields.$fieldKey", $values[$selected][$fieldKey] ?? '') }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary dark:bg-gray-700 dark:border-gray-600 dark:text-white">

                    @error("fields.$fieldKey")
                        <x-alert type="error" message="{{ $message }}"></x-alert>
                    @enderror
                </div>
            @endforeach

        </div>

        <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 flex justify-end space-x-4">
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

<script>
    // برای اینکه با تغییر provider فیلدها هم تغییر کنه:
    // ساده‌ترین حالت: رفرش با query
    document.getElementById('email_provider')?.addEventListener('change', function () {
        const url = new URL(window.location.href);
        url.searchParams.set('email_provider', this.value);
        window.location.href = url.toString();
    });
</script>
@endpush
