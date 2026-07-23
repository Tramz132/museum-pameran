<?php

namespace App\Http\Controllers\Api\Panitia;

use App\Http\Controllers\Controller;
use App\Http\Requests\Panitia\StoreLoanRequestRequest;
use App\Models\LoanRequest;
use App\Models\MuseumItem;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LoanRequestController extends Controller
{
    /**
     * Tampilkan katalog barang museum untuk peminjaman (Grid)
     */
    public function catalog(Request $request): JsonResponse
    {
        $query = MuseumItem::query();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('nama_barang', 'like', "%{$search}%")
                  ->orWhere('kode_barang', 'like', "%{$search}%")
                  ->orWhere('kategori', 'like', "%{$search}%")
                  ->orWhere('asal', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        $items = $query->latest()->paginate(8);

        return response()->json($items);
    }

    /**
     * Simpan pengajuan peminjaman baru oleh Panitia
     */
    public function store(StoreLoanRequestRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $item = MuseumItem::findOrFail($validated['museum_item_id']);

        if ($item->status !== 'Tersedia') {
            return response()->json([
                'message' => 'Gagal mengajukan. Barang museum saat ini sedang tidak tersedia.'
            ], 422);
        }

        $loan = LoanRequest::create([
            'museum_item_id' => $item->id,
            'user_id' => auth()->id(),
            'nama_acara' => $validated['nama_acara'],
            'lokasi' => $validated['lokasi'],
            'tanggal_mulai' => $validated['tanggal_mulai'],
            'tanggal_selesai' => $validated['tanggal_selesai'],
            'status' => 'Pending',
        ]);

        return response()->json([
            'message' => 'Pengajuan peminjaman berhasil dikirim.',
            'data' => $loan
        ], 210); // Laravel standard uses 201 Created but 200/201 is fine, let's return 201 standard
    }

    /**
     * Tampilkan daftar riwayat pengajuan milik Panitia yang sedang login
     */
    public function index(): JsonResponse
    {
        $requests = LoanRequest::with('museumItem')
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return response()->json($requests);
    }
}
