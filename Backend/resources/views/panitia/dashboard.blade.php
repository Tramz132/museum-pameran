@extends('layouts.app')

@section('title', 'Dashboard Panitia')

@section('content')
<div class="space-y-8">
    <!-- Header Welcome -->
    <div class="bg-gradient-to-r from-blue-600 to-indigo-700 text-white rounded-3xl p-6 md:p-8 shadow-lg shadow-blue-500/10">
        <h2 class="text-2xl md:text-3xl font-extrabold mb-2">Selamat Datang, {{ auth()->user()->name }}!</h2>
        <p class="text-blue-100 max-w-xl text-sm md:text-base">Anda masuk sebagai Panitia Pameran. Gunakan dashboard ini untuk mengajukan peminjaman koleksi museum dan memantau status persetujuan.</p>
    </div>

    <!-- Statistics Section -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Barang -->
        <x-stat-card title="Total Koleksi" value="{{ $stats['total_items'] }}" color="slate">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
            </svg>
        </x-stat-card>

        <!-- Barang Tersedia -->
        <x-stat-card title="Barang Tersedia" value="{{ $stats['available_items'] }}" color="emerald">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </x-stat-card>

        <!-- Pengajuan Saya -->
        <x-stat-card title="Pengajuan Saya" value="{{ $stats['my_requests'] }}" color="blue">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
            </svg>
        </x-stat-card>

        <!-- Pengajuan Disetujui -->
        <x-stat-card title="Pengajuan Disetujui" value="{{ $stats['my_approved_requests'] }}" color="emerald">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
        </x-stat-card>
    </div>

    <!-- Quick Actions Card -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <x-card class="flex flex-col justify-between">
            <div>
                <h3 class="text-lg font-bold text-slate-800 mb-2">Ajukan Peminjaman Barang</h3>
                <p class="text-slate-500 text-sm mb-6">Jelajahi seluruh koleksi museum yang tersedia untuk pameran eksternal Anda. Daftarkan peminjaman secara online dengan cepat dan mudah.</p>
            </div>
            <x-button href="{{ route('panitia.catalog') }}" variant="primary" class="w-full sm:w-auto">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
                Lihat Katalog Koleksi
            </x-button>
        </x-card>

        <x-card class="flex flex-col justify-between">
            <div>
                <h3 class="text-lg font-bold text-slate-800 mb-2">Riwayat Pengajuan</h3>
                <p class="text-slate-500 text-sm mb-6">Pantau status pengajuan peminjaman barang Anda. Lihat apakah pengajuan Anda disetujui, ditolak, atau masih diproses oleh staf kurator.</p>
            </div>
            <x-button href="{{ route('panitia.loan-requests.index') }}" variant="secondary" class="w-full sm:w-auto">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Lihat Riwayat Pengajuan
            </x-button>
        </x-card>
    </div>
</div>
@endsection
