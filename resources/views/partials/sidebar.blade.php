@php
    $role = auth()->user()->role;
    $menuItems = [];

    if ($role === 'admin') {
        $menuItems = [
            ['route' => 'admin.dashboard', 'icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6', 'label' => 'Dashboard'],
            ['route' => 'admin.museum-items.index', 'icon' => 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4', 'label' => 'Kelola Barang'],
            ['route' => 'admin.users.index', 'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z', 'label' => 'Kelola User'],
            ['route' => 'admin.loan-requests.index', 'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01', 'label' => 'Histori Pengajuan'],
        ];
    } elseif ($role === 'staff') {
        $menuItems = [
            ['route' => 'staff.dashboard', 'icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6', 'label' => 'Dashboard Staf'],
            ['route' => 'staff.verifications.index', 'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z', 'label' => 'Verifikasi Peminjaman'],
        ];
    } elseif ($role === 'panitia') {
        $menuItems = [
            ['route' => 'panitia.dashboard', 'icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6', 'label' => 'Dashboard Panitia'],
            ['route' => 'panitia.catalog', 'icon' => 'M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z', 'label' => 'Katalog Barang'],
            ['route' => 'panitia.loan-requests.index', 'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z', 'label' => 'Riwayat Pengajuan'],
        ];
    }
@endphp

<!-- Sidebar Sidebar Container -->
<div id="sidebar" class="fixed inset-y-0 left-0 z-20 flex flex-col w-64 bg-slate-900 border-r border-slate-800 transition-transform duration-300 transform -translate-x-full md:translate-x-0">
    <!-- Brand / Logo -->
    <div class="flex items-center justify-between px-6 py-5 border-b border-slate-800">
        <a href="#" class="flex items-center space-x-3">
            <span class="text-xl font-bold tracking-wider text-white">MUSEUM<span class="text-blue-500">EXPO</span></span>
        </a>
        <!-- Close Sidebar button for mobile -->
        <button id="close-sidebar" class="p-1 rounded-lg text-slate-400 hover:text-white md:hidden focus:outline-none">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    </div>

    <!-- Navigation Menu -->
    <nav class="flex-1 px-4 py-6 space-y-1 overflow-y-auto">
        @foreach($menuItems as $item)
            @php
                $isActive = request()->routeIs($item['route']) || (str_contains($item['route'], 'museum-items') && request()->routeIs('admin.museum-items.*')) || (str_contains($item['route'], 'users') && request()->routeIs('admin.users.*')) || (str_contains($item['route'], 'loan-requests') && request()->routeIs('admin.loan-requests.*'));
            @endphp
            <a href="{{ route($item['route']) }}" 
               class="flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 group {{ $isActive ? 'bg-blue-600 text-white shadow-md shadow-blue-600/30' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                <svg class="w-5 h-5 mr-3 transition-colors duration-200 {{ $isActive ? 'text-white' : 'text-slate-400 group-hover:text-white' }}" 
                     fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="{{ $item['icon'] }}"></path>
                </svg>
                {{ $item['label'] }}
            </a>
        @endforeach
    </nav>

    <!-- User Section footer of sidebar -->
    <div class="p-4 border-t border-slate-800 bg-slate-950">
        <div class="flex items-center space-x-3">
            <div class="flex-shrink-0">
                <div class="flex items-center justify-center w-10 h-10 rounded-xl bg-blue-600 text-white font-bold">
                    {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                </div>
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-semibold text-white truncate">{{ auth()->user()->name }}</p>
                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium uppercase tracking-wider {{ $role === 'admin' ? 'bg-rose-500/10 text-rose-400' : ($role === 'staff' ? 'bg-emerald-500/10 text-emerald-400' : 'bg-amber-500/10 text-amber-400') }}">
                    {{ $role }}
                </span>
            </div>
        </div>
    </div>
</div>

<!-- Overlay for Mobile -->
<div id="sidebar-overlay" class="fixed inset-0 z-10 hidden bg-slate-900/50 backdrop-blur-sm md:hidden"></div>
