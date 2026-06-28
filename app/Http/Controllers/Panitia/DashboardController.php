<?php

namespace App\Http\Controllers\Panitia;

use App\Http\Controllers\Controller;
use App\Models\MuseumItem;
use App\Models\LoanRequest;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Tampilkan dashboard panitia
     */
    public function __invoke(Request $request): View
    {
        $userId = auth()->id();

        $stats = [
            'total_items' => MuseumItem::count(),
            'available_items' => MuseumItem::where('status', 'Tersedia')->count(),
            'my_requests' => LoanRequest::where('user_id', $userId)->count(),
            'my_approved_requests' => LoanRequest::where('user_id', $userId)->where('status', 'Approved')->count(),
        ];

        return view('panitia.dashboard', compact('stats'));
    }
}
