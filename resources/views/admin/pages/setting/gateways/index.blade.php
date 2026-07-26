@extends('admin.layout.master')

@section('admin-title')
@lang('general.Arya Gostaran Management Panel') / @lang('general.gateways_setting')
@endsection

@section('admin-content')
<main class="flex-1 overflow-y-auto p-6 bg-gray-50 dark:bg-gray-900">

    <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">@lang('general.gateways_setting')</h2>
            <p class="text-gray-600 dark:text-gray-400">@lang('general.manage_gateways_settings')</p>
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

    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md dark:shadow-gray-700 overflow-hidden border border-gray-200 dark:border-gray-700">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h3 class="font-bold text-lg">@lang('general.gateways_list')</h3>
        </div>

        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach($gateways as $g)
                <div class="rbg-white dark:bg-gray-800 rounded-xl shadow-md dark:shadow-gray-700 p-6 border border-gray-200 dark:border-gray-700">
                    <div class="flex items-start justify-between gap-3">
                        <div>
                            <p class="text-lg font-bold text-gray-900 dark:text-white">
                                {{ $g->title }}
                            </p>
                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                @lang('general.driver'): <span class="font-medium">{{ $g->driver }}</span>
                            </p>
                        </div>

                        <span class="text-xs px-2 py-1 rounded-lg border
                            {{ $g->is_active ? 'bg-green-50 text-green-700 border-green-200 dark:bg-green-900/20 dark:text-green-300 dark:border-green-800'
                                             : 'bg-red-50 text-red-700 border-red-200 dark:bg-red-900/20 dark:text-red-300 dark:border-red-800' }}">
                            {{ $g->is_active ? __('general.active') : __('general.inactive') }}
                        </span>
                    </div>

                    <div class="mt-4 flex gap-3">
                        <a href="{{ route('admin.setting.gateways.edit', $g) }}"
                           class="px-4 py-2 text-sm font-medium rounded-lg bg-primary-600 text-white hover:bg-primary-500 shadow-sm dark:bg-primary-500 dark:hover:bg-primary-600">
                            @lang('general.edit')
                        </a>

                        <form action="{{ route('admin.setting.gateways.toggle', $g) }}" method="post">
                            @csrf
                            @method('PUT')
                            <button type="submit"
                                class="px-4 py-2 text-sm font-medium rounded-lg bg-gray-200 text-gray-700 hover:bg-gray-300 shadow-sm dark:bg-gray-700 dark:text-white dark:hover:bg-gray-600">
                                {{ $g->is_active ? __('general.deactivate') : __('general.activate') }}
                            </button>
                        </form>
                    </div>

                </div>
            @endforeach
        </div>
    </div>

</main>
@endsection
@push('scripts')
<script src="{{ asset('assets/js/dependencies/app.js') }}"></script>
@endpush

