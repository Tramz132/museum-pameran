@extends('layouts.app')

@section('title', 'Verifikasi Peminjaman Barang')

@section('content')
<div class="space-y-6">
    <!-- Header Page -->
    <div>
        <h2 class="text-xl font-bold text-slate-800">Verifikasi Pengajuan Koleksi</h2>
        <p class="text-sm text-slate-500">Tinjau, setujui, atau tolak berkas pengajuan peminjaman barang dari panitia.</p>
    </div>

    <!-- Table List -->
    <x-card class="p-0 overflow-hidden bg-white border border-slate-100 rounded-2xl shadow-sm">
        <div class="w-full overflow-x-auto">
            <table class="w-full text-sm text-left text-slate-500 border-collapse">
                <thead class="text-xs uppercase bg-slate-50 text-slate-400 border-b border-slate-100">
                    <tr>
                        <th class="px-6 py-4 font-semibold">Barang Koleksi</th>
                        <th class="px-6 py-4 font-semibold">Diajukan Oleh</th>
                        <th class="px-6 py-4 font-semibold">Detail Acara & Lokasi</th>
                        <th class="px-6 py-4 font-semibold">Tanggal Kegiatan</th>
                        <th class="px-6 py-4 font-semibold">Status</th>
                        <th class="px-6 py-4 font-semibold text-right">Aksi Verifikasi</th>
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
                            <!-- Detail Acara -->
                            <td class="px-6 py-4 text-slate-700">
                                <div class="font-semibold text-slate-800">{{ $req->nama_acara }}</div>
                                <div class="text-xs text-slate-400 mt-0.5">{{ $req->lokasi }}</div>
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
                            <!-- Aksi Verifikasi -->
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                @if ($req->status === 'Pending')
                                    <div class="flex items-center justify-end space-x-2">
                                        <!-- Approve Form Button -->
                                        <form method="POST" action="{{ route('staff.verifications.verify', $req) }}" 
                                              onsubmit="return confirm('Apakah Anda yakin ingin menyetujui pengajuan ini? Status barang akan berubah menjadi Dipinjam.');"
                                              class="inline-block">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="Approved">
                                            <x-button type="submit" variant="success" class="!px-3 !py-1.5 text-xs">
                                                Setujui
                                            </x-button>
                                        </form>

                                        <!-- Reject Trigger Button -->
                                        <x-button type="button" variant="danger" onclick="openModal('reject-modal-{{ $req->id }}')" class="!px-3 !py-1.5 text-xs">
                                            Tolak
                                        </x-button>
                                    </div>

                                    <!-- Rejection Modal -->
                                    <x-modal id="reject-modal-{{ $req->id }}" title="Tolak Pengajuan Peminjaman">
                                        <form method="POST" action="{{ route('staff.verifications.verify', $req) }}" class="space-y-4">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="Rejected">

                                            <div class="text-left">
                                                <p class="text-slate-500 mb-4">Anda akan menolak pengajuan peminjaman <strong>{{ $req->museumItem->nama_barang }}</strong> untuk acara <strong>{{ $req->nama_acara }}</strong>.</p>
                                                
                                                <label for="catatan-{{ $req->id }}" class="block text-xs font-semibold text-slate-500 mb-2">ALASAN PENOLAKAN</label>
                                                <textarea name="catatan" id="catatan-{{ $req->id }}" rows="3" required placeholder="Tulis alasan penolakan di sini..."
                                                          class="w-full px-3 py-2 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-rose-500 focus:border-transparent transition-all"></textarea>
                                            </div>

                                            <div class="flex items-center justify-end space-x-2 border-t border-slate-100 pt-4 mt-4">
                                                <x-button type="button" variant="secondary" onclick="closeModal('reject-modal-{{ $req->id }}')" class="!py-2">
                                                    Batal
                                                </x-button>
                                                <x-button type="submit" variant="danger" class="!py-2">
                                                    Tolak Pengajuan
                                                </x-button>
                                            </div>
                                        </form>
                                    </x-modal>
                                @else
                                    <div class="text-xs text-slate-400 text-right italic">
                                        Diverifikasi pada:<br>
                                        {{ $req->approved_at->format('d/m/Y H:i') }}
                                        @if ($req->approver)
                                            <br>oleh {{ $req->approver->name }}
                                        @endif
                                    </div>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-slate-400">
                                <svg class="w-12 h-12 mx-auto text-slate-350 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                                <span class="text-sm font-semibold">Tidak ada data pengajuan peminjaman.</span>
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
