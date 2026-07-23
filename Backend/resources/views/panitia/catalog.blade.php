@extends('layouts.app')

@section('title', 'Katalog Koleksi Museum')

@section('content')
<div class="space-y-6">
    <!-- Header Page -->
    <div>
        <h2 class="text-xl font-bold text-slate-800">Katalog Koleksi Pameran</h2>
        <p class="text-sm text-slate-500">Pilih koleksi museum yang berstatus Tersedia untuk diajukan dalam pameran eksternal Anda.</p>
    </div>

    <!-- Search & Filter Card -->
    <x-card class="bg-white">
        <form method="GET" action="{{ route('panitia.catalog') }}" class="flex flex-col md:flex-row md:items-end gap-4">
            <!-- Search Input -->
            <div class="flex-1">
                <label for="search" class="block text-xs font-semibold text-slate-500 mb-2">CARI KOLEKSI</label>
                <div class="relative">
                    <input type="text" name="search" id="search" value="{{ request('search') }}"
                           placeholder="Cari berdasarkan nama, kategori, asal..."
                           class="w-full pl-10 pr-4 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Status Filter -->
            <div class="w-full md:w-48">
                <label for="status" class="block text-xs font-semibold text-slate-500 mb-2">FILTER STATUS</label>
                <select name="status" id="status"
                        class="w-full px-3 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                    <option value="">Semua Status</option>
                    <option value="Tersedia" {{ request('status') === 'Tersedia' ? 'selected' : '' }}>Tersedia</option>
                    <option value="Dipinjam" {{ request('status') === 'Dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                    <option value="Perbaikan" {{ request('status') === 'Perbaikan' ? 'selected' : '' }}>Perbaikan</option>
                </select>
            </div>

            <!-- Action Buttons -->
            <div class="flex gap-2 w-full md:w-auto">
                <x-button type="submit" variant="primary" class="w-full md:w-auto">
                    Filter
                </x-button>
                @if (request()->filled('search') || request()->filled('status'))
                    <x-button href="{{ route('panitia.catalog') }}" variant="secondary" class="w-full md:w-auto">
                        Reset
                    </x-button>
                @endif
            </div>
        </form>
    </x-card>

    <!-- Grid Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        @forelse ($items as $item)
            <div class="flex flex-col bg-white border border-slate-100 rounded-2xl shadow-sm hover:shadow-md transition-all duration-300 overflow-hidden group">
                <!-- Foto -->
                <div class="relative bg-slate-50 aspect-video overflow-hidden">
                    @if ($item->foto)
                        <img src="{{ asset('storage/' . $item->foto) }}" alt="{{ $item->nama_barang }}" 
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    @else
                        <div class="flex items-center justify-center w-full h-full text-slate-400 bg-slate-100 border-b border-slate-100">
                            <svg class="w-10 h-10 text-slate-350" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                    @endif
                    <!-- Status Overlay Badge -->
                    <div class="absolute top-3 right-3">
                        <x-badge :status="$item->status" />
                    </div>
                </div>

                <!-- Card Content -->
                <div class="flex-1 p-5 flex flex-col justify-between space-y-4">
                    <div class="space-y-2">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-semibold text-blue-600 uppercase tracking-wider">{{ $item->kategori }}</span>
                            <span class="text-xs font-mono text-slate-400 bg-slate-50 px-2.5 py-0.5 rounded border border-slate-150">{{ $item->kode_barang }}</span>
                        </div>
                        <h3 class="font-bold text-slate-800 text-base line-clamp-1 group-hover:text-blue-600 transition-colors" title="{{ $item->nama_barang }}">
                            {{ $item->nama_barang }}
                        </h3>
                        <div class="flex items-center text-xs text-slate-400 space-x-1.5">
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            <span>{{ $item->asal }} ({{ $item->tahun }})</span>
                        </div>
                    </div>

                    <!-- Button Action -->
                    <div>
                        @if ($item->status === 'Tersedia')
                            <x-button href="{{ route('panitia.loan-requests.create', $item) }}" variant="primary" class="w-full">
                                Ajukan Peminjaman
                            </x-button>
                        @else
                            <x-button variant="secondary" class="w-full" disabled="true">
                                Tidak Tersedia
                            </x-button>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full bg-white border border-slate-100 rounded-2xl p-12 text-center text-slate-400">
                <svg class="w-12 h-12 mx-auto text-slate-350 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                </svg>
                <span class="text-sm font-semibold">Tidak ada barang pameran ditemukan.</span>
            </div>
        @endforelse
    </div>

    <!-- Paginate Links -->
    <div class="mt-6">
        {{ $items->links('components.pagination') }}
    </div>
</div>
@endsection
