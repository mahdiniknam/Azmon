@extends('admin.layout.master')

@section('admin-title')
@lang('general.Arya Gostaran Management Panel') / @lang('general.ticket_chat')
@endsection

@section('admin-content')
<main class="flex-1 h-[100svh] overflow-hidden flex flex-col bg-gray-50 p-3 dark:bg-gray-900">

    {{-- Card Wrapper (Header + Messages) --}}
    <div class="flex-1 overflow-hidden bg-white rounded-xl dark:bg-gray-800 border border-gray-200 dark:border-gray-700 flex flex-col">

        {{-- Header ثابت --}}
        <div class="flex items-center p-4 border-b border-gray-200 dark:border-gray-700 flex-shrink-0">
            <div class="flex flex-col gap-1">
                <h3 class="font-bold text-gray-900 dark:text-white">
                    {{ $ticket->title }}
                </h3>

                <div class="flex flex-wrap items-center gap-2 text-sm text-gray-500 dark:text-gray-400">

                    <span>
                        #{{ $ticket->id }}
                    </span>

                    <span class="opacity-40">•</span>

                    <span>
                        @lang('general.department'): {{ $ticket->department?->name ?? '-' }}
                    </span>

                    <span class="opacity-40">•</span>

                    {{-- Status badge --}}
                    @php
                        $status = $ticket->status;
                        $statusClass = match($status) {
                            \App\Models\Ticket::STATUS_CLOSED => 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-300',
                            'answered' => 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-300',
                            'pending' => 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-300',
                            default => 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300',
                        };
                    @endphp

                    <span class="px-2 py-0.5 rounded-full text-xs font-medium {{ $statusClass }}">
                        @lang('general.ticket_status.' . $ticket->status)
                    </span>
                </div>

                {{-- User --}}
                <div class="text-sm text-gray-500 dark:text-gray-400">
                    @lang('general.user'):
                    <a href="{{ route('admin.users.show', $ticket->user) }}"
                       class="font-medium text-primary-600 hover:text-primary-700 dark:text-primary-400 dark:hover:text-primary-300">
                        {{ $ticket->user?->name ?? $ticket->user?->FullName ?? '-' }}
                        <span class="opacity-70">(ID: {{ $ticket->user_id ?? '-' }})</span>
                    </a>
                </div>
            </div>

            <div class="ms-auto flex items-center gap-2">
                @if($ticket->status !== \App\Models\Ticket::STATUS_CLOSED)
                    <form action="{{ route('admin.tickets.close', $ticket) }}" method="post">
                        @csrf
                        @method('PUT')
                        <button type="submit"
                                onclick="return confirm('@lang('general.are_you_sure')')"
                                class="px-3 py-2 text-sm font-medium rounded-lg bg-red-600 text-white hover:bg-red-700">
                            @lang('general.close_ticket')
                        </button>
                    </form>
                @endif
            </div>
        </div>

        {{-- Messages فقط این قسمت اسکرول میخوره --}}
        <div id="chat-scroll" class="flex-1 overflow-y-auto p-4 scroll-smooth">
            <div class="max-w-3xl mx-auto space-y-4">

                @foreach($messages as $message)
                    @php
                        $isAdmin = $message->from === \App\Models\TicketMessage::FROM_ADMIN;

                        // sender واقعی از morph user()
                        $sender = $message->user;

                        $senderName = $sender
                            ? ($sender->name ?? $sender->FullName ?? $sender->name ?? ('ID: ' . $sender->id))
                            : ($isAdmin ? __('general.admin') : __('general.user'));

                        $sentAt = $message->created_at_jalali
                            ? $message->created_at_jalali
                            : '-';
                    @endphp

                    <div class="flex items-start {{ $isAdmin ? '' : 'justify-end' }}">
                        <div class="max-w-[78%]">

                            <div class="
                                rounded-2xl p-4 shadow-sm
                                {{ $isAdmin
                                    ? 'bg-gray-100 text-gray-800 dark:bg-gray-700/80 dark:text-gray-100 border border-gray-200 dark:border-gray-600'
                                    : 'bg-gray-100 text-gray-800 dark:bg-gray-700/80 dark:text-gray-100 border border-gray-200 dark:border-gray-600'
                                }}
                            ">
                                <p class="text-sm leading-relaxed whitespace-pre-wrap">
                                    {{ $message->message }}
                                </p>

                                {{-- Attachments --}}
                                @if($message->files && $message->files->count())
                                    <div class="mt-3 space-y-2">
                                        @foreach($message->files as $file)
                                            <a href="{{ $file->url() }}"
                                               target="_blank"
                                               class="block rounded-lg p-2 border border-transparent
                                                      hover:border-gray-200 dark:hover:border-gray-600
                                                      hover:bg-white/70 dark:hover:bg-gray-800/60 transition">
                                                <div class="flex items-center gap-2">
                                                    <span class="text-primary-600">📎</span>
                                                    <div class="min-w-0">
                                                        <p class="text-sm font-medium truncate">
                                                            {{ $file->original_name ?? basename($file->path) }}
                                                        </p>
                                                        @if($file->size)
                                                            <p class="text-xs opacity-70">
                                                                {{ number_format($file->size / 1024, 2) }} KB
                                                            </p>
                                                        @endif
                                                    </div>
                                                </div>
                                            </a>
                                        @endforeach
                                    </div>
                                @endif

                                {{-- Sender + Date --}}
                                <div class="mt-3 pt-3 border-t border-black/5 dark:border-white/10">
                                    <div class="flex items-center justify-between text-xs opacity-80">
                                        <span class="font-medium">
                                            {{ $senderName }}
                                        </span>
                                        <span class="opacity-70">
                                            {{ $sentAt }}
                                        </span>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </div>

    {{-- Send message (همیشه پایین ثابت) --}}
    <form action="{{ route('admin.tickets.chat.send', $ticket) }}"
          method="post"
          enctype="multipart/form-data"
          class="flex-shrink-0 mt-3">
        @csrf

        <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl p-3">
            <div class="max-w-3xl mx-auto flex gap-3 items-end">

                {{-- Textarea + file --}}
                <div class="relative flex-1">

                    {{-- File button --}}
                    <div class="absolute left-3 bottom-3 z-10">
                        <label for="file-upload"
                               class="flex items-center justify-center w-12 h-12 rounded-lg
                                      bg-gray-100 hover:bg-gray-200 text-gray-600
                                      dark:bg-gray-700 dark:hover:bg-gray-600 dark:text-gray-200
                                      cursor-pointer transition">
                            📎
                        </label>
                        <input name="files[]" type="file" id="file-upload" class="hidden" multiple>
                    </div>

                    <textarea
                        name="message"
                        id="chat-message"
                        rows="1"
                        @if($ticket->status === \App\Models\Ticket::STATUS_CLOSED) disabled @endif
                        placeholder="@lang('general.write_your_message')"
                        class="w-full appearance-none dark:text-white rounded-3xl border border-gray-300 dark:border-gray-600
                               py-3 ps-16 pe-4 dark:placeholder-gray-400
                               focus:outline-none focus:ring-1 focus:ring-primary-500 focus:border-transparent
                               bg-white dark:bg-gray-700 shadow-sm"
                    >{{ old('message') }}</textarea>
                </div>

                {{-- Send button --}}
                @if($ticket->status !== \App\Models\Ticket::STATUS_CLOSED)
                    <button
                        type="submit"
                        class="px-5 h-12 bg-primary-600 text-white rounded-xl
                               hover:bg-primary-700
                               dark:bg-primary-500 dark:hover:bg-primary-600">
                        @lang('general.send')
                    </button>
                @endif
            </div>
        </div>
    </form>

</main>
@endsection

@push('scripts')
<script src="{{ asset('assets/js/dependencies/app.js') }}"></script>

<script>
    (function () {
        const textarea = document.getElementById('chat-message');
        const form = textarea?.closest('form');

        if (!textarea || !form) return;

        // Enter => submit, Shift+Enter => newline
        textarea.addEventListener('keydown', function (e) {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                if (this.disabled) return;
                if (this.value.trim() === '') return;
                form.submit();
            }
        });

        // scroll to bottom
        const chat = document.getElementById('chat-scroll');
        if (chat) {
            chat.scrollTop = chat.scrollHeight;
        }
    })();
</script>
@endpush

