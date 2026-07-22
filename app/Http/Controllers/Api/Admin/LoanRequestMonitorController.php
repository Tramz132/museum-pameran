<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\LoanRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LoanRequestMonitorController extends Controller
{
    /**
     * Tampilkan monitoring seluruh transaksi peminjaman barang (Read-Only)
     */
    public function index(Request $request): JsonResponse
    {
        $query = LoanRequest::with(['museumItem', 'user', 'approver']);

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('nama_acara', 'like', "%{$search}%")
                  ->orWhere('lokasi', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($uq) use ($search) {
                      $uq->where('name', 'like', "%{$search}%");
                  })
                  ->orWhereHas('museumItem', function ($iq) use ($search) {
                      $iq->where('nama_barang', 'like', "%{$search}%")
                         ->orWhere('kode_barang', 'like', "%{$search}%");
                  });
            });
        }

        $requests = $query->latest()->paginate(10);

        return response()->json($requests);
    }
}
