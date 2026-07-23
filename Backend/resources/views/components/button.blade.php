@props([
    'variant' => 'primary',
    'type' => 'button',
    'disabled' => false
])

@php
    $baseStyles = 'inline-flex items-center justify-center px-4 py-2.5 text-sm font-semibold rounded-xl transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed';
    
    $variantStyles = match ($variant) {
        'primary' => 'bg-blue-600 hover:bg-blue-700 text-white focus:ring-blue-500 shadow-md shadow-blue-600/10',
        'secondary' => 'bg-white hover:bg-slate-50 text-slate-700 border border-slate-200 focus:ring-slate-500',
        'danger' => 'bg-rose-600 hover:bg-rose-700 text-white focus:ring-rose-500 shadow-md shadow-rose-600/10',
        'success' => 'bg-emerald-600 hover:bg-emerald-700 text-white focus:ring-emerald-500 shadow-md shadow-emerald-600/10',
        'warning' => 'bg-amber-600 hover:bg-amber-700 text-white focus:ring-amber-500 shadow-md shadow-amber-600/10',
        default => 'bg-blue-600 hover:bg-blue-700 text-white focus:ring-blue-500',
    };
@endphp

@if ($attributes->has('href'))
    <a {{ $attributes->merge(['class' => "$baseStyles $variantStyles"]) }}>
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $disabled ? 'disabled' : '' }} {{ $attributes->merge(['class' => "$baseStyles $variantStyles"]) }}>
        {{ $slot }}
    </button>
@endif
