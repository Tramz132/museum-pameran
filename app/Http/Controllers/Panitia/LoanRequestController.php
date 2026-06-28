<?php

namespace App\Http\Controllers\Panitia;

use App\Http\Controllers\Controller;
use App\Http\Requests\Panitia\StoreLoanRequestRequest;
use App\Models\LoanRequest;
use App\Models\MuseumItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LoanRequestController extends Controller
{
    /**
     * Tampilkan katalog barang untuk diajukan peminjaman
     */
    public function catalog(Request $request): View
    {
        $query = MuseumItem::query();

        // Search filter
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('nama_barang', 'like', "%{$search}%")
                  ->orWhere('kode_barang', 'like', "%{$search}%")
                  ->orWhere('kategori', 'like', "%{$search}%")
                  ->orWhere('asal', 'like', "%{$search}%");
            });
        }

        // Status filter (boleh kosong)
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        $items = $query->latest()->paginate(8)->withQueryString();

        return view('panitia.catalog', compact('items'));
    }

    /**
     * Tampilkan form pengajuan peminjaman barang tertentu
     */
    public function create(MuseumItem $museumItem): View|RedirectResponse
    {
        if ($museumItem->status !== 'Tersedia') {
            return redirect()->route('panitia.catalog')
                ->with('error', 'Barang ini sedang tidak tersedia untuk dipinjam.');
        }

        return view('loan-requests.create', compact('museumItem'));
    }

    /**
     * Simpan pengajuan peminjaman baru ke database
     */
    public function store(StoreLoanRequestRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        
        $item = MuseumItem::findOrFail($validated['museum_item_id']);

        if ($item->status !== 'Tersedia') {
            return redirect()->route('panitia.catalog')
                ->with('error', 'Gagal mengajukan. Barang sudah tidak tersedia.');
        }

        // Simpan data peminjaman
        LoanRequest::create([
            'museum_item_id' => $item->id,
            'user_id' => auth()->id(),
            'nama_acara' => $validated['nama_acara'],
            'lokasi' => $validated['lokasi'],
            'tanggal_mulai' => $validated['tanggal_mulai'],
            'tanggal_selesai' => $validated['tanggal_selesai'],
            'status' => 'Pending',
        ]);

        return redirect()->route('panitia.loan-requests.index')
            ->with('success', 'Pengajuan peminjaman berhasil dikirim. Status saat ini: Pending.');
    }

    /**
     * Tampilkan riwayat pengajuan peminjaman panitia saat ini
     */
    public function index(): View
    {
        $requests = LoanRequest::with('museumItem')
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('loan-requests.index', compact('requests'));
    }
}
