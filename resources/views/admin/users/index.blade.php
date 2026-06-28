@extends('layouts.app')

@section('title', 'Kelola Pengguna')

@section('content')
<div class="space-y-6">
    <!-- Header Page -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-4 sm:space-y-0">
        <div>
            <h2 class="text-xl font-bold text-slate-800">Manajemen Pengguna</h2>
            <p class="text-sm text-slate-500">Kelola akun Admin, Staf Kurator, dan Panitia Pameran.</p>
        </div>
        <x-button href="{{ route('admin.users.create') }}" variant="primary">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
            </svg>
            Tambah User
        </x-button>
    </div>

    <!-- Search & Filter Card -->
    <x-card class="bg-white">
        <form method="GET" action="{{ route('admin.users.index') }}" class="flex flex-col md:flex-row md:items-end gap-4">
            <!-- Search Input -->
            <div class="flex-1">
                <label for="search" class="block text-xs font-semibold text-slate-500 mb-2">CARI USER</label>
                <div class="relative">
                    <input type="text" name="search" id="search" value="{{ request('search') }}"
                           placeholder="Cari berdasarkan nama atau email..."
                           class="w-full pl-10 pr-4 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Role Filter -->
            <div class="w-full md:w-48">
                <label for="role" class="block text-xs font-semibold text-slate-500 mb-2">FILTER PERAN (ROLE)</label>
                <select name="role" id="role"
                        class="w-full px-3 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                    <option value="">Semua Peran</option>
                    <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="staff" {{ request('role') === 'staff' ? 'selected' : '' }}>Staf</option>
                    <option value="panitia" {{ request('role') === 'panitia' ? 'selected' : '' }}>Panitia</option>
                </select>
            </div>

            <!-- Action Buttons -->
            <div class="flex gap-2 w-full md:w-auto">
                <x-button type="submit" variant="primary" class="w-full md:w-auto">
                    Filter
                </x-button>
                @if (request()->filled('search') || request()->filled('role'))
                    <x-button href="{{ route('admin.users.index') }}" variant="secondary" class="w-full md:w-auto">
                        Reset
                    </x-button>
                @endif
            </div>
        </form>
    </x-card>

    <!-- Table List -->
    <x-card class="p-0 overflow-hidden bg-white border border-slate-100 rounded-2xl shadow-sm">
        <div class="w-full overflow-x-auto">
            <table class="w-full text-sm text-left text-slate-500 border-collapse">
                <thead class="text-xs uppercase bg-slate-50 text-slate-400 border-b border-slate-100">
                    <tr>
                        <th class="px-6 py-4 font-semibold">Nama Pengguna</th>
                        <th class="px-6 py-4 font-semibold">Email</th>
                        <th class="px-6 py-4 font-semibold">Peran</th>
                        <th class="px-6 py-4 font-semibold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($users as $user)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <!-- Nama -->
                            <td class="px-6 py-4 font-bold text-slate-800">
                                {{ $user->name }}
                                @if($user->id === auth()->id())
                                    <span class="ml-2 text-xs font-semibold bg-blue-100 text-blue-800 px-2 py-0.5 rounded-full">Anda</span>
                                @endif
                            </td>
                            <!-- Email -->
                            <td class="px-6 py-4 text-slate-650">
                                {{ $user->email }}
                            </td>
                            <!-- Peran -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold uppercase tracking-wider {{ $user->role === 'admin' ? 'bg-rose-50 text-rose-700 border border-rose-200' : ($user->role === 'staff' ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-amber-50 text-amber-700 border border-amber-200') }}">
                                    {{ $user->role }}
                                </span>
                            </td>
                            <!-- Aksi -->
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex items-center justify-end space-x-2">
                                    <!-- Reset Password Trigger -->
                                    <x-button type="button" variant="warning" onclick="openModal('reset-modal-{{ $user->id }}')" class="!px-3 !py-1.5 text-xs" title="Reset Sandi">
                                        Reset Sandi
                                    </x-button>

                                    <!-- Edit User -->
                                    <a href="{{ route('admin.users.edit', $user) }}" 
                                       class="p-2 rounded-xl text-slate-400 hover:text-blue-600 hover:bg-blue-50 transition-all duration-200"
                                       title="Edit User">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </a>
                                    
                                    <!-- Delete User -->
                                    @if ($user->id !== auth()->id())
                                        <form method="POST" action="{{ route('admin.users.destroy', $user) }}" 
                                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus user ini? Seluruh data riwayat pengajuan peminjaman oleh user ini juga akan terhapus.');"
                                              class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="p-2 rounded-xl text-slate-400 hover:text-rose-600 hover:bg-rose-50 transition-all duration-200"
                                                    title="Hapus User">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                        </form>
                                    @endif
                                </div>

                                <!-- Reset Password Modal -->
                                <x-modal id="reset-modal-{{ $user->id }}" title="Reset Kata Sandi Pengguna">
                                    <form method="POST" action="{{ route('admin.users.reset-password', $user) }}" class="space-y-4">
                                        @csrf
                                        @method('PATCH')

                                        <div class="text-left">
                                            <p class="text-slate-500 mb-4">Mereset kata sandi untuk pengguna <strong>{{ $user->name }}</strong> ({{ $user->email }}).</p>
                                            
                                            <!-- Password Input -->
                                            <div class="mb-4">
                                                <label for="password-{{ $user->id }}" class="block text-xs font-semibold text-slate-500 mb-2">SANDI BARU <span class="text-rose-500">*</span></label>
                                                <input type="password" name="password" id="password-{{ $user->id }}" required placeholder="Minimal 8 karakter"
                                                       class="w-full px-4 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                                            </div>

                                            <!-- Confirm Password Input -->
                                            <div>
                                                <label for="password_confirmation-{{ $user->id }}" class="block text-xs font-semibold text-slate-500 mb-2">KONFIRMASI SANDI BARU <span class="text-rose-500">*</span></label>
                                                <input type="password" name="password_confirmation" id="password_confirmation-{{ $user->id }}" required placeholder="Ketik ulang sandi baru"
                                                       class="w-full px-4 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                                            </div>
                                        </div>

                                        <div class="flex items-center justify-end space-x-2 border-t border-slate-100 pt-4 mt-4">
                                            <x-button type="button" variant="secondary" onclick="closeModal('reset-modal-{{ $user->id }}')" class="!py-2">
                                                Batal
                                            </x-button>
                                            <x-button type="submit" variant="primary" class="!py-2">
                                                Reset Sandi
                                            </x-button>
                                        </div>
                                    </form>
                                </x-modal>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-slate-400">
                                <svg class="w-12 h-12 mx-auto text-slate-350 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                </svg>
                                <span class="text-sm font-semibold">Tidak ada data pengguna ditemukan.</span>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <!-- Paginate Links -->
        {{ $users->links('components.pagination') }}
    </x-card>
</div>
@endsection
