@extends('layouts.app')

@section('title', 'Dashboard Staf')

@section('content')
<div class="space-y-8">
    <!-- Header Welcome -->
    <div class="bg-gradient-to-r from-emerald-600 to-teal-700 text-white rounded-3xl p-6 md:p-8 shadow-lg shadow-emerald-500/10">
        <h2 class="text-2xl md:text-3xl font-extrabold mb-2">Selamat Datang, {{ auth()->user()->name }}!</h2>
        <p class="text-emerald-100 max-w-xl text-sm md:text-base">Anda masuk sebagai Staf Kurator. Tugas utama Anda adalah memverifikasi, menyetujui, atau menolak pengajuan peminjaman barang museum untuk kegiatan pameran eksternal.</p>
    </div>

    <!-- Statistics Section -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Pending -->
        <x-stat-card title="Pengajuan Pending" value="{{ $stats['pending_requests'] }}" color="amber">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </x-stat-card>

        <!-- Approved -->
        <x-stat-card title="Pengajuan Disetujui" value="{{ $stats['approved_requests'] }}" color="emerald">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </x-stat-card>

        <!-- Rejected -->
        <x-stat-card title="Pengajuan Ditolak" value="{{ $stats['rejected_requests'] }}" color="rose">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </x-stat-card>

        <!-- Total Pengajuan -->
        <x-stat-card title="Total Pengajuan" value="{{ $stats['total_requests'] }}" color="slate">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
            </svg>
        </x-stat-card>
    </div>

    <!-- Verifikasi Section Shortcut -->
    <x-card class="bg-white border border-slate-100 rounded-2xl shadow-sm p-6 flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0">
        <div>
            <h3 class="text-lg font-bold text-slate-800 mb-1">Verifikasi Pengajuan Peminjaman</h3>
            <p class="text-slate-500 text-sm">Ada <span class="font-semibold text-amber-600">{{ $stats['pending_requests'] }}</span> pengajuan baru yang butuh persetujuan Anda segera.</p>
        </div>
        <x-button href="{{ route('staff.verifications.index') }}" variant="primary" class="relative">
            Mulai Verifikasi
            @if ($stats['pending_requests'] > 0)
                <span class="absolute -top-1.5 -right-1.5 flex h-3.5 w-3.5">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-rose-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-3.5 w-3.5 bg-rose-500"></span>
                </span>
            @endif
        </x-button>
    </x-card>
</div>
@endsection
