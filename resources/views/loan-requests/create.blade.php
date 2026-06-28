@extends('layouts.app')

@section('title', 'Ajukan Peminjaman Barang')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Header -->
    <div class="flex items-center space-x-3">
        <a href="{{ route('panitia.catalog') }}" class="p-2 bg-white hover:bg-slate-50 border border-slate-200 text-slate-500 hover:text-slate-800 rounded-xl transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
        </a>
        <div>
            <h2 class="text-xl font-bold text-slate-800">Form Pengajuan Peminjaman</h2>
            <p class="text-sm text-slate-500">Ajukan peminjaman barang koleksi museum untuk pameran luar area museum.</p>
        </div>
    </div>

    <!-- Form & Item Details Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        
        <!-- Pre-selected Item Details -->
        <x-card class="bg-white md:col-span-1 p-5 h-fit flex flex-col space-y-4">
            <h3 class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Barang Dipilih</h3>
            <div class="relative bg-slate-50 aspect-video rounded-xl overflow-hidden border border-slate-100">
                @if ($museumItem->foto)
                    <img src="{{ asset('storage/' . $museumItem->foto) }}" alt="{{ $museumItem->nama_barang }}" 
                         class="w-full h-full object-cover">
                @else
                    <div class="flex items-center justify-center w-full h-full text-slate-400 bg-slate-100">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                @endif
            </div>
            
            <div class="space-y-1">
                <span class="text-xs font-mono text-slate-400 bg-slate-50 border border-slate-150 px-2 py-0.5 rounded">{{ $museumItem->kode_barang }}</span>
                <h4 class="font-bold text-slate-800 text-sm mt-2">{{ $museumItem->nama_barang }}</h4>
                <p class="text-xs text-slate-500">{{ $museumItem->kategori }} &bull; {{ $museumItem->asal }}</p>
                <p class="text-xs text-slate-400 mt-1">Tahun: {{ $museumItem->tahun }}</p>
            </div>
        </x-card>

        <!-- Form Card -->
        <x-card class="bg-white md:col-span-2">
            <form method="POST" action="{{ route('panitia.loan-requests.store') }}" class="space-y-6">
                @csrf
                
                <!-- Hidden Input for Museum Item ID -->
                <input type="hidden" name="museum_item_id" value="{{ $museumItem->id }}">

                <!-- Nama Acara -->
                <div>
                    <label for="nama_acara" class="block text-sm font-semibold text-slate-700 mb-2">Nama Acara Pameran <span class="text-rose-500">*</span></label>
                    <input type="text" name="nama_acara" id="nama_acara" value="{{ old('nama_acara') }}" placeholder="Contoh: Pameran Budaya Nusantara 2026"
                           class="w-full px-4 py-2.5 text-sm bg-slate-50 border @error('nama_acara') border-rose-500 focus:ring-rose-500 @else border-slate-200 focus:ring-blue-500 @enderror rounded-xl focus:outline-none focus:ring-2 focus:border-transparent transition-all">
                    @error('nama_acara')
                        <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Lokasi Pameran -->
                <div>
                    <label for="lokasi" class="block text-sm font-semibold text-slate-700 mb-2">Lokasi Pameran <span class="text-rose-500">*</span></label>
                    <input type="text" name="lokasi" id="lokasi" value="{{ old('lokasi') }}" placeholder="Contoh: Gedung Merdeka Bandung"
                           class="w-full px-4 py-2.5 text-sm bg-slate-50 border @error('lokasi') border-rose-500 focus:ring-rose-500 @else border-slate-200 focus:ring-blue-500 @enderror rounded-xl focus:outline-none focus:ring-2 focus:border-transparent transition-all">
                    @error('lokasi')
                        <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tanggal Mulai & Tanggal Selesai -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <!-- Tanggal Mulai -->
                    <div>
                        <label for="tanggal_mulai" class="block text-sm font-semibold text-slate-700 mb-2">Tanggal Mulai <span class="text-rose-500">*</span></label>
                        <input type="date" name="tanggal_mulai" id="tanggal_mulai" value="{{ old('tanggal_mulai') }}"
                               class="w-full px-4 py-2.5 text-sm bg-slate-50 border @error('tanggal_mulai') border-rose-500 focus:ring-rose-500 @else border-slate-200 focus:ring-blue-500 @enderror rounded-xl focus:outline-none focus:ring-2 focus:border-transparent transition-all">
                        @error('tanggal_mulai')
                            <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tanggal Selesai -->
                    <div>
                        <label for="tanggal_selesai" class="block text-sm font-semibold text-slate-700 mb-2">Tanggal Selesai <span class="text-rose-500">*</span></label>
                        <input type="date" name="tanggal_selesai" id="tanggal_selesai" value="{{ old('tanggal_selesai') }}"
                               class="w-full px-4 py-2.5 text-sm bg-slate-50 border @error('tanggal_selesai') border-rose-500 focus:ring-rose-500 @else border-slate-200 focus:ring-blue-500 @enderror rounded-xl focus:outline-none focus:ring-2 focus:border-transparent transition-all">
                        @error('tanggal_selesai')
                            <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex items-center justify-end space-x-3 border-t border-slate-100 pt-6">
                    <x-button href="{{ route('panitia.catalog') }}" variant="secondary">
                        Batal
                    </x-button>
                    <x-button type="submit" variant="primary">
                        Kirim Pengajuan
                    </x-button>
                </div>
            </form>
        </x-card>
    </div>
</div>
@endsection
