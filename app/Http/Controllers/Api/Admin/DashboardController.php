<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\MuseumItem;
use App\Models\LoanRequest;
use Illuminate\Http\JsonResponse;

class DashboardController extends Controller
{
    /**
     * Mengembalikan data statistik untuk dashboard Admin
     */
    public function __invoke(): JsonResponse
    {
        return response()->json([
            'total_items' => MuseumItem::count(),
            'borrowed_items' => MuseumItem::where('status', 'Dipinjam')->count(),
            'repair_items' => MuseumItem::where('status', 'Perbaikan')->count(),
            'total_requests' => LoanRequest::count(),
        ]);
    }
}
