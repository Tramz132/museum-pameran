@extends('layouts.app')

@section('title', 'Kelola Barang Museum')

@section('content')
<div class="space-y-6">
    <!-- Header Page -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-4 sm:space-y-0">
        <div>
            <h2 class="text-xl font-bold text-slate-800">Manajemen Koleksi Barang</h2>
            <p class="text-sm text-slate-500">Kelola informasi barang koleksi museum, status, dan unggah foto.</p>
        </div>
        <x-button href="{{ route('admin.museum-items.create') }}" variant="primary">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Tambah Barang
        </x-button>
    </div>

    <!-- Search & Filter Card -->
    <x-card class="bg-white">
        <form method="GET" action="{{ route('admin.museum-items.index') }}" class="flex flex-col md:flex-row md:items-end gap-4">
            <!-- Search Input -->
            <div class="flex-1">
                <label for="search" class="block text-xs font-semibold text-slate-500 mb-2">CARI BARANG</label>
                <div class="relative">
                    <input type="text" name="search" id="search" value="{{ request('search') }}"
                           placeholder="Cari berdasarkan nama, kode, kategori, asal..."
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
                    <x-button href="{{ route('admin.museum-items.index') }}" variant="secondary" class="w-full md:w-auto">
                        Reset
                    </x-button>
                @endif
            </div>
        </form>
    </x-card>

    <!-- Table List -->
    <x-card class="p-0 overflow-hidden bg-white border border-slate-100 rounded-2xl shadow-sm">
        <div class="w-full overflow-x-auto">
            <table class="w-full text-sm text-left text-slate-500 border-collapse">
                <thead class="text-xs uppercase bg-slate-50 text-slate-400 border-b border-slate-100">
                    <tr>
                        <th class="px-6 py-4 font-semibold">Foto</th>
                        <th class="px-6 py-4 font-semibold">Info Barang</th>
                        <th class="px-6 py-4 font-semibold">Kategori & Asal</th>
                        <th class="px-6 py-4 font-semibold">Tahun</th>
                        <th class="px-6 py-4 font-semibold">Status</th>
                        <th class="px-6 py-4 font-semibold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($items as $item)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <!-- Foto -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if ($item->foto)
                                    <img src="{{ asset('storage/' . $item->foto) }}" alt="{{ $item->nama_barang }}" 
                                         class="w-12 h-12 rounded-xl object-cover border border-slate-100 shadow-sm">
                                @else
                                    <div class="flex items-center justify-center w-12 h-12 bg-slate-100 text-slate-400 rounded-xl border border-slate-100">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                @endif
                            </td>
                            <!-- Info Barang -->
                            <td class="px-6 py-4">
                                <div class="font-bold text-slate-800">{{ $item->nama_barang }}</div>
                                <div class="text-xs font-mono text-slate-400 mt-0.5">{{ $item->kode_barang }}</div>
                            </td>
                            <!-- Kategori & Asal -->
                            <td class="px-6 py-4">
                                <div class="text-slate-700">{{ $item->kategori }}</div>
                                <div class="text-xs text-slate-400 mt-0.5">{{ $item->asal }}</div>
                            </td>
                            <!-- Tahun -->
                            <td class="px-6 py-4 whitespace-nowrap text-slate-600">
                                {{ $item->tahun }}
                            </td>
                            <!-- Status -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <x-badge :status="$item->status" />
                            </td>
                            <!-- Aksi -->
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex items-center justify-end space-x-2">
                                    <a href="{{ route('admin.museum-items.show', $item) }}" 
                                       class="p-2 rounded-xl text-slate-400 hover:text-blue-600 hover:bg-blue-50 transition-all duration-200"
                                       title="Lihat Detail">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                    </a>
                                    <a href="{{ route('admin.museum-items.edit', $item) }}" 
                                       class="p-2 rounded-xl text-slate-400 hover:text-amber-600 hover:bg-amber-50 transition-all duration-200"
                                       title="Edit Barang">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </a>
                                    <!-- Delete Button Form -->
                                    <form method="POST" action="{{ route('admin.museum-items.destroy', $item) }}" 
                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus barang ini? Seluruh data riwayat pengajuan terkait barang ini juga akan terhapus.');"
                                          class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="p-2 rounded-xl text-slate-400 hover:text-rose-600 hover:bg-rose-50 transition-all duration-200"
                                                title="Hapus Barang">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-slate-400">
                                <svg class="w-12 h-12 mx-auto text-slate-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                </svg>
                                <span class="text-sm font-semibold">Tidak ada data barang ditemukan.</span>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <!-- Paginate Links -->
        {{ $items->links('components.pagination') }}
    </x-card>
</div>
@endsection
