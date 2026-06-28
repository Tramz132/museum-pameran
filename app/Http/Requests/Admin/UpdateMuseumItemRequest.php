<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateMuseumItemRequest extends FormRequest
{
    /**
     * Tentukan apakah pengguna diotorisasi untuk membuat permintaan ini.
     */
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->isAdmin();
    }

    /**
     * Aturan validasi untuk update item.
     */
    public function rules(): array
    {
        $itemId = $this->route('museum_item');
        if (is_object($itemId)) {
            $itemId = $itemId->id;
        }

        return [
            'nama_barang' => ['required', 'string', 'max:255'],
            'kode_barang' => ['required', 'string', Rule::unique('museum_items', 'kode_barang')->ignore($itemId), 'max:50'],
            'kategori' => ['required', 'string', 'max:100'],
            'asal' => ['required', 'string', 'max:100'],
            'tahun' => ['required', 'string', 'max:50'],
            'deskripsi' => ['nullable', 'string'],
            'foto' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
            'status' => ['required', 'in:Tersedia,Dipinjam,Perbaikan'],
        ];
    }

    /**
     * Custom error messages.
     */
    public function messages(): array
    {
        return [
            'nama_barang.required' => 'Nama barang wajib diisi.',
            'kode_barang.required' => 'Kode barang wajib diisi.',
            'kode_barang.unique' => 'Kode barang sudah digunakan.',
            'kategori.required' => 'Kategori wajib diisi.',
            'asal.required' => 'Asal barang wajib diisi.',
            'tahun.required' => 'Tahun pembuatan wajib diisi.',
            'foto.image' => 'File harus berupa gambar.',
            'foto.mimes' => 'Format gambar harus jpeg, png, jpg, atau webp.',
            'foto.max' => 'Ukuran gambar maksimal 2MB.',
            'status.required' => 'Status barang wajib ditentukan.',
            'status.in' => 'Status tidak valid.',
        ];
    }
}
