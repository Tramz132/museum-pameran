<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Http\Requests\Staff\UpdateLoanStatusRequest;
use App\Models\LoanRequest;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class LoanRequestVerificationController extends Controller
{
    /**
     * Tampilkan daftar seluruh pengajuan untuk diverifikasi oleh Staf
     */
    public function index(): View
    {
        // Tampilkan pending teratas, diikuti yang lain
        $requests = LoanRequest::with(['museumItem', 'user'])
            ->orderByRaw("FIELD(status, 'Pending', 'Approved', 'Rejected') ASC")
            ->latest()
            ->paginate(10);

        return view('staff.verifications', compact('requests'));
    }

    /**
     * Lakukan verifikasi setuju (approve) atau tolak (reject) pengajuan
     */
    public function verify(UpdateLoanStatusRequest $request, LoanRequest $loanRequest): RedirectResponse
    {
        $validated = $request->validated();
        $item = $loanRequest->museumItem;

        if ($validated['status'] === 'Approved') {
            // Jika disetujui, pastikan barang masih tersedia
            if ($item->status !== 'Tersedia') {
                return redirect()->route('staff.verifications.index')
                    ->with('error', 'Gagal memproses. Barang museum saat ini tidak tersedia (status: ' . $item->status . ').');
            }

            // Ubah status barang jadi Dipinjam
            $item->update(['status' => 'Dipinjam']);
        } else {
            // Jika ditolak, status barang tetap Tersedia
            $item->update(['status' => 'Tersedia']);
        }

        // Simpan keputusan verifikasi pada pengajuan
        $loanRequest->update([
            'status' => $validated['status'],
            'approved_by' => auth()->id(),
            'approved_at' => Carbon::now(),
            'catatan' => $validated['catatan']?? null,
        ]);

        $message = $validated['status'] === 'Approved'
            ? 'Pengajuan peminjaman berhasil disetujui. Status barang kini menjadi Dipinjam.'
            : 'Pengajuan peminjaman berhasil ditolak.';

        return redirect()->route('staff.verifications.index')->with('success', $message);
    }
}
