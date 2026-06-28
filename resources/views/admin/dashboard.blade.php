@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<div class="space-y-8">
    <!-- Header Welcome -->
    <div class="bg-gradient-to-r from-slate-800 to-slate-900 text-white rounded-3xl p-6 md:p-8 shadow-lg shadow-slate-900/10">
        <h2 class="text-2xl md:text-3xl font-extrabold mb-2">Selamat Datang, {{ auth()->user()->name }}!</h2>
        <p class="text-slate-300 max-w-xl text-sm md:text-base">Anda masuk sebagai Administrator. Kelola koleksi barang museum, akun pengguna sistem, dan monitor seluruh histori pengajuan dari dashboard ini.</p>
    </div>

    <!-- Statistics Section -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Barang -->
        <x-stat-card title="Total Barang Museum" value="{{ $stats['total_items'] }}" color="blue">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
            </svg>
        </x-stat-card>

        <!-- Barang Dipinjam -->
        <x-stat-card title="Barang Dipinjam" value="{{ $stats['borrowed_items'] }}" color="emerald">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
            </svg>
        </x-stat-card>

        <!-- Barang Perbaikan -->
        <x-stat-card title="Dalam Perbaikan" value="{{ $stats['repair_items'] }}" color="amber">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path>
            </svg>
        </x-stat-card>

        <!-- Total Pengajuan -->
        <x-stat-card title="Total Pengajuan" value="{{ $stats['total_requests'] }}" color="slate">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
            </svg>
        </x-stat-card>
    </div>

    <!-- Quick Management Shortcuts -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <x-card class="flex flex-col justify-between">
            <div>
                <h3 class="text-base font-bold text-slate-800 mb-2">Kelola Barang Museum</h3>
                <p class="text-slate-500 text-xs mb-4">Tambahkan barang baru, edit informasi koleksi, hapus data, upload foto, dan kelola status barang.</p>
            </div>
            <x-button href="{{ route('admin.museum-items.index') }}" variant="primary" class="w-full">
                Buka Manajemen Barang
            </x-button>
        </x-card>

        <x-card class="flex flex-col justify-between">
            <div>
                <h3 class="text-base font-bold text-slate-800 mb-2">Kelola Pengguna</h3>
                <p class="text-slate-500 text-xs mb-4">Buat akun untuk Staf Kurator dan Panitia Pameran baru. Edit data profil pengguna, reset kata sandi, atau hapus akun.</p>
            </div>
            <x-button href="{{ route('admin.users.index') }}" variant="secondary" class="w-full">
                Buka Manajemen User
            </x-button>
        </x-card>

        <x-card class="flex flex-col justify-between">
            <div>
                <h3 class="text-base font-bold text-slate-800 mb-2">Monitoring Pengajuan</h3>
                <p class="text-slate-500 text-xs mb-4">Pantau histori transaksi peminjaman barang secara menyeluruh dari seluruh kepanitiaan dalam format laporan (read-only).</p>
            </div>
            <x-button href="{{ route('admin.loan-requests.index') }}" variant="secondary" class="w-full">
                Buka Monitoring
            </x-button>
        </x-card>
    </div>
</div>
@endsection
