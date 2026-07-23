 <!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Peminjaman Barang</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-light">

    <div class="container mt-5" style="max-width: 650px;">
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <h4 class="card-title fw-bold text-dark mb-1">Formulir Peminjaman Koleksi</h4>
                <p class="text-muted small mb-4">Silakan pilih artefak/barang museum yang berstatus tersedia untuk dikirimkan ke festival pameran luar.</p>
                <hr>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('loans.store') }}" method="POST">
                    @csrf 

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Pilih Barang Museum</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white"><i class="fa-solid fa-gem text-primary"></i></span>
                            <select name="item_id" class="form-select" required>
                                <option value="">-- Hanya Menampilkan Barang yang Tersedia --</option>
                                @foreach($items as $item)
                                    <option value="{{ $item->id }}">{{ $item->nama_barang }} (No. Reg: {{ $item->no_registrasi }})</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Target Festival Pameran</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white"><i class="fa-solid fa-tent text-success"></i></span>
                            <select name="festival_id" class="form-select" required>
                                <option value="">-- Pilih Festival Tujuan --</option>
                                @foreach($festivals as $fest)
                                    <option value="{{ $fest->id }}">{{ $fest->nama_festival }} (Lokasi: {{ $fest->lokasi }})</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Tanggal Mulai Peminjaman</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white"><i class="fa-solid fa-calendar-day text-danger"></i></span>
                            <input type="date" name="tanggal_pinjam" class="form-control" value="{{ date('Y-m-d') }}" required>
                        </div>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="{{ route('loans.index') }}" class="btn btn-light px-4 border">Batal</a>
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="fa-solid fa-paper-plane me-1"></i> Konfirmasi Peminjaman
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>

</body>
</html>