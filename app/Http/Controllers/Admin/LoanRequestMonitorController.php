<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LoanRequest;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LoanRequestMonitorController extends Controller
{
    /**
     * Tampilkan monitoring seluruh transaksi peminjaman barang (Read-Only)
     */
    public function index(Request $request): View
    {
        $query = LoanRequest::with(['museumItem', 'user', 'approver']);

        // Filter status if requested
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        // Search filter (searches event name, location, user name, item name)
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

        $requests = $query->latest()->paginate(10)->withQueryString();

        return view('admin.loan-requests.index', compact('requests'));
    }
}
