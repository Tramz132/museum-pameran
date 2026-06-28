@props([
    'type' => 'success',
    'message' => ''
])

@php
    $styles = match ($type) {
        'success' => 'bg-emerald-50 text-emerald-800 border-emerald-200 focus:ring-emerald-500',
        'danger' => 'bg-rose-50 text-rose-800 border-rose-200 focus:ring-rose-500',
        'warning' => 'bg-amber-50 text-amber-800 border-amber-200 focus:ring-amber-500',
        'info' => 'bg-blue-50 text-blue-800 border-blue-200 focus:ring-blue-500',
        default => 'bg-slate-50 text-slate-800 border-slate-200 focus:ring-slate-500',
    };
@endphp

<div class="flex items-start p-4 mb-6 border rounded-xl transition-all duration-300 {{ $styles }}" role="alert">
    <div class="flex-shrink-0">
        @if ($type === 'success')
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        @elseif ($type === 'danger')
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        @elseif ($type === 'warning')
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
            </svg>
        @else
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        @endif
    </div>
    <div class="flex-1 text-sm font-medium">
        {{ $message ?: $slot }}
    </div>
</div>
