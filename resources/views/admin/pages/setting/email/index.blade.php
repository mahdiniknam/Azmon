@extends('admin.layout.master')

@section('admin-title')
@lang('general.Arya Gostaran Management Panel') / @lang('general.email_setting')
@endsection

@section('admin-content')
<main class="flex-1 overflow-y-auto p-6 bg-gray-50 dark:bg-gray-900">

    <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">@lang('general.email_setting')</h2>
            <p class="text-gray-600 dark:text-gray-400">@lang('general.manage_email_settings')</p>
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

    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-6 mb-6">
        @foreach($emailSettings as $item)
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md dark:shadow-gray-700 p-6 border border-gray-200 dark:border-gray-700">
                <a href="{{ $item['route'] }}" class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 dark:text-gray-400 text-sm">{{ $item['title'] }}</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $loop->index + 1 }}</p>
                    </div>
                    <div class="p-3 rounded-xl bg-primary-100 dark:bg-primary-900/30 text-primary-600 dark:text-primary-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-6" fill="none" viewBox="0 0 24 24"
                             stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15A2.25 2.25 0 0 1 2.25 17.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15A2.25 2.25 0 0 0 2.25 6.75m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0l-7.5-4.615A2.25 2.25 0 0 1 2.25 6.993V6.75"/>
                        </svg>
                    </div>
                </a>
            </div>
        @endforeach
    </div>

</main>
@endsection

@push('scripts')
<script src="{{ asset('assets/js/dependencies/app.js') }}"></script>
@endpush
