<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\LoanRequest;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Tampilkan dashboard staf
     */
    public function __invoke(Request $request): View
    {
        $stats = [
            'pending_requests' => LoanRequest::where('status', 'Pending')->count(),
            'approved_requests' => LoanRequest::where('status', 'Approved')->count(),
            'rejected_requests' => LoanRequest::where('status', 'Rejected')->count(),
            'total_requests' => LoanRequest::count(),
        ];

        return view('staff.dashboard', compact('stats'));
    }
}
