<?php

namespace App\Http\Requests\Staff;

use Illuminate\Foundation\Http\FormRequest;

class UpdateLoanStatusRequest extends FormRequest
{
    /**
     * Tentukan apakah pengguna diotorisasi untuk membuat permintaan ini.
     */
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->isStaff();
    }

    /**
     * Aturan validasi untuk verifikasi status pengajuan.
     */
    public function rules(): array
    {
        return [
            'status' => ['required', 'in:Approved,Rejected'],
            'catatan' => ['nullable', 'string', 'max:1000'],
        ];
    }

    /**
     * Custom messages.
     */
    public function messages(): array
    {
        return [
            'status.required' => 'Keputusan verifikasi wajib diisi.',
            'status.in' => 'Keputusan verifikasi harus berupa Setuju (Approved) atau Tolak (Rejected).',
        ];
    }
}
