@extends('layouts.app')

@section('title', 'Riwayat Pengajuan Peminjaman')

@section('content')
<div class="space-y-6">
    <!-- Header Page -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-4 sm:space-y-0">
        <div>
            <h2 class="text-xl font-bold text-slate-800">Riwayat Pengajuan Anda</h2>
            <p class="text-sm text-slate-500">Pantau dan kelola seluruh berkas pengajuan peminjaman barang Anda.</p>
        </div>
        <x-button href="{{ route('panitia.catalog') }}" variant="primary">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
            Ajukan Baru
        </x-button>
    </div>

    <!-- Table List -->
    <x-card class="p-0 overflow-hidden bg-white border border-slate-100 rounded-2xl shadow-sm">
        <div class="w-full overflow-x-auto">
            <table class="w-full text-sm text-left text-slate-500 border-collapse">
                <thead class="text-xs uppercase bg-slate-50 text-slate-400 border-b border-slate-100">
                    <tr>
                        <th class="px-6 py-4 font-semibold">Barang Museum</th>
                        <th class="px-6 py-4 font-semibold">Nama Acara</th>
                        <th class="px-6 py-4 font-semibold">Lokasi</th>
                        <th class="px-6 py-4 font-semibold">Tanggal Kegiatan</th>
                        <th class="px-6 py-4 font-semibold">Status</th>
                        <th class="px-6 py-4 font-semibold">Catatan Verifikator</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($requests as $req)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <!-- Barang -->
                            <td class="px-6 py-4">
                                <a href="{{ route('admin.museum-items.show', $req->museumItem) }}" class="font-bold text-slate-800 hover:text-blue-600 transition-colors block">
                                    {{ $req->museumItem->nama_barang }}
                                </a>
                                <span class="text-xs font-mono text-slate-400 mt-0.5 block">{{ $req->museumItem->kode_barang }}</span>
                            </td>
                            <!-- Nama Acara -->
                            <td class="px-6 py-4 text-slate-700">
                                {{ $req->nama_acara }}
                            </td>
                            <!-- Lokasi -->
                            <td class="px-6 py-4 text-slate-650">
                                {{ $req->lokasi }}
                            </td>
                            <!-- Tanggal Kegiatan -->
                            <td class="px-6 py-4 whitespace-nowrap text-slate-600">
                                <div class="text-sm font-semibold">{{ $req->tanggal_mulai->format('d M Y') }}</div>
                                <div class="text-xs text-slate-400">s/d {{ $req->tanggal_selesai->format('d M Y') }}</div>
                            </td>
                            <!-- Status -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <x-badge :status="$req->status" />
                            </td>
                            <!-- Catatan -->
                            <td class="px-6 py-4 text-xs text-slate-500 max-w-xs truncate" title="{{ $req->catatan }}">
                                {{ $req->catatan ?: '-' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-slate-400">
                                <svg class="w-12 h-12 mx-auto text-slate-350 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class="text-sm font-semibold">Belum ada pengajuan peminjaman barang.</span>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <!-- Paginate Links -->
        {{ $requests->links('components.pagination') }}
    </x-card>
</div>
@endsection
