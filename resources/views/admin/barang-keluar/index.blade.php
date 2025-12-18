@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid responsive-container">
        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-body p-3 p-md-4">
                <!-- Header -->
                <div class="d-flex justify-content-between align-items-center mb-4 mb-md-5 flex-wrap">
                    <h1 class="fw-bold text-danger shadow-text-red mb-3 mb-md-0">
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
                <div class="table-wrapper">
                    <div class="table-scroll">
                        <table class="table table-striped table-bordered align-middle shadow-sm w-100">
                            <thead class="bg-cyan-600 text-white">
                                <tr>
                                    <th scope="col" class="text-center">No</th>
                                    <th scope="col" class="text-center">Gambar</th>
                                    <th scope="col" class="text-center">ID Barang</th>
                                    <th scope="col" class="text-center">Nama Barang</th>
                                    <th scope="col" class="text-center">Jumlah Terpakai</th>
                                    <th scope="col" class="text-center">Sisa Stok</th>
                                    <th scope="col" class="text-center">Tanggal Keluar</th>
                                    <th scope="col" class="text-center">Keterangan</th>
                                    <th scope="col" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                        <tbody>
                            @forelse($barangKeluars as $bk)
                                <tr>
                                    <td class="fw-semibold text-center">{{ $loop->iteration }}</td>
                                    <td class="text-center">
                                        @if(!empty($bk->barang->gambar))
                                            <img
                                                src="{{ asset('storage/' . $bk->barang->gambar) }}"
                                                alt="gambar"
                                                class="img-thumb"
                                                data-image="{{ asset('storage/' . $bk->barang->gambar) }}"
                                                data-name="{{ $bk->barang->nama_barang ?? ($bk->nama_barang ?? '-') }}"
                                                data-kategori="{{ $bk->barang->kategori->nama ?? '-' }}"
                                                data-satuan="{{ $bk->barang->satuan ?? '-' }}"
                                                data-jumlah="{{ $bk->jumlah }}"
                                                data-tanggal="{{ $bk->tanggal_keluar }}"
                                                data-keterangan="{{ $bk->keterangan ?? '-' }}"
                                            >
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="text-center">{{ $bk->barang->id ?? '-' }}</td>
                                    <td class="text-center text-capitalize">{{ $bk->barang->nama_barang ?? ($bk->nama_barang ?? '-') }}
                                    </td>
                                    <td class="text-center"><span class="badge bg-primary px-2 px-md-3 py-1 py-md-2">{{ $bk->jumlah }}</span></td>
                                    <td class="text-center">
                                        <span class="badge bg-success px-2 px-md-3 py-1 py-md-2">
                                            {{ $bk->sisa_stok ?? ($bk->barang->stok ?? 0) }}
                                        </span>
                                    </td>
                                    <td class="text-center text-muted">
                                        {{ \Carbon\Carbon::parse($bk->tanggal_keluar)->format('d M Y') }}
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-secondary px-2 px-md-3 py-1 py-md-2">{{ $bk->keterangan ?? '-' }}</span>
                                    </td>
                                    <td class="text-center">
                                        <form action="{{ route('admin.barang-keluar.destroy', $bk->id) }}" method="POST"
                                            style="display:inline-block;">
                                            @csrf @method('DELETE')
                                            <button onclick="return confirm('Yakin hapus data?')"
                                                class="btn btn-delete px-2 px-md-3 py-1 py-md-2 shadow-sm">
                                                <i class="bi bi-trash"></i> Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                            <tr>
                                <td colspan="9" class="text-center text-muted py-5">
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
    </div>

<style>
    /* ===== RESPONSIVE CONTAINER ===== */
    .responsive-container {
        padding: 0.5rem;
    }

    /* Header */
    .shadow-text-red {
        font-size: 2rem;
        font-weight: 900;
        text-shadow: 2px 2px 5px rgba(220, 53, 69, 0.3);
        text-align: center;
    }

    /* Tombol Hapus */
    .btn-delete {
        background: linear-gradient(135deg, #dc3545, #e55360);
        color: white;
        font-weight: 600;
        border-radius: .5rem;
        border: none;
        transition: all 0.3s ease;
        display: inline-block;
        white-space: nowrap;
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
        background-color: #dc3545;
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

    /* Table cells padding and alignment */
    .table th, .table td {
        vertical-align: middle;
        padding: 10px 8px;
        border: 1px solid #dee2e6;
    }

    /* Badge styling */
    .badge {
        font-size: 0.85rem;
        border-radius: .5rem;
    }

    /* ===== TABLET (md breakpoint) ===== */
    @media (min-width: 768px) and (max-width: 1024px) {
        .shadow-text-red {
            font-size: 1.75rem;
        }

        .table th, .table td {
            padding: 10px 8px;
            font-size: 0.9rem;
        }

        .img-thumb {
            width: 45px;
            height: 45px;
        }

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

        .shadow-text-red {
            font-size: 1.3rem;
            margin-bottom: 1rem;
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
            padding: 0.35rem 0.6rem;
        }

        .btn-delete {
            font-size: 0.75rem;
            padding: 4px 6px;
            min-width: auto;
        }

        .table-scroll {
            margin-right: -0.25rem;
            margin-left: -0.25rem;
        }
    }

    /* ===== VERY SMALL MOBILE (xs breakpoint) ===== */
    @media (max-width: 480px) {
        .shadow-text-red {
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

        .btn-delete {
            font-size: 0.7rem;
            padding: 3px 5px;
        }
    }

    /* ===== LANDSCAPE MODE ===== */
    @media (max-height: 500px) and (orientation: landscape) {
        .shadow-text-red {
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
