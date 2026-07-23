<?php

namespace App\Http\Controllers\Api\Panitia;

use App\Http\Controllers\Controller;
use App\Models\MuseumItem;
use App\Models\LoanRequest;
use Illuminate\Http\JsonResponse;

class DashboardController extends Controller
{
    /**
     * Mengembalikan data statistik untuk dashboard Panitia
     */
    public function __invoke(): JsonResponse
    {
        $userId = auth()->id();

        return response()->json([
            'total_items' => MuseumItem::count(),
            'available_items' => MuseumItem::where('status', 'Tersedia')->count(),
            'my_requests' => LoanRequest::where('user_id', $userId)->count(),
            'my_approved_requests' => LoanRequest::where('user_id', $userId)->where('status', 'Approved')->count(),
        ]);
    }
}
