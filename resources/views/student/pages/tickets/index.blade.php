@extends('admin.layout.master')

@section('admin-title')
@lang('general.Arya Gostaran Management Panel') / @lang('general.tickets_list')
@endsection

@section('admin-content')
<main class="flex-1 overflow-y-auto p-6 bg-gray-50 dark:bg-gray-900">

    <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">@lang('general.ticket_management')</h2>
            <p class="text-gray-600 dark:text-gray-400">@lang('general.tickets_list')</p>
        </div>

        <div class="mt-4 md:mt-0">
            <a href="{{ route('admin.tickets.create') }}"
               class="flex items-center px-4 py-2 text-sm font-medium rounded-lg bg-primary-600 text-white hover:bg-primary-500 shadow-sm dark:bg-primary-500 dark:hover:bg-primary-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 me-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                </svg>
                @lang('general.create_ticket')
            </a>
        </div>
    </div>

    @if(session('success'))
        <x-alert type="success" message="{{ session('success') }}"></x-alert>
    @elseif(session('error'))
        <x-alert type="error" message="{{ session('error') }}"></x-alert>
    @endif

    <div class="bg-white py-6 space-y-4 dark:bg-gray-800 rounded-xl shadow-md dark:shadow-gray-700 overflow-hidden border border-gray-200 dark:border-gray-700">
        <div class="px-6 pb-2 border-b border-gray-200 flex-wrap dark:border-gray-700 flex items-center justify-between">
            <h3 class="font-bold text-lg mb-4 relative pb-4 before:absolute before:start-0 before:bottom-0 before:size-2 before:rounded-full before:bg-primary after:absolute after:w-40 after:h-2 after:bottom-0 after:start-4 after:bg-primary after:rounded-lg">
                @lang('general.tickets_list')
            </h3>
            @include('admin.pages.filter',['filters' => $filters,'back'=>route('admin.tickets.index')])
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-start">
                <thead class="bg-gray-50 dark:bg-gray-700">
                <tr>
                    <th class="px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">@lang('general.id')</th>

                    <th class="px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        @lang('general.user')
                    </th>

                    <th class="px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">@lang('general.title')</th>
                    <th class="px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">@lang('general.department')</th>
                    <th class="px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">@lang('general.status')</th>

                    <th class="px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        @lang('general.last_update')
                    </th>

                    <th class="px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">@lang('general.operations')</th>
                </tr>
                </thead>

                <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                @forelse($tickets as $ticket)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                            {{ $ticket->id }}
                        </td>

                        {{-- User --}}
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            @if($ticket->user)
                                <a href="{{ route('admin.users.show', $ticket->user_id) }}"
                                   class="font-medium text-primary-600 hover:text-primary-700 dark:text-primary-400 dark:hover:text-primary-300">
                                    #{{ $ticket->user_id }} - {{ $ticket->user->name ?? '-' }}
                                </a>
                            @else
                                <span class="text-gray-500 dark:text-gray-400">-</span>
                            @endif
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-200">
                            {{ \Illuminate\Support\Str::limit($ticket->title, 40) }}
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                            {{ $ticket->department?->name ?? '-' }}
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                            @lang('general.ticket_status.' . $ticket->status)
                        </td>

                        {{-- Updated At --}}
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                            {{ ($ticket->updated_at_jalali) }}
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <a href="{{ route('admin.tickets.chat', $ticket) }}"
                               class="text-primary-600 hover:text-primary-700 dark:text-primary-400 dark:hover:text-primary-300">
                                @lang('general.view')
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-6 text-center text-sm text-gray-500 dark:text-gray-400">
                            @lang('general.no_records_found')
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-6 pt-4 border-t border-gray-200 dark:border-gray-700">
            {{ $tickets->links() }}
        </div>
    </div>

</main>
@endsection

@push('scripts')
<script src="{{ asset('assets/js/dependencies/app.js') }}"></script>
<script src="{{ asset('assets/js/plugin/date-picker/datePicker.js') }}"></script>
@endpush
