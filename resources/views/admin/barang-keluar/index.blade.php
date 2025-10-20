@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-body p-4">
                <!-- Header -->
                <div class="d-flex justify-content-between align-items-center mb-5">
                    <h1 class="fw-bold text-danger mb-0 text-center shadow-text-red">
                        <i class="bi bi-box-arrow-up"></i> DAFTAR BARANG KELUAR
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
                    <table class="table table-striped table-bordered align-middle text-center shadow-sm w-100">
                        <thead style="background-color:hsl(200, 72%, 46%); color:white;">
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">ID Barang</th>
                                <th scope="col">Nama Barang</th>
                                <th scope="col">Jumlah Terpakai</th>
                                <th scope="col">Sisa Stok</th>
                                <th scope="col">Tanggal Keluar</th>
                                <th scope="col">Keterangan</th>
                                <th scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($barangKeluars as $bk)
                                <tr>
                                    <td class="fw-semibold">{{ $loop->iteration }}</td>
                                    <td>{{ $bk->barang->id ?? '-' }}</td>
                                    <td class="text-capitalize">{{ $bk->barang->nama_barang ?? ($bk->nama_barang ?? '-') }}
                                    </td>
                                    <td><span class="badge bg-primary px-3 py-2">{{ $bk->jumlah }}</span></td>
                                    <td>
                                        <span class="badge bg-success px-3 py-2">
                                            {{ $bk->sisa_stok ?? ($bk->barang->stok ?? 0) }}
                                        </span>
                                    </td>
                                    <td class="text-muted">
                                        {{ \Carbon\Carbon::parse($bk->tanggal_keluar)->format('d M Y') }}
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary px-3 py-2">{{ $bk->keterangan ?? '-' }}</span>
                                    </td>
                                    <td>
                                        <form action="{{ route('admin.barang-keluar.destroy', $bk->id) }}" method="POST"
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
                                        <p class="mt-2 mb-0">Belum ada data barang keluar 📤</p>
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

        /* Header */
        .shadow-text-red {
            font-size: 2rem;
            font-weight: 900;
            text-shadow: 2px 2px 5px rgba(220, 53, 69, 0.3);
            letter-spacing: 1px;
        }

        table {
            border-collapse: collapse;
            border-spacing: 0;
            width: 100%;
        }

        table th,
        table td {
            padding: 12px 15px;
            font-size: 0.95rem;
            vertical-align: middle;
            border: 1px solid #dee2e6;
        }

        table tbody tr:hover {
            transition: 0.2s;
        }

        .badge {
            font-size: 0.9rem;
            border-radius: 0.5rem;
            padding: 0.4em 0.6em;
        }
    </style>
@endsection
