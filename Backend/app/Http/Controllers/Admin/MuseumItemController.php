<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreMuseumItemRequest;
use App\Http\Requests\Admin\UpdateMuseumItemRequest;
use App\Models\MuseumItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class MuseumItemController extends Controller
{
    /**
     * Tampilkan daftar barang museum (dengan pencarian & filter)
     */
    public function index(Request $request): View
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

        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        // Sort by newest
        $items = $query->latest()->paginate(5)->withQueryString();

        return view('museum-items.index', compact('items'));
    }

    /**
     * Tampilkan form tambah barang
     */
    public function create(): View
    {
        return view('museum-items.create');
    }

    /**
     * Simpan barang baru ke database
     */
    public function store(StoreMuseumItemRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('museum-items', 'public');
            $validated['foto'] = $path;
        }

        MuseumItem::create($validated);

        return redirect()->route('admin.museum-items.index')
            ->with('success', 'Barang museum berhasil ditambahkan.');
    }

    /**
     * Tampilkan detail barang museum (optional, but good practice)
     */
    public function show(MuseumItem $museumItem): View
    {
        return view('museum-items.show', compact('museumItem'));
    }

    /**
     * Tampilkan form edit barang
     */
    public function edit(MuseumItem $museumItem): View
    {
        return view('museum-items.edit', compact('museumItem'));
    }

    /**
     * Update data barang di database
     */
    public function update(UpdateMuseumItemRequest $request, MuseumItem $museumItem): RedirectResponse
    {
        $validated = $request->validated();

        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($museumItem->foto) {
                Storage::disk('public')->delete($museumItem->foto);
            }
            $path = $request->file('foto')->store('museum-items', 'public');
            $validated['foto'] = $path;
        }

        $museumItem->update($validated);

        return redirect()->route('admin.museum-items.index')
            ->with('success', 'Barang museum berhasil diupdate.');
    }

    /**
     * Hapus barang dari database
     */
    public function destroy(MuseumItem $museumItem): RedirectResponse
    {
        // Hapus foto jika ada
        if ($museumItem->foto) {
            Storage::disk('public')->delete($museumItem->foto);
        }

        $museumItem->delete();

        return redirect()->route('admin.museum-items.index')
            ->with('success', 'Barang museum berhasil dihapus.');
    }
}
