<?php

namespace App\Http\Requests\Panitia;

use Illuminate\Foundation\Http\FormRequest;

class StoreLoanRequestRequest extends FormRequest
{
    /**
     * Tentukan apakah pengguna diotorisasi untuk membuat permintaan ini.
     */
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->isPanitia();
    }

    /**
     * Aturan validasi untuk pengajuan peminjaman.
     */
    public function rules(): array
    {
        return [
            'museum_item_id' => ['required', 'exists:museum_items,id'],
            'nama_acara' => ['required', 'string', 'max:255'],
            'lokasi' => ['required', 'string', 'max:255'],
            'tanggal_mulai' => ['required', 'date', 'after_or_equal:today'],
            'tanggal_selesai' => ['required', 'date', 'after_or_equal:tanggal_mulai'],
        ];
    }

    /**
     * Custom error messages.
     */
    public function messages(): array
    {
        return [
            'museum_item_id.required' => 'Barang museum wajib dipilih.',
            'museum_item_id.exists' => 'Barang museum tidak terdaftar.',
            'nama_acara.required' => 'Nama acara wajib diisi.',
            'lokasi.required' => 'Lokasi pameran wajib diisi.',
            'tanggal_mulai.required' => 'Tanggal mulai wajib diisi.',
            'tanggal_mulai.date' => 'Format tanggal mulai tidak valid.',
            'tanggal_mulai.after_or_equal' => 'Tanggal mulai tidak boleh di masa lampau.',
            'tanggal_selesai.required' => 'Tanggal selesai wajib diisi.',
            'tanggal_selesai.date' => 'Format tanggal selesai tidak valid.',
            'tanggal_selesai.after_or_equal' => 'Tanggal selesai harus setelah atau sama dengan tanggal mulai.',
        ];
    }
}
