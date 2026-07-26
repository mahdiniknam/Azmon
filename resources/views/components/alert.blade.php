@php
$styles = [
    'success' => 'bg-green-100 text-green-800 border-green-300 dark:bg-green-600 dark:text-green-100 dark:border-green-700',
    'error'   => 'bg-red-100 text-red-800 border-red-300 dark:bg-red-600 dark:text-red-100 dark:border-red-700',
    'warning' => 'bg-yellow-100 text-yellow-800 border-yellow-300 dark:bg-yellow-600 dark:text-yellow-100 dark:border-yellow-700',
    'info'    => 'bg-blue-100 text-blue-800 border-blue-300 dark:bg-blue-600 dark:text-blue-100 dark:border-blue-700',
];
@endphp

@if($message)
<div class="mb-4 flex items-center gap-3 border rounded-lg px-4 py-2 {{ $styles[$type] }}">
    <div class="flex-1 text-sm font-medium">
        {{ $message }}
    </div>
    <button type="button" onclick="this.parentElement.remove()"
        class="text-lg leading-none opacity-60 hover:opacity-100">
        ×
    </button>
</div>
@endif
