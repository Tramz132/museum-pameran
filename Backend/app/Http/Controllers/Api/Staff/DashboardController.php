<?php

namespace App\Http\Controllers\Api\Staff;

use App\Http\Controllers\Controller;
use App\Models\LoanRequest;
use Illuminate\Http\JsonResponse;

class DashboardController extends Controller
{
    /**
     * Mengembalikan data statistik untuk dashboard Staf
     */
    public function __invoke(): JsonResponse
    {
        return response()->json([
            'pending_requests' => LoanRequest::where('status', 'Pending')->count(),
            'approved_requests' => LoanRequest::where('status', 'Approved')->count(),
            'rejected_requests' => LoanRequest::where('status', 'Rejected')->count(),
            'total_requests' => LoanRequest::count(),
        ]);
    }
}
