<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MuseumItem;
use App\Models\LoanRequest;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Tampilkan dashboard admin
     */
    public function __invoke(Request $request): View
    {
        $stats = [
            'total_items' => MuseumItem::count(),
            'borrowed_items' => MuseumItem::where('status', 'Dipinjam')->count(),
            'repair_items' => MuseumItem::where('status', 'Perbaikan')->count(),
            'total_requests' => LoanRequest::count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}
