@extends('layouts.app')

@section('title', 'Tambah Pengguna Baru')

@section('content')
<div class="max-w-xl mx-auto space-y-6">
    <!-- Header -->
    <div class="flex items-center space-x-3">
        <a href="{{ route('admin.users.index') }}" class="p-2 bg-white hover:bg-slate-50 border border-slate-200 text-slate-500 hover:text-slate-800 rounded-xl transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
        </a>
        <div>
            <h2 class="text-xl font-bold text-slate-800">Tambah Pengguna Baru</h2>
            <p class="text-sm text-slate-500">Buat akun baru untuk Admin, Staf Kurator, atau Panitia Pameran.</p>
        </div>
    </div>

    <!-- Form Card -->
    <x-card class="bg-white">
        <form method="POST" action="{{ route('admin.users.store') }}" class="space-y-6">
            @csrf

            <!-- Nama Lengkap -->
            <div>
                <label for="name" class="block text-sm font-semibold text-slate-700 mb-2">Nama Lengkap <span class="text-rose-500">*</span></label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" placeholder="Ketik nama lengkap pengguna"
                       class="w-full px-4 py-2.5 text-sm bg-slate-50 border @error('name') border-rose-500 focus:ring-rose-500 @else border-slate-200 focus:ring-blue-500 @enderror rounded-xl focus:outline-none focus:ring-2 focus:border-transparent transition-all">
                @error('name')
                    <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Alamat Email -->
            <div>
                <label for="email" class="block text-sm font-semibold text-slate-700 mb-2">Alamat Email <span class="text-rose-500">*</span></label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" placeholder="Contoh: user@museum.id"
                       class="w-full px-4 py-2.5 text-sm bg-slate-50 border @error('email') border-rose-500 focus:ring-rose-500 @else border-slate-200 focus:ring-blue-500 @enderror rounded-xl focus:outline-none focus:ring-2 focus:border-transparent transition-all">
                @error('email')
                    <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Peran (Role) -->
            <div>
                <label for="role" class="block text-sm font-semibold text-slate-700 mb-2">Peran Sistem <span class="text-rose-500">*</span></label>
                <select name="role" id="role"
                        class="w-full px-3 py-2.5 text-sm bg-slate-50 border @error('role') border-rose-500 focus:ring-rose-500 @else border-slate-200 focus:ring-blue-500 @enderror rounded-xl focus:outline-none focus:ring-2 focus:border-transparent transition-all">
                    <option value="panitia" {{ old('role') === 'panitia' ? 'selected' : '' }}>Panitia (Peminjam Koleksi)</option>
                    <option value="staff" {{ old('role') === 'staff' ? 'selected' : '' }}>Staf Kurator (Verifikator Peminjaman)</option>
                    <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Administrator (Akses Penuh)</option>
                </select>
                @error('role')
                    <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Kata Sandi Awal -->
            <div>
                <label for="password" class="block text-sm font-semibold text-slate-700 mb-2">Kata Sandi Awal <span class="text-rose-500">*</span></label>
                <input type="password" name="password" id="password" placeholder="Minimal 8 karakter"
                       class="w-full px-4 py-2.5 text-sm bg-slate-50 border @error('password') border-rose-500 focus:ring-rose-500 @else border-slate-200 focus:ring-blue-500 @enderror rounded-xl focus:outline-none focus:ring-2 focus:border-transparent transition-all">
                @error('password')
                    <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit Buttons -->
            <div class="flex items-center justify-end space-x-3 border-t border-slate-100 pt-6">
                <x-button href="{{ route('admin.users.index') }}" variant="secondary">
                    Batal
                </x-button>
                <x-button type="submit" variant="primary">
                    Daftarkan User
                </x-button>
            </div>
        </form>
    </x-card>
</div>
@endsection
