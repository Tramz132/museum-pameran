@props([
    'status' => ''
])

@php
    $normalized = strtolower(trim($status));
    $styles = match ($normalized) {
        // Status barang
        'tersedia' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
        'dipinjam' => 'bg-blue-50 text-blue-700 border-blue-200',
        'perbaikan' => 'bg-amber-50 text-amber-700 border-amber-200',
        
        // Status pengajuan
        'pending' => 'bg-slate-100 text-slate-700 border-slate-200',
        'approved' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
        'rejected' => 'bg-rose-50 text-rose-700 border-rose-200',
        
        default => 'bg-slate-50 text-slate-600 border-slate-200',
    };
@endphp

<span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold border {{ $styles }}">
    {{ $status }}
</span>
