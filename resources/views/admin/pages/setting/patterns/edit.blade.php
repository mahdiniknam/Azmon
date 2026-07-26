@extends('admin.layout.master')

@section('admin-title')
@lang('general.Arya Gostaran Management Panel') / {{ $title }}
@endsection

@section('admin-content')
<main class="flex-1 overflow-y-auto p-6 bg-gray-50 dark:bg-gray-900">

    <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $title }}</h2>
            <p class="text-gray-600 dark:text-gray-400">@lang('general.only_pattern_value_editable')</p>
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

    <form method="post"
          action="{{ $type === \App\Models\PatternOption::TYPE_SMS
                ? route('admin.setting.sms.patterns.update')
                : route('admin.setting.email.patterns.update') }}"
          class="bg-white py-6 space-y-4 dark:bg-gray-800 rounded-xl shadow-md dark:shadow-gray-700 overflow-hidden border border-gray-200 dark:border-gray-700">
        @csrf
        @method('PUT')

        <input type="hidden" name="section" value="{{ $section }}">

        @if(session('success'))
            <x-alert type="success" message="{{ session('success') }}"></x-alert>
        @elseif(session('error'))
            <x-alert type="error" message="{{ session('error') }}"></x-alert>
        @endif

        <div class="px-6 border-b border-gray-200 dark:border-gray-700">
            <h3 class="font-bold text-lg mb-4 relative pb-4 before:absolute before:start-0 before:bottom-0 before:size-2 before:rounded-full before:bg-primary after:absolute after:w-40 after:h-2 after:bottom-0 after:start-4 after:bg-primary after:rounded-lg">
                @lang('general.patterns_list')
            </h3>

            <div class="pb-4 -mt-2 text-sm text-gray-600 dark:text-gray-400">
                @lang('general.current_locale'): <span class="font-bold">{{ app()->getLocale() }}</span>
            </div>
        </div>

        {{-- ✅ 2 per row --}}
        <div class="px-6 grid grid-cols-1 md:grid-cols-2 gap-6">

            @foreach($patterns as $p)
                <div class="rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700 overflow-hidden">

                    {{-- Header of Pattern Box --}}
                    <div class="px-4 py-3 border-b border-gray-200 dark:border-gray-700 flex items-start justify-between gap-3">
                        <div class="min-w-0">
                            <p class="text-sm font-bold text-gray-900 dark:text-white break-words">
                                {{ $p->key }}
                            </p>

                            @if($p->description)
                                <p class="text-xs text-gray-600 dark:text-gray-400 mt-1">
                                    @lang($p->description)
                                </p>
                            @endif
                        </div>

                        <span class="text-xs px-2 py-1 rounded-lg bg-white text-gray-700 border border-gray-200
                                     dark:bg-gray-700 dark:text-white dark:border-gray-600">
                            {{ app()->getLocale() }}
                        </span>
                    </div>

                    {{-- Body --}}
                    <div class="p-2 space-y-1">
                        <div>
                            <textarea
                                name="values[{{ $p->key }}]"
                                rows="2"
                                placeholder="@lang('general.pattern_value_placeholder')"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary dark:bg-gray-700 dark:border-gray-600 dark:text-white
                                       @error('values.'.$p->key) is-invalid @enderror"
                            >{{ old("values.$p->key", $p->value) }}</textarea>

                            @error("values.$p->key")
                                <x-alert type="error" message="{{ $message }}"></x-alert>
                            @enderror
                        </div>

                        <div class="text-xs text-gray-600 dark:text-gray-400 leading-relaxed">
                            <span class="font-bold">@lang('general.pattern_hint')</span>
                            @lang('general.pattern_hint_text')
                        </div>

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
@endpush
