@extends('layouts.app')

@section('title', 'Detail Barang Museum')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div class="flex items-center space-x-3">
            <a href="{{ url()->previous() ?: route('admin.museum-items.index') }}" class="p-2 bg-white hover:bg-slate-50 border border-slate-200 text-slate-500 hover:text-slate-800 rounded-xl transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <div>
                <h2 class="text-xl font-bold text-slate-800">Detail Koleksi</h2>
                <p class="text-sm text-slate-500">Lihat data lengkap dan riwayat peminjaman barang ini.</p>
            </div>
        </div>
        
        @if (auth()->user()->isAdmin())
            <x-button href="{{ route('admin.museum-items.edit', $museumItem) }}" variant="warning">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                </svg>
                Edit Barang
            </x-button>
        @endif
    </div>

    <!-- Info Section -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Photo Card -->
        <x-card class="bg-white md:col-span-1 flex flex-col items-center justify-center p-6 h-fit">
            @if ($museumItem->foto)
                <img src="{{ asset('storage/' . $museumItem->foto) }}" alt="{{ $museumItem->nama_barang }}" 
                     class="w-full aspect-square rounded-2xl object-cover border border-slate-100 shadow-sm">
            @else
                <div class="flex flex-col items-center justify-center w-full aspect-square bg-slate-50 text-slate-400 rounded-2xl border border-slate-100 p-8">
                    <svg class="w-16 h-16 mb-3 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <span class="text-xs text-slate-400">Tidak ada foto</span>
                </div>
            @endif
            <div class="mt-4 w-full text-center">
                <span class="text-xs font-mono text-slate-400 bg-slate-50 px-3 py-1 rounded-full border border-slate-150">{{ $museumItem->kode_barang }}</span>
            </div>
        </x-card>

        <!-- Details Card -->
        <x-card class="bg-white md:col-span-2 space-y-6">
            <div>
                <h3 class="text-2xl font-extrabold text-slate-800">{{ $museumItem->nama_barang }}</h3>
                <p class="text-sm font-medium text-blue-600 mt-1">{{ $museumItem->kategori }}</p>
            </div>

            <div class="grid grid-cols-2 gap-4 border-y border-slate-100 py-4">
                <div>
                    <span class="text-xs text-slate-400 font-semibold uppercase tracking-wider block">Asal Daerah</span>
                    <span class="text-slate-700 text-sm font-bold mt-1 block">{{ $museumItem->asal }}</span>
                </div>
                <div>
                    <span class="text-xs text-slate-400 font-semibold uppercase tracking-wider block">Tahun Pembuatan</span>
                    <span class="text-slate-700 text-sm font-bold mt-1 block">{{ $museumItem->tahun }}</span>
                </div>
            </div>

            <div>
                <span class="text-xs text-slate-400 font-semibold uppercase tracking-wider block mb-2">Status Saat Ini</span>
                <x-badge :status="$museumItem->status" />
            </div>

            <div>
                <span class="text-xs text-slate-400 font-semibold uppercase tracking-wider block mb-2">Deskripsi Lengkap</span>
                <p class="text-slate-650 text-sm leading-relaxed">
                    {{ $museumItem->deskripsi ?: 'Tidak ada deskripsi tambahan mengenai koleksi barang ini.' }}
                </p>
            </div>
        </x-card>
    </div>

    <!-- Loan History Card -->
    <x-card class="bg-white">
        <h3 class="text-lg font-bold text-slate-800 mb-4">Riwayat Pengajuan Peminjaman</h3>
        <div class="w-full overflow-x-auto rounded-xl border border-slate-100">
            <table class="w-full text-sm text-left text-slate-500 border-collapse">
                <thead class="text-xs uppercase bg-slate-50 text-slate-400 border-b border-slate-100">
                    <tr>
                        <th class="px-6 py-3 font-semibold">Nama Acara</th>
                        <th class="px-6 py-3 font-semibold">Lokasi</th>
                        <th class="px-6 py-3 font-semibold">Tanggal Kegiatan</th>
                        <th class="px-6 py-3 font-semibold">Diajukan Oleh</th>
                        <th class="px-6 py-3 font-semibold">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($museumItem->loanRequests()->latest()->get() as $request)
                        <tr>
                            <td class="px-6 py-4 font-bold text-slate-800">{{ $request->nama_acara }}</td>
                            <td class="px-6 py-4 text-slate-600">{{ $request->lokasi }}</td>
                            <td class="px-6 py-4 text-slate-500">
                                {{ $request->tanggal_mulai->format('d M Y') }} s/d {{ $request->tanggal_selesai->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4 text-slate-600">{{ $request->user->name }}</td>
                            <td class="px-6 py-4"><x-badge :status="$request->status" /></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-slate-400">
                                Belum ada riwayat pengajuan peminjaman untuk barang ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </x-card>
</div>
@endsection
