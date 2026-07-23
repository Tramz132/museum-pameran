@props([
    'title' => '',
    'value' => '0',
    'color' => 'blue'
])

@php
    $colorClasses = match ($color) {
        'blue' => [
            'icon' => 'text-blue-600 bg-blue-50 border-blue-100',
            'value' => 'text-slate-900',
        ],
        'emerald' => [
            'icon' => 'text-emerald-600 bg-emerald-50 border-emerald-100',
            'value' => 'text-slate-900',
        ],
        'amber' => [
            'icon' => 'text-amber-600 bg-amber-50 border-amber-100',
            'value' => 'text-slate-900',
        ],
        'rose' => [
            'icon' => 'text-rose-600 bg-rose-50 border-rose-100',
            'value' => 'text-slate-900',
        ],
        'slate' => [
            'icon' => 'text-slate-600 bg-slate-50 border-slate-100',
            'value' => 'text-slate-900',
        ],
        default => [
            'icon' => 'text-blue-600 bg-blue-50 border-blue-100',
            'value' => 'text-slate-900',
        ],
    };
@endphp

<div class="flex items-center p-6 bg-white border border-slate-100 rounded-2xl shadow-sm hover:shadow-md transition-all duration-300">
    <div class="p-3 mr-4 border rounded-xl {{ $colorClasses['icon'] }}">
        @if ($attributes->has('icon'))
            {{-- We can pass custom icon class or just let it inject --}}
        @else
            {{ $icon ?? $slot }}
        @endif
    </div>
    <div>
        <p class="mb-1 text-sm font-medium text-slate-400 capitalize">{{ $title }}</p>
        <p class="text-2xl font-bold {{ $colorClasses['value'] }}">{{ $value }}</p>
    </div>
</div>
