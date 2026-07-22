<?php

namespace App\Http\Controllers\Api\Staff;

use App\Http\Controllers\Controller;
use App\Http\Requests\Staff\UpdateLoanStatusRequest;
use App\Models\LoanRequest;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;

class LoanRequestVerificationController extends Controller
{
    /**
     * Tampilkan daftar pengajuan peminjaman untuk diverifikasi oleh staf
     */
    public function index(): JsonResponse
    {
        $requests = LoanRequest::with(['museumItem', 'user'])
            ->orderByRaw("FIELD(status, 'Pending', 'Approved', 'Rejected') ASC")
            ->latest()
            ->paginate(10);

        return response()->json($requests);
    }

    /**
     * Verifikasi setuju (Approve) atau tolak (Reject) pengajuan peminjaman
     */
    public function verify(UpdateLoanStatusRequest $request, LoanRequest $loanRequest): JsonResponse
    {
        $validated = $request->validated();
        $item = $loanRequest->museumItem;

        if ($validated['status'] === 'Approved') {
            if ($item->status !== 'Tersedia') {
                return response()->json([
                    'message' => 'Gagal memproses. Barang museum saat ini tidak tersedia (status: ' . $item->status . ').'
                ], 422);
            }
            $item->update(['status' => 'Dipinjam']);
        } else {
            $item->update(['status' => 'Tersedia']);
        }

        $loanRequest->update([
            'status' => $validated['status'],
            'approved_by' => auth()->id(),
            'approved_at' => Carbon::now(),
            'catatan' => $validated['catatan'] ?? null,
        ]);

        $message = $validated['status'] === 'Approved' 
            ? 'Pengajuan peminjaman berhasil disetujui.' 
            : 'Pengajuan peminjaman berhasil ditolak.';

        return response()->json([
            'message' => $message,
            'data' => $loanRequest->load(['museumItem', 'user'])
        ]);
    }
}
