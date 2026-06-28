@extends('layouts.app')

@section('title', 'Monitoring Pengajuan Peminjaman')

@section('content')
<div class="space-y-6">
    <!-- Header Page -->
    <div>
        <h2 class="text-xl font-bold text-slate-800">Monitoring Peminjaman Koleksi</h2>
        <p class="text-sm text-slate-500">Lihat histori seluruh transaksi peminjaman barang museum oleh panitia (Read-Only).</p>
    </div>

    <!-- Search & Filter Card -->
    <x-card class="bg-white">
        <form method="GET" action="{{ route('admin.loan-requests.index') }}" class="flex flex-col md:flex-row md:items-end gap-4">
            <!-- Search Input -->
            <div class="flex-1">
                <label for="search" class="block text-xs font-semibold text-slate-500 mb-2">CARI TRANSAKSI</label>
                <div class="relative">
                    <input type="text" name="search" id="search" value="{{ request('search') }}"
                           placeholder="Cari berdasarkan panitia, acara, lokasi, barang..."
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
                    <option value="Pending" {{ request('status') === 'Pending' ? 'selected' : '' }}>Pending</option>
                    <option value="Approved" {{ request('status') === 'Approved' ? 'selected' : '' }}>Approved</option>
                    <option value="Rejected" {{ request('status') === 'Rejected' ? 'selected' : '' }}>Rejected</option>
                </select>
            </div>

            <!-- Action Buttons -->
            <div class="flex gap-2 w-full md:w-auto">
                <x-button type="submit" variant="primary" class="w-full md:w-auto">
                    Filter
                </x-button>
                @if (request()->filled('search') || request()->filled('status'))
                    <x-button href="{{ route('admin.loan-requests.index') }}" variant="secondary" class="w-full md:w-auto">
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
                        <th class="px-6 py-4 font-semibold">Barang Museum</th>
                        <th class="px-6 py-4 font-semibold">Diajukan Oleh</th>
                        <th class="px-6 py-4 font-semibold">Acara & Lokasi</th>
                        <th class="px-6 py-4 font-semibold">Tanggal</th>
                        <th class="px-6 py-4 font-semibold">Status</th>
                        <th class="px-6 py-4 font-semibold">Verifikator & Catatan</th>
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
                            <!-- Diajukan Oleh -->
                            <td class="px-6 py-4 text-slate-700">
                                <div class="font-semibold">{{ $req->user->name }}</div>
                                <div class="text-xs text-slate-400">{{ $req->user->email }}</div>
                            </td>
                            <!-- Acara -->
                            <td class="px-6 py-4 text-slate-700">
                                <div class="font-semibold text-slate-800">{{ $req->nama_acara }}</div>
                                <div class="text-xs text-slate-450 mt-0.5">{{ $req->lokasi }}</div>
                            </td>
                            <!-- Tanggal -->
                            <td class="px-6 py-4 whitespace-nowrap text-slate-600">
                                <div class="text-sm font-semibold">{{ $req->tanggal_mulai->format('d M Y') }}</div>
                                <div class="text-xs text-slate-400">s/d {{ $req->tanggal_selesai->format('d M Y') }}</div>
                            </td>
                            <!-- Status -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <x-badge :status="$req->status" />
                            </td>
                            <!-- Verifikator & Catatan -->
                            <td class="px-6 py-4 text-xs text-slate-500 max-w-xs">
                                @if ($req->status !== 'Pending')
                                    <div class="font-semibold text-slate-700">Oleh: {{ $req->approver ? $req->approver->name : 'System' }}</div>
                                    <div class="text-slate-400 mt-0.5">{{ $req->approved_at->format('d/m/Y H:i') }}</div>
                                    @if ($req->catatan)
                                        <div class="mt-1 p-1.5 bg-slate-50 border border-slate-100 rounded text-slate-600 italic">"{{ $req->catatan }}"</div>
                                    @endif
                                @else
                                    <span class="text-slate-400 italic">Belum diverifikasi</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-slate-400">
                                <svg class="w-12 h-12 mx-auto text-slate-350 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                                <span class="text-sm font-semibold">Tidak ada data transaksi peminjaman barang.</span>
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
