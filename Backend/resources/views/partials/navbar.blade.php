<header class="sticky top-0 z-10 flex items-center justify-between h-16 px-6 bg-white border-b border-slate-200">
    <div class="flex items-center">
        <!-- Open Sidebar Button for mobile -->
        <button id="open-sidebar" class="p-1 mr-4 rounded-lg text-slate-500 hover:text-slate-900 md:hidden focus:outline-none hover:bg-slate-100">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
        </button>
        <!-- Page Title Placeholder -->
        <h1 class="text-lg font-bold text-slate-800">
            @yield('title', 'Sistem Pameran Museum')
        </h1>
    </div>

    <!-- Right Profile Section / Logout -->
    <div class="flex items-center space-x-4">
        <div class="hidden md:flex flex-col text-right">
            <span class="text-sm font-semibold text-slate-700">{{ auth()->user()->name }}</span>
            <span class="text-xs text-slate-400 capitalize">{{ auth()->user()->role }}</span>
        </div>

        <div class="border-l border-slate-200 h-6"></div>

        <!-- Logout Form -->
        <form method="POST" action="{{ route('logout') }}" class="inline">
            @csrf
            <button type="submit" class="flex items-center justify-center p-2 rounded-xl text-slate-400 hover:text-rose-600 hover:bg-rose-50 transition-all duration-200" title="Logout">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                </svg>
            </button>
        </form>
    </div>
</header>
