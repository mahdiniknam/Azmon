@extends('admin.layout.master')

@section('admin-title')
@lang('general.Arya Gostaran Management Panel') / @lang('general.sms_setting')
@endsection

@section('admin-content')
<main class="flex-1 overflow-y-auto p-6 bg-gray-50 dark:bg-gray-900">

    <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">@lang('general.sms_setting')</h2>
            <p class="text-gray-600 dark:text-gray-400">@lang('general.manage_sms_settings')</p>
        </div>

        <div class="mt-4 md:mt-0">
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
    </div>

    <form action="{{ route('admin.setting.sms.update') }}" method="post"
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
                @lang('general.sms_provider_settings')
            </h3>
        </div>

        <div class="px-6 grid grid-cols-1 md:grid-cols-2 gap-6">

            {{-- Provider --}}
            <div>
                <label for="sms_provider" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                    @lang('general.sms_provider') <span class="text-red-500">*</span>
                </label>

                @php
                    $providerValue = old('sms_provider', $activeProvider ?? 'melipayamak');
                @endphp

                <select name="sms_provider" id="sms_provider"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary dark:bg-gray-700 dark:border-gray-600 dark:text-white @error('sms_provider') is-invalid @enderror">
                    @foreach($providers as $pKey => $p)
                        <option value="{{ $pKey }}" {{ $providerValue === $pKey ? 'selected' : '' }}>
                            {{ $p['title'] }}
                        </option>
                    @endforeach
                </select>

                @error('sms_provider')
                    <x-alert type="error" message="{{ $message }}"></x-alert>
                @enderror
            </div>

            {{-- Spacer --}}
            <div class="hidden md:block"></div>

            {{-- Provider Fields (Dynamic) --}}
            @foreach($providers as $pKey => $p)
                @php
                    $isActive = ($providerValue === $pKey);
                @endphp

                <div class="provider-box md:col-span-2 {{ $isActive ? '' : 'hidden' }}" data-provider="{{ $pKey }}">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @foreach($p['fields'] as $fieldKey => $meta)
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    {{ $meta['label'] }}
                                    @if(!empty($meta['required'])) <span class="text-red-500">*</span> @endif
                                </label>

                                <input
                                    name="fields[{{ $fieldKey }}]"
                                    type="{{ $meta['type'] ?? 'text' }}"
                                    value="{{ old('fields.'.$fieldKey, $values[$pKey][$fieldKey] ?? '') }}"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary dark:bg-gray-700 dark:border-gray-600 dark:text-white
                                    @error('fields.'.$fieldKey) is-invalid @enderror"
                                >

                                @error('fields.'.$fieldKey)
                                    <x-alert type="error" message="{{ $message }}"></x-alert>
                                @enderror
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach

        </div>

        <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 flex justify-end space-x-4">
            <button type="button" onclick="window.history.back()"
                class="px-4 py-2 text-sm font-medium rounded-lg bg-gray-200 text-gray-700 hover:bg-gray-300 shadow-sm dark:bg-gray-700 dark:text-white dark:hover:bg-gray-600">
                @lang('general.return')
            </button>

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
    (function () {
        const providerSelect = document.getElementById('sms_provider');
        const boxes = document.querySelectorAll('.provider-box');

        function toggleBoxes() {
            const v = providerSelect.value;
            boxes.forEach(b => {
                b.classList.toggle('hidden', b.dataset.provider !== v);
            });
        }

        providerSelect.addEventListener('change', toggleBoxes);
        toggleBoxes();
    })();
</script>
@endpush
