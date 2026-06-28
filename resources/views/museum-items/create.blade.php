@extends('layouts.app')

@section('title', 'Tambah Barang Museum')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Header -->
    <div class="flex items-center space-x-3">
        <a href="{{ route('admin.museum-items.index') }}" class="p-2 bg-white hover:bg-slate-50 border border-slate-200 text-slate-500 hover:text-slate-800 rounded-xl transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
        </a>
        <div>
            <h2 class="text-xl font-bold text-slate-800">Tambah Koleksi Baru</h2>
            <p class="text-sm text-slate-500">Isi formulir secara lengkap untuk mendaftarkan barang koleksi museum baru.</p>
        </div>
    </div>

    <!-- Form Card -->
    <x-card class="bg-white">
        <form method="POST" action="{{ route('admin.museum-items.store') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nama Barang -->
                <div>
                    <label for="nama_barang" class="block text-sm font-semibold text-slate-700 mb-2">Nama Barang <span class="text-rose-500">*</span></label>
                    <input type="text" name="nama_barang" id="nama_barang" value="{{ old('nama_barang') }}"
                           class="w-full px-4 py-2.5 text-sm bg-slate-50 border @error('nama_barang') border-rose-500 focus:ring-rose-500 @else border-slate-200 focus:ring-blue-500 @enderror rounded-xl focus:outline-none focus:ring-2 focus:border-transparent transition-all">
                    @error('nama_barang')
                        <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Kode Barang -->
                <div>
                    <label for="kode_barang" class="block text-sm font-semibold text-slate-700 mb-2">Kode Barang <span class="text-rose-500">*</span></label>
                    <input type="text" name="kode_barang" id="kode_barang" value="{{ old('kode_barang') }}" placeholder="Contoh: MUS-1021"
                           class="w-full px-4 py-2.5 text-sm bg-slate-50 border @error('kode_barang') border-rose-500 focus:ring-rose-500 @else border-slate-200 focus:ring-blue-500 @enderror rounded-xl focus:outline-none focus:ring-2 focus:border-transparent transition-all">
                    @error('kode_barang')
                        <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Kategori -->
                <div>
                    <label for="kategori" class="block text-sm font-semibold text-slate-700 mb-2">Kategori <span class="text-rose-500">*</span></label>
                    <input type="text" name="kategori" id="kategori" value="{{ old('kategori') }}" placeholder="Contoh: Senjata Tradisional, Arkeologi..."
                           class="w-full px-4 py-2.5 text-sm bg-slate-50 border @error('kategori') border-rose-500 focus:ring-rose-500 @else border-slate-200 focus:ring-blue-500 @enderror rounded-xl focus:outline-none focus:ring-2 focus:border-transparent transition-all">
                    @error('kategori')
                        <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Asal Barang -->
                <div>
                    <label for="asal" class="block text-sm font-semibold text-slate-700 mb-2">Asal Barang <span class="text-rose-500">*</span></label>
                    <input type="text" name="asal" id="asal" value="{{ old('asal') }}" placeholder="Contoh: Jawa Timur, Sumatra Barat..."
                           class="w-full px-4 py-2.5 text-sm bg-slate-50 border @error('asal') border-rose-500 focus:ring-rose-500 @else border-slate-200 focus:ring-blue-500 @enderror rounded-xl focus:outline-none focus:ring-2 focus:border-transparent transition-all">
                    @error('asal')
                        <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tahun Pembuatan -->
                <div>
                    <label for="tahun" class="block text-sm font-semibold text-slate-700 mb-2">Tahun / Abad <span class="text-rose-500">*</span></label>
                    <input type="text" name="tahun" id="tahun" value="{{ old('tahun') }}" placeholder="Contoh: Abad ke-13, Tahun 1910..."
                           class="w-full px-4 py-2.5 text-sm bg-slate-50 border @error('tahun') border-rose-500 focus:ring-rose-500 @else border-slate-200 focus:ring-blue-500 @enderror rounded-xl focus:outline-none focus:ring-2 focus:border-transparent transition-all">
                    @error('tahun')
                        <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status -->
                <div>
                    <label for="status" class="block text-sm font-semibold text-slate-700 mb-2">Status Barang <span class="text-rose-500">*</span></label>
                    <select name="status" id="status"
                            class="w-full px-3 py-2.5 text-sm bg-slate-50 border @error('status') border-rose-500 focus:ring-rose-500 @else border-slate-200 focus:ring-blue-500 @enderror rounded-xl focus:outline-none focus:ring-2 focus:border-transparent transition-all">
                        <option value="Tersedia" {{ old('status') === 'Tersedia' ? 'selected' : '' }}>Tersedia</option>
                        <option value="Dipinjam" {{ old('status') === 'Dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                        <option value="Perbaikan" {{ old('status') === 'Perbaikan' ? 'selected' : '' }}>Perbaikan</option>
                    </select>
                    @error('status')
                        <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Deskripsi -->
            <div>
                <label for="deskripsi" class="block text-sm font-semibold text-slate-700 mb-2">Deskripsi Barang</label>
                <textarea name="deskripsi" id="deskripsi" rows="4"
                          class="w-full px-4 py-2.5 text-sm bg-slate-50 border @error('deskripsi') border-rose-500 focus:ring-rose-500 @else border-slate-200 focus:ring-blue-500 @enderror rounded-xl focus:outline-none focus:ring-2 focus:border-transparent transition-all">{{ old('deskripsi') }}</textarea>
                @error('deskripsi')
                    <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Upload Foto -->
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Foto Barang</label>
                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-slate-200 border-dashed rounded-2xl bg-slate-50/50 hover:bg-slate-50 transition-colors">
                    <div class="space-y-1 text-center">
                        <svg class="mx-auto h-12 w-12 text-slate-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                            <path d="M28 8H12a4 4 0 00-4 4v20a4 4 0 004 4h20a4 4 0 004-4V20m-6-6h-6m-4-4H12a4 4 0 00-4 4v20a4 4 0 004 4h20a4 4 0 004-4V20" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <div class="flex text-sm text-slate-600">
                            <label for="foto" class="relative cursor-pointer bg-white rounded-md font-semibold text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                <span>Unggah file</span>
                                <input id="foto" name="foto" type="file" class="sr-only">
                            </label>
                            <p class="pl-1">atau seret dan lepas</p>
                        </div>
                        <p class="text-xs text-slate-400">PNG, JPG, JPEG, atau WEBP sampai 2MB</p>
                    </div>
                </div>
                @error('foto')
                    <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit Buttons -->
            <div class="flex items-center justify-end space-x-3 border-t border-slate-100 pt-6">
                <x-button href="{{ route('admin.museum-items.index') }}" variant="secondary">
                    Batal
                </x-button>
                <x-button type="submit" variant="primary">
                    Simpan Barang
                </x-button>
            </div>
        </form>
    </x-card>
</div>
@endsection
