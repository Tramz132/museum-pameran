<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreMuseumItemRequest;
use App\Http\Requests\Admin\UpdateMuseumItemRequest;
use App\Models\MuseumItem;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MuseumItemController extends Controller
{
    /**
     * Tampilkan daftar barang museum (Pencarian & Filter)
     */
    public function index(Request $request): JsonResponse
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

        $items = $query->latest()->paginate(10);

        return response()->json($items);
    }

    /**
     * Simpan barang museum baru
     */
    public function store(StoreMuseumItemRequest $request): JsonResponse
    {
        $validated = $request->validated();

        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('museum-items', 'public');
            $validated['foto'] = $path;
        }

        $item = MuseumItem::create($validated);

        return response()->json([
            'message' => 'Barang museum berhasil ditambahkan.',
            'data' => $item
        ], 201);
    }

    /**
     * Tampilkan detail barang museum
     */
    public function show(MuseumItem $museumItem): JsonResponse
    {
        // Load loan requests history for this item
        $museumItem->load(['loanRequests.user']);
        
        return response()->json($museumItem);
    }

    /**
     * Perbarui data barang museum
     */
    public function update(UpdateMuseumItemRequest $request, MuseumItem $museumItem): JsonResponse
    {
        $validated = $request->validated();

        if ($request->hasFile('foto')) {
            if ($museumItem->foto) {
                Storage::disk('public')->delete($museumItem->foto);
            }
            $path = $request->file('foto')->store('museum-items', 'public');
            $validated['foto'] = $path;
        }

        $museumItem->update($validated);

        return response()->json([
            'message' => 'Barang museum berhasil diperbarui.',
            'data' => $museumItem
        ]);
    }

    /**
     * Hapus barang museum
     */
    public function destroy(MuseumItem $museumItem): JsonResponse
    {
        if ($museumItem->foto) {
            Storage::disk('public')->delete($museumItem->foto);
        }

        $museumItem->delete();

        return response()->json([
            'message' => 'Barang museum berhasil dihapus.'
        ]);
    }
}
