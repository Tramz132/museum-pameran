@extends('layouts.app')

@section('title', 'Edit Data Pengguna')

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
            <h2 class="text-xl font-bold text-slate-800">Edit Profil Pengguna</h2>
            <p class="text-sm text-slate-500">Perbarui data profil dan peran sistem untuk pengguna ini.</p>
        </div>
    </div>

    <!-- Form Card -->
    <x-card class="bg-white">
        <form method="POST" action="{{ route('admin.users.update', $user) }}" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Nama Lengkap -->
            <div>
                <label for="name" class="block text-sm font-semibold text-slate-700 mb-2">Nama Lengkap <span class="text-rose-500">*</span></label>
                <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}"
                       class="w-full px-4 py-2.5 text-sm bg-slate-50 border @error('name') border-rose-500 focus:ring-rose-500 @else border-slate-200 focus:ring-blue-500 @enderror rounded-xl focus:outline-none focus:ring-2 focus:border-transparent transition-all">
                @error('name')
                    <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Alamat Email -->
            <div>
                <label for="email" class="block text-sm font-semibold text-slate-700 mb-2">Alamat Email <span class="text-rose-500">*</span></label>
                <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                       class="w-full px-4 py-2.5 text-sm bg-slate-50 border @error('email') border-rose-500 focus:ring-rose-500 @else border-slate-200 focus:ring-blue-500 @enderror rounded-xl focus:outline-none focus:ring-2 focus:border-transparent transition-all">
                @error('email')
                    <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Peran (Role) -->
            <div>
                <label for="role" class="block text-sm font-semibold text-slate-700 mb-2">Peran Sistem <span class="text-rose-500">*</span></label>
                <select name="role" id="role" {{ $user->id === auth()->id() ? 'disabled' : '' }}
                        class="w-full px-3 py-2.5 text-sm bg-slate-50 border @error('role') border-rose-500 focus:ring-rose-500 @else border-slate-200 focus:ring-blue-500 @enderror rounded-xl focus:outline-none focus:ring-2 focus:border-transparent transition-all disabled:opacity-60 disabled:cursor-not-allowed">
                    <option value="panitia" {{ old('role', $user->role) === 'panitia' ? 'selected' : '' }}>Panitia (Peminjam Koleksi)</option>
                    <option value="staff" {{ old('role', $user->role) === 'staff' ? 'selected' : '' }}>Staf Kurator (Verifikator Peminjaman)</option>
                    <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Administrator (Akses Penuh)</option>
                </select>
                @if ($user->id === auth()->id())
                    <input type="hidden" name="role" value="{{ $user->role }}">
                    <p class="text-xs text-slate-400 mt-1.5 italic">Anda tidak bisa merubah peran Anda sendiri untuk menghindari lockout sistem.</p>
                @endif
                @error('role')
                    <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit Buttons -->
            <div class="flex items-center justify-end space-x-3 border-t border-slate-100 pt-6">
                <x-button href="{{ route('admin.users.index') }}" variant="secondary">
                    Batal
                </x-button>
                <x-button type="submit" variant="primary">
                    Update Pengguna
                </x-button>
            </div>
        </form>
    </x-card>
</div>
@endsection
