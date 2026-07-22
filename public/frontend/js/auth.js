// Helper Autentikasi dan Manajemen Sesi Frontend

// Periksa apakah user sudah login
function checkAuth() {
    const token = localStorage.getItem('access_token');
    const userJson = localStorage.getItem('user');

    if (!token || !userJson) {
        logout();
        return null;
    }

    return JSON.parse(userJson);
}

// Redirect ke halaman login jika belum autentikasi
function requireAuth(allowedRoles = []) {
    const user = checkAuth();
    if (!user) {
        window.location.href = '/frontend/login.html';
        return;
    }

    if (allowedRoles.length > 0 && !allowedRoles.includes(user.role)) {
        // Redirect silang jika peran tidak sesuai
        alert('Akses Ditolak: Anda tidak memiliki izin untuk halaman ini.');
        if (user.role === 'admin') window.location.href = '/frontend/admin/dashboard.html';
        else if (user.role === 'staff') window.location.href = '/frontend/staff/dashboard.html';
        else if (user.role === 'panitia') window.location.href = '/frontend/panitia/dashboard.html';
        else logout();
    }
}

// Hapus sesi dan pindah ke login
function logout() {
    // Panggil API logout secara background jika token ada
    const token = localStorage.getItem('access_token');
    if (token) {
        fetch(`${API_URL}/logout`, {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'Authorization': `Bearer ${token}`
            }
        }).catch(() => {});
    }

    localStorage.removeItem('access_token');
    localStorage.removeItem('user');
    window.location.href = '/frontend/login.html';
}

// Wrapper fetch API yang menyertakan Authorization Header secara otomatis
async function apiFetch(endpoint, options = {}) {
    const token = localStorage.getItem('access_token');
    
    // Set headers
    if (!options.headers) {
        options.headers = {};
    }
    
    options.headers['Accept'] = 'application/json';
    if (token) {
        options.headers['Authorization'] = `Bearer ${token}`;
    }

    try {
        const response = await fetch(`${API_URL}${endpoint}`, options);
        
        if (response.status === 401) {
            alert('Sesi Anda telah berakhir. Silakan login kembali.');
            logout();
            return null;
        }

        if (response.status === 403) {
            const errData = await response.json();
            alert(errData.message || 'Akses Ditolak.');
            return null;
        }

        return response;
    } catch (error) {
        console.error('Fetch Error:', error);
        alert('Terjadi kesalahan koneksi ke server backend.');
        throw error;
    }
}

// Injeksi Layout Dinamis (Sidebar, Navbar, Header) untuk mencegah duplikasi kode HTML
function injectLayout() {
    const user = checkAuth();
    if (!user) return;

    // 1. Injeksi Sidebar
    const sidebarEl = document.getElementById('sidebar-container');
    if (sidebarEl) {
        let menuItems = '';
        
        if (user.role === 'admin') {
            menuItems = `
                <a href="/frontend/admin/dashboard.html" class="flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 nav-link" id="nav-dashboard">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2v-4zM14 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2v-4z"/></svg>
                    <span class="font-medium">Dashboard</span>
                </a>
                <a href="/frontend/admin/items.html" class="flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 nav-link" id="nav-items">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                    <span class="font-medium">Kelola Barang</span>
                </a>
                <a href="/frontend/admin/users.html" class="flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 nav-link" id="nav-users">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    <span class="font-medium">Kelola User</span>
                </a>
                <a href="/frontend/admin/loans.html" class="flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 nav-link" id="nav-loans">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
                    <span class="font-medium">Monitoring</span>
                </a>
            `;
        } else if (user.role === 'staff') {
            menuItems = `
                <a href="/frontend/staff/dashboard.html" class="flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 nav-link" id="nav-dashboard">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2v-4zM14 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2v-4z"/></svg>
                    <span class="font-medium">Dashboard</span>
                </a>
                <a href="/frontend/staff/verifications.html" class="flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 nav-link" id="nav-verifications">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span class="font-medium">Verifikasi Peminjaman</span>
                </a>
            `;
        } else if (user.role === 'panitia') {
            menuItems = `
                <a href="/frontend/panitia/dashboard.html" class="flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 nav-link" id="nav-dashboard">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2v-4zM14 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2v-4z"/></svg>
                    <span class="font-medium">Dashboard</span>
                </a>
                <a href="/frontend/panitia/catalog.html" class="flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 nav-link" id="nav-catalog">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z"/></svg>
                    <span class="font-medium">Katalog Barang</span>
                </a>
                <a href="/frontend/panitia/loans.html" class="flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 nav-link" id="nav-loans">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span class="font-medium">Riwayat Peminjaman</span>
                </a>
            `;
        }

        sidebarEl.innerHTML = `
            <div class="h-full flex flex-col justify-between">
                <div>
                    <!-- Logo / Brand -->
                    <div class="px-6 py-8 border-b border-slate-800">
                        <span class="text-xl font-black tracking-widest text-white">MUSEUM<span class="text-blue-500">EXPO</span></span>
                    </div>

                    <!-- Menu List -->
                    <div class="px-4 py-6 space-y-2 text-slate-400">
                        ${menuItems}
                    </div>
                </div>

                <!-- Footer Sidebar -->
                <div class="px-4 py-6 border-t border-slate-800">
                    <button onclick="logout()" class="w-full flex items-center space-x-3 px-4 py-3 rounded-xl hover:bg-slate-800 text-rose-400 transition-all duration-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        <span class="font-medium">Keluar</span>
                    </button>
                </div>
            </div>
        `;

        // Highlight menu aktif berdasarkan path URL
        const currentPath = window.location.pathname;
        let activeEl = null;
        if (currentPath.includes('dashboard.html')) activeEl = document.getElementById('nav-dashboard');
        else if (currentPath.includes('items.html')) activeEl = document.getElementById('nav-items');
        else if (currentPath.includes('users.html')) activeEl = document.getElementById('nav-users');
        else if (currentPath.includes('verifications.html')) activeEl = document.getElementById('nav-verifications');
        else if (currentPath.includes('catalog.html')) activeEl = document.getElementById('nav-catalog');
        else if (currentPath.includes('loans.html')) activeEl = document.getElementById('nav-loans');

        if (activeEl) {
            activeEl.classList.remove('text-slate-400');
            activeEl.classList.add('bg-blue-600', 'text-white', 'shadow-lg', 'shadow-blue-600/30');
        }
    }

    // 2. Injeksi Top Navbar
    const navbarEl = document.getElementById('navbar-container');
    if (navbarEl) {
        navbarEl.innerHTML = `
            <div class="bg-white border-b border-slate-100 px-6 py-4 flex items-center justify-between">
                <div>
                    <h2 class="text-sm font-semibold text-slate-400 uppercase tracking-wider" id="navbar-role-label">${user.role}</h2>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="text-sm font-bold text-slate-800">${user.name}</span>
                    <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold text-sm">
                        ${user.name.charAt(0).toUpperCase()}
                    </div>
                </div>
            </div>
        `;
    }
}
