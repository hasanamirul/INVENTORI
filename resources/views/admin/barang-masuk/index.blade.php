@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-body p-4">
                <!-- Header -->
                <div class="d-flex justify-content-between align-items-center mb-5">
                    <h1 class="fw-bold text-danger mb-0 text-center shadow-text-red">
                        <i class="bi bi-box-arrow-in-down"></i> DAFTAR BARANG MASUK
                    </h1>
                </div>

                <!-- Alert -->
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                        <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                        <i class="bi bi-x-circle-fill me-2"></i>{{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <!-- Tabel -->
                <div class="table-responsive mt-4">
                    <table class="table table-striped table-bordered align-middle text-center shadow-sm">
                        <thead class="bg-danger text-white">
                            <tr>
                                <th>No</th>
                                <th>ID Barang</th>
                                <th>Nama Barang</th>
                                <th>Jumlah Masuk</th>
                                <th>Tanggal Masuk</th>
                                <th>Keterangan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($barangMasuks as $bm)
                                <tr>
                                    <td class="fw-semibold">{{ $loop->iteration }}</td>
                                    <td>{{ $bm->barang->id ?? '-' }}</td>
                                    <td class="text-capitalize">{{ $bm->barang->nama_barang ?? ($bm->nama_barang ?? '-') }}
                                    </td>
                                    <td>
                                        <span class="badge bg-primary px-3 py-2">{{ $bm->jumlah }}</span>
                                    </td>
                                    <td class="text-muted">
                                        {{ \Carbon\Carbon::parse($bm->tanggal_masuk)->format('d M Y') }}
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary px-3 py-2">
                                            {{ str_replace('Stok Awal Barang Baru: ', '', $bm->keterangan) ?? '-' }}
                                        </span>
                                    </td>
                                    <td>
                                        <form action="{{ route('admin.barang-masuk.destroy', $bm->id) }}" method="POST"
                                            style="display:inline-block;">
                                            @csrf @method('DELETE')
                                            <button onclick="return confirm('Yakin hapus data?')"
                                                class="btn btn-delete px-3 py-2 shadow-sm">
                                                <i class="bi bi-trash"></i> Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center text-muted py-5">
                                        <i class="bi bi-inbox fs-3"></i>
                                        <p class="mt-2 mb-0">Belum ada data barang masuk 📥</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Tombol */
        .btn-delete {
            background: linear-gradient(135deg, #dc3545, #e55360);
            color: #fff;
            font-weight: 600;
            border-radius: 0.5rem;
        }

        .btn-delete:hover {
            background: linear-gradient(135deg, #b02a37, #d6334c);
            color: #fff;
        }

        /* Header Judul */
        .shadow-text-red {
            font-size: 2rem;
            font-weight: 900;
            text-shadow: 2px 2px 5px rgba(220, 53, 69, 0.3);
            letter-spacing: 1px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        table th,
        table td {
            padding: 12px 15px;
            font-size: 0.95rem;
            vertical-align: middle;
            border: 1px solid #dee2e6;
            /* biar antar kolom keliatan */
        }

        /* Style khusus untuk thead */
        thead th {
            background: hsl(200, 72%, 46%);
            color: #fff;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-weight: 700;
        }

        table tbody tr:hover {
            background-color: #fff5f5;
            transition: 0.2s;
        }

        .badge {
            font-size: 0.9rem;
            border-radius: 0.5rem;
            padding: 0.4em 0.6em;
        }
    </style>
@endsection
