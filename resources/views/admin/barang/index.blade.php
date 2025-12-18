@extends('admin.layouts.app')

@section('content')
<div class="container-fluid responsive-container">
    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-body p-3 p-md-4">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4 mb-md-5 flex-wrap">
                <h1 class="fw-bold text-success shadow-text-green mb-3 mb-md-0">
                    <i class="bi bi-box-seam"></i> DAFTAR BARANG
                </h1>
                <a href="{{ route('admin.barang.create') }}" class="btn btn-add px-3 px-md-4 py-2 mt-2 mt-md-0">
                    <i class="bi bi-plus-circle"></i> Tambah Barang
                </a>
            </div>

            <!-- Alert -->
            @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            <!-- Tabel Responsif -->
            <div class="table-wrapper">
                <div class="table-scroll">
                    <table class="table table-striped table-bordered align-middle shadow-sm w-100">
                        <thead class="bg-cyan-600 text-white">
                            <tr>
                                <th class="text-center col-no">No</th>
                                <th class="text-center col-img">Gambar</th>
                                <th class="text-center col-name">Nama Barang</th>
                                <th class="text-center col-cat">Kategori</th>
                                <th class="text-center col-sat">Satuan</th>
                                <th class="text-center col-qty">Jumlah</th>
                                <th class="text-center col-status">Status & Terpakai</th>
                                <th class="text-center col-desc">Keterangan</th>
                                <th class="text-center col-act">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($barangs as $barang)
                            <tr>
                                <td class="fw-semibold text-center">{{ $loop->iteration }}</td>
                                <td class="text-center">
                                    @if(!empty($barang->gambar))
                                        <img
                                            src="{{ asset('storage/' . $barang->gambar) }}"
                                            alt="gambar"
                                            class="img-thumb"
                                            data-image="{{ asset('storage/' . $barang->gambar) }}"
                                            data-name="{{ $barang->nama }}"
                                            data-kategori="{{ $barang->kategori->nama ?? '-' }}"
                                            data-satuan="{{ $barang->satuan ?? '-' }}"
                                            data-jumlah="{{ $barang->jumlah }}"
                                            data-status="{{ $barang->status ?? '-' }}"
                                            data-terpakai="{{ $barang->terpakai ?? 0 }}"
                                            data-tanggal="{{ $barang->tanggal ?? '-' }}"
                                            data-keterangan="{{ $barang->keterangan ?? '-' }}"
                                        >
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="text-center text-capitalize">{{ $barang->nama }}</td>
                                <td class="text-center">
                                    <span class="badge bg-info text-dark px-2 px-md-3 py-1 py-md-2">{{ $barang->kategori->nama ?? '-' }}</span>
                                </td>
                                <td class="text-center">{{ $barang->satuan }}</td>
                                <td class="text-center">
                                    <span class="badge bg-primary px-2 px-md-3 py-1 py-md-2">{{ $barang->jumlah }}</span>
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
                                            placeholder="Qty"
                                            style="min-width:60px;">
                                        <button type="submit" class="btn btn-use flex-shrink-0 px-2 px-md-4 py-2">Pakai</button>
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
                                    <div class="action-buttons">
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
                                <td colspan="9" class="text-center text-muted py-5">
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
    /* ===== RESPONSIVE CONTAINER ===== */
    .responsive-container {
        padding: 0.5rem;
    }

    /* Header */
    .shadow-text-green {
        font-size: 2rem;
        font-weight: 900;
        text-shadow: 2px 2px 5px rgba(0, 128, 0, 0.3);
        text-align: center;
    }

    /* Tombol Tambah */
    .btn-add {
        background: linear-gradient(135deg, #0d6efd, #00c6ff);
        color: white;
        font-weight: 600;
        border-radius: .5rem;
        border: none;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        white-space: nowrap;
    }
    .btn-add:hover {
        background: linear-gradient(135deg, #0a58ca, #00b4e6);
        color: #fff;
        transform: translateY(-2px);
    }

    /* Tombol Pakai */
    .btn-use {
        background: linear-gradient(135deg, #28a745, #5ddc8a);
        color: white;
        font-weight: 600;
        border-radius: .5rem;
        border: none;
        font-size: 0.9rem;
        transition: all 0.3s ease;
        white-space: nowrap;
    }

    .btn-use:hover {
        background: linear-gradient(135deg, #218838, #45b866);
        transform: translateY(-2px);
    }

    /* Tombol Batalkan */
    .btn-cancel {
        background: linear-gradient(135deg, #dc3545, #e55360);
        color: white;
        font-weight: 600;
        border-radius: .5rem;
        border: none;
        font-size: 0.9rem;
        transition: all 0.3s ease;
        white-space: nowrap;
    }

    .btn-cancel:hover {
        background: linear-gradient(135deg, #bb2d3b, #d33f4c);
        transform: translateY(-2px);
    }

    /* Tombol Edit & Hapus */
    .btn-edit,
    .btn-delete {
        display: inline-block;
        font-weight: 600;
        border-radius: .5rem;
        font-size: 0.85rem;
        padding: 6px 10px;
        text-align: center;
        border: none;
        transition: all 0.3s ease;
        white-space: nowrap;
    }

    .btn-edit {
        background: linear-gradient(135deg, #ffc107, #ffca2c);
        color: #212529;
    }

    .btn-edit:hover {
        background: linear-gradient(135deg, #e0a800, #ffb700);
        transform: translateY(-2px);
    }

    .btn-delete {
        background: linear-gradient(135deg, #dc3545, #e55360);
        color: white;
    }

    .btn-delete:hover {
        background: linear-gradient(135deg, #bb2d3b, #d33f4c);
        transform: translateY(-2px);
    }

    /* Tabel Scroll Wrapper */
    .table-wrapper {
        width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        border-radius: .5rem;
        background: #fff;
    }

    /* Table Scroll */
    .table-scroll {
        width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    /* Custom scrollbar */
    .table-scroll::-webkit-scrollbar {
        height: 8px;
    }

    .table-scroll::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    .table-scroll::-webkit-scrollbar-thumb {
        background-color: #0d6efd;
        border-radius: 10px;
    }

    .table {
        width: 100%;
        border-collapse: collapse;
        table-layout: auto;
        min-width: 600px;
    }

    /* Gambar thumbnail */
    .img-thumb {
        width: 50px;
        height: 50px;
        object-fit: cover;
        border-radius: 6px;
        cursor: pointer;
        transition: transform 0.3s ease;
    }

    .img-thumb:hover {
        transform: scale(1.1);
    }

    /* Action buttons wrapper */
    .action-buttons {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .action-buttons .btn {
        min-width: auto;
    }

    /* Table cells padding and alignment */
    .table th, .table td {
        vertical-align: middle;
        padding: 10px 8px;
        border: 1px solid #dee2e6;
    }

    .table td.text-start {
        text-align: left;
    }

    /* ===== TABLET (md breakpoint) ===== */
    @media (min-width: 768px) and (max-width: 1024px) {
        .shadow-text-green {
            font-size: 1.75rem;
        }

        .btn-add {
            width: auto;
        }

        .table th, .table td {
            padding: 10px 8px;
            font-size: 0.9rem;
        }

        .img-thumb {
            width: 45px;
            height: 45px;
        }

        .btn-edit,
        .btn-delete {
            font-size: 0.8rem;
            padding: 5px 8px;
        }
    }

    /* ===== MOBILE (sm breakpoint) ===== */
    @media (max-width: 767px) {
        .responsive-container {
            padding: 0.25rem;
        }

        .shadow-text-green {
            font-size: 1.3rem;
            margin-bottom: 1rem;
        }

        .btn-add {
            width: 100%;
            justify-content: center;
            font-size: 0.9rem;
            padding: 0.5rem 1rem;
        }

        .table {
            font-size: 0.85rem;
            min-width: 100%;
        }

        .table th, .table td {
            padding: 8px 6px;
            font-size: 0.8rem;
        }

        .table th {
            font-size: 0.75rem;
        }

        .img-thumb {
            width: 40px;
            height: 40px;
        }

        .badge {
            font-size: 0.75rem;
            padding: 0.35rem 0.6rem !important;
        }

        .btn-edit,
        .btn-delete {
            font-size: 0.75rem;
            padding: 4px 6px;
            min-width: 100%;
            margin: 2px 0;
        }

        .btn-use,
        .btn-cancel {
            font-size: 0.8rem;
            padding: 0.4rem 0.6rem;
        }

        .action-buttons {
            gap: 5px;
        }

        .form-mobile {
            flex-direction: row;
            padding: 0.75rem !important;
        }

        .form-mobile input {
            font-size: 0.8rem !important;
            padding: 0.4rem !important;
        }

        .form-mobile .btn {
            font-size: 0.8rem;
            padding: 0.4rem 0.6rem;
        }

        .table-scroll {
            margin-right: -0.25rem;
            margin-left: -0.25rem;
        }
    }

    /* ===== VERY SMALL MOBILE (xs breakpoint) ===== */
    @media (max-width: 480px) {
        .shadow-text-green {
            font-size: 1.1rem;
        }

        .table {
            font-size: 0.75rem;
        }

        .table th, .table td {
            padding: 6px 4px;
            font-size: 0.7rem;
        }

        .img-thumb {
            width: 35px;
            height: 35px;
        }

        .badge {
            font-size: 0.65rem;
        }

        .btn-edit,
        .btn-delete,
        .btn-use,
        .btn-cancel {
            font-size: 0.7rem;
            padding: 3px 5px;
        }

        .form-mobile {
            flex-wrap: wrap;
        }

        .form-mobile input {
            min-width: 50px;
        }

        .btn-add {
            font-size: 0.85rem;
            padding: 0.4rem 0.8rem;
        }
    }

    /* ===== LANDSCAPE MODE ===== */
    @media (max-height: 500px) and (orientation: landscape) {
        .shadow-text-green {
            font-size: 1.2rem;
            margin-bottom: 0.5rem;
        }

        .card-body {
            padding: 0.5rem !important;
        }

        .table th, .table td {
            padding: 6px 4px;
        }
    }
</style>
@endsection
