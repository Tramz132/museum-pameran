  <!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Peminjaman Barang Museum</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-light">

    <div class="container mt-5">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center py-3">
                <h5 class="mb-0"><i class="fa-solid fa-building-museum me-2"></i> Log Peminjaman Koleksi ke Festival</h5>
                <a href="{{ route('loans.create') }}" class="btn btn-light btn-sm fw-bold text-primary">
                    <i class="fa-solid fa-plus me-1"></i> Pinjamkan Barang
                </a>
            </div>
            <div class="card-body">
                
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th style="width: 5%">#</th>
                                <th style="width: 25%">Nama Barang</th>
                                <th style="width: 30%">Festival & Lokasi</th>
                                <th style="width: 20%">Tanggal Pinjam</th>
                                <th style="width: 20%">Status Barang</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($loans as $index => $loan)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <div class="fw-bold text-dark">{{ $loan->item->nama_barang }}</div>
                                    <small class="text-muted">Reg: {{ $loan->item->no_registrasi }}</small>
                                </td>
                                <td>
                                    <div class="fw-bold">{{ $loan->festival->nama_festival }}</div>
                                    <small class="text-muted"><i class="fa-solid fa-location-dot me-1"></i> {{ $loan->festival->lokasi }}</small>
                                </td>
                                <td>
                                    <i class="fa-solid fa-calendar-days text-secondary me-1"></i> 
                                    {{ \Carbon\Carbon::parse($loan->tanggal_pinjam)->translatedFormat('d F Y') }}
                                </td>
                                <td>
                                    @if($loan->item->status == 'dipinjam')
                                        <span class="badge bg-warning text-dark px-3 py-2"><i class="fa-solid fa-mask me-1"></i> Sedang Dipamerkan</span>
                                    @else
                                        <span class="badge bg-success px-3 py-2"><i class="fa-solid fa-box-archive me-1"></i> Kembali ke Gudang</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">
                                    <i class="fa-solid fa-folder-open display-6 d-block mb-2"></i>
                                    Belum ada data barang museum yang dipinjamkan ke festival.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>