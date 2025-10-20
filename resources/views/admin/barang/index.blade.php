@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-body p-4">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-5 flex-wrap text-center text-md-start">
                <h1 class="fw-bold text-success mb-3 mb-md-0 shadow-text-green w-100 w-md-auto">
                    <i class="bi bi-box-seam"></i> DAFTAR BARANG
                </h1>
                <a href="{{ route('admin.barang.create') }}" class="btn btn-add px-4 py-2">Tambah Barang</a>
            </div>

            <!-- Alert -->
            @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            <!-- 🌐 Tabel dengan Scroll Horizontal -->
            <div class="table-wrapper">
                <div class="table-scroll">
                    <table class="table table-striped table-bordered align-middle shadow-sm w-100">
                        <thead class="bg-cyan-600 text-white">
                            <tr>
                                <th class="text-center">No</th>
                                <th class="text-start">Nama Barang</th>
                                <th class="text-start">Kategori</th>
                                <th class="text-center">Satuan</th>
                                <th class="text-center">Jumlah</th>
                                <th class="text-start">Status & Terpakai</th>
                                <th class="text-start">Keterangan</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($barangs as $barang)
                            <tr>
                                <td class="fw-semibold text-center">{{ $loop->iteration }}</td>
                                <td class="text-center text-capitalize">{{ $barang->nama }}</td>
                                <td class="text-center">
                                    <span class="badge bg-info text-dark px-3 py-2">{{ $barang->kategori->nama ?? '-' }}</span>
                                </td>
                                <td class="text-center">{{ $barang->satuan }}</td>
                                <td class="text-center">
                                    <span class="badge bg-primary px-3 py-2">{{ $barang->jumlah }}</span>
                                </td>
                                <td class="text-start">
                                    <div><strong>Status:</strong> {{ $barang->status }}</div>
                                    @if ($barang->terpakai > 0)
                                    <div class="text-muted mt-1 small">Terpakai:
                                        <strong>{{ $barang->terpakai }}</strong> {{ $barang->satuan }}
                                    </div>
                                    @endif

                                    <!-- Form Pakai -->
                                    <form action="{{ route('admin.barang.pakai', $barang->id) }}" method="POST"
                                        class="mt-2 d-flex align-items-center gap-2 flex-wrap border border-success rounded p-2 bg-light-subtle form-mobile">
                                        @csrf
                                        <input type="number" name="jumlah_pakai" min="1" max="{{ $barang->jumlah }}" required
                                            class="form-control border border-primary flex-grow-1"
                                            style="max-width:90px;">
                                        <button type="submit" class="btn btn-use flex-shrink-0 px-4 py-2">Pakai</button>
                                    </form>

                                    <!-- Form Batalkan -->
                                    @if ($barang->terpakai > 0)
                                    <form action="{{ route('admin.barang.batalkan', $barang->id) }}" method="POST"
                                        class="mt-2 d-flex align-items-center gap-2 flex-wrap border border-danger rounded p-2 bg-light-subtle form-mobile">
                                        @csrf
                                        <input type="number" name="jumlah_batal" min="1" max="{{ $barang->terpakai }}" required
                                            class="form-control border border-danger flex-grow-1"
                                            style="max-width:90px;">
                                        <button type="submit" class="btn btn-cancel flex-shrink-0 px-4 py-2">Batalkan</button>
                                    </form>
                                    @endif
                                </td>
                                <td class="text-center">{{ $barang->keterangan ?? '-' }}</td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center align-items-center gap-2 flex-wrap">
                                        <a href="{{ route('admin.barang.edit', $barang->id) }}"
                                            class="btn btn-edit shadow-sm">
                                            <i class="bi bi-pencil-square"></i> Edit
                                        </a>
                                        <form action="{{ route('admin.barang.destroy', $barang->id) }}" method="POST"
                                            class="m-0">
                                            @csrf @method('DELETE')
                                            <button onclick="return confirm('Yakin hapus data?')" class="btn btn-delete shadow-sm">
                                                <i class="bi bi-trash"></i> Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted py-5">
                                    <i class="bi bi-inbox fs-3"></i>
                                    <p class="mt-2 mb-0">Belum ada data barang 📦</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Header */
    .shadow-text-green {
        font-size: 2rem;
        font-weight: 900;
        text-shadow: 2px 2px 5px rgba(0, 128, 0, 0.3);
    }

    /* Tombol Tambah */
    .btn-add {
        background: linear-gradient(135deg, #0d6efd, #00c6ff);
        color: white;
        font-weight: 600;
        border-radius: .5rem;
    }
    .btn-add:hover {
        background: linear-gradient(135deg, #0a58ca, #00b4e6);
        color: #fff;
    }

    /* Tombol Pakai */
    .btn-use {
        background: linear-gradient(135deg, #28a745, #5ddc8a);
        color: white;
        font-weight: 600;
        border-radius: .5rem;
        font-size: 1rem;
    }

    .btn-use:hover {
        background: linear-gradient(135deg, #218838, #45b866);
    }

    /* Tombol Batalkan */
    .btn-cancel {
        background: linear-gradient(135deg, #dc3545, #e55360);
        color: white;
        font-weight: 600;
        border-radius: .5rem;
        font-size: 1rem;
    }

    .btn-cancel:hover {
        background: linear-gradient(135deg, #bb2d3b, #d33f4c);
    }

    /* Tombol Edit & Hapus */
    .btn-edit,
    .btn-delete {
        min-width: 110px;
        font-weight: 600;
        border-radius: .5rem;
        font-size: 0.95rem;
        padding: 8px 12px;
        text-align: center;
    }

    .btn-edit {
        background: linear-gradient(135deg, #ffc107, #ffca2c);
        color: #212529;
    }

    .btn-edit:hover {
        background: linear-gradient(135deg, #e0a800, #ffb700);
    }

    .btn-delete {
        background: linear-gradient(135deg, #dc3545, #e55360);
        color: white;
    }

    .btn-delete:hover {
        background: linear-gradient(135deg, #bb2d3b, #d33f4c);
    }

    /* Tabel Scroll Wrapper */
    .table-wrapper {
        width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        border-radius: .5rem;
        background: #fff;
    }

    /* ✅ Perbaikan untuk tampilan desktop agar tabel full kanan */
    .table-scroll {
        width: 100%;
        overflow-x: visible;
    }

    .table {
        width: 100%;
        border-collapse: collapse;
        table-layout: auto;
    }

    .table th, .table td {
        vertical-align: middle;
        padding: 11px 14px;
        border: 1px solid #dee2e6;
        white-space: nowrap;
    }

    .table td.text-start {
        text-align: left;
    }

    /* 🌐 Mobile Enhancement */
    @media (max-width: 768px) {
        .shadow-text-green {
            font-size: 1.5rem;
            text-align: center;
        }

        .btn-add {
            width: 100%;
            margin-top: 10px;
        }

        .table-scroll {
            overflow-x: auto;
            scrollbar-width: thin;
        }

        .table-scroll::-webkit-scrollbar {
            height: 8px;
        }

        .table-scroll::-webkit-scrollbar-thumb {
            background-color: #0d6efd;
            border-radius: 10px;
        }
    }
</style>
@endsection
