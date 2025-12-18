@extends('admin.layouts.app')

@section('title', 'Laporan Barang')

@section('content')
    <div class="container-fluid responsive-container">
        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-body p-3 p-md-4">

                <!-- Header -->
                <div class="d-flex justify-content-between align-items-center mb-4 mb-md-5 flex-wrap">
                    <h1 class="fw-bold text-success shadow-text-green mb-3 mb-md-0">
                        📊 LAPORAN BARANG
                    </h1>
                </div>

                <!-- Filter -->
                <form method="GET" action="{{ route('admin.laporan.index') }}" class="row g-2 g-md-3 mb-4">
                    <div class="col-12 col-sm-6 col-md-3">
                        <label class="form-label fw-semibold mb-2">📅 Dari Tanggal</label>
                        <input type="date" name="from" value="{{ request('from') }}" class="form-control form-control-sm">
                    </div>
                    <div class="col-12 col-sm-6 col-md-3">
                        <label class="form-label fw-semibold mb-2">📅 Sampai Tanggal</label>
                        <input type="date" name="to" value="{{ request('to') }}" class="form-control form-control-sm">
                    </div>
                    <div class="col-12 col-sm-6 col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-filter btn-sm w-100 px-2 px-md-4 py-2">
                            <i class="bi bi-funnel"></i> <span class="d-none d-md-inline">Filter</span>
                        </button>
                    </div>
                    <div class="col-12 col-sm-6 col-md-4 d-flex align-items-end gap-2 flex-wrap">

                        <!-- Tombol overlay Excel -->
                        <label for="excelToggle" class="btn btn-excel btn-sm px-2 px-md-4 py-2 flex-grow-1 flex-md-grow-0">
                            <i class="bi bi-file-earmark-excel"></i> <span class="d-none d-sm-inline">Excel</span>
                        </label>
                        <input type="checkbox" id="excelToggle" class="overlay-toggle" />
                        <div class="overlay">
                            <div class="overlay-content">
                                <div class="overlay-header bg-success text-white">
                                    Preview Laporan Excel
                                </div>
                                <div class="overlay-body p-3">
                                    <iframe src="{{ route('admin.laporan.previewExcel', request()->only('from', 'to')) }}"
                                        width="100%" height="100%"></iframe>
                                </div>
                                <div class="overlay-footer">
                                    <a href="{{ route('admin.laporan.exportExcel', request()->only('from', 'to')) }}"
                                        class="btn btn-excel px-4 py-2">
                                        <i class="bi bi-download"></i> Download Excel
                                    </a>
                                    <label for="excelToggle" class="btn btn-secondary px-4 py-2">Tutup</label>
                                </div>
                            </div>
                        </div>

                        <!-- Tombol overlay PDF -->
                        <label for="pdfToggle" class="btn btn-pdf btn-sm px-2 px-md-4 py-2 flex-grow-1 flex-md-grow-0">
                            <i class="bi bi-file-earmark-pdf"></i> <span class="d-none d-sm-inline">PDF</span>
                        </label>
                        <input type="checkbox" id="pdfToggle" class="overlay-toggle" />
                        <div class="overlay">
                            <div class="overlay-content">
                                <div class="overlay-header bg-danger text-white">
                                    Preview Laporan PDF
                                </div>
                                <div class="overlay-body">
                                    <iframe src="{{ route('admin.laporan.previewPdf', request()->only('from', 'to')) }}"
                                        width="100%" height="100%"></iframe>
                                </div>
                                <div class="overlay-footer">
                                    <a href="{{ route('admin.laporan.exportPdf', request()->only('from', 'to')) }}"
                                        class="btn btn-pdf px-4 py-2">
                                        <i class="bi bi-download"></i> Download PDF
                                    </a>
                                    <label for="pdfToggle" class="btn btn-secondary px-4 py-2">Tutup</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

                <div class="mt-4 mb-3">
                    <h2 class="fw-bold text-success mb-0"><i class="bi bi-arrow-down-circle"></i> BARANG MASUK</h2>
                </div>

                <!-- Barang Masuk -->
                <div class="card mb-4 shadow-sm border-0 rounded-3">
                    <div class="card-header bg-success text-white fw-bold">
                        <i class="bi bi-box-arrow-in-down"></i> Barang Masuk
                    </div>
                    <div class="card-body p-0">
                        <div class="table-wrapper">
                            <div class="table-scroll">
                                <table class="table table-bordered table-striped w-100">
                                <thead class="bg-cyan-600 text-white">
                                    <tr>
                                        <th class="text-center">Tanggal</th>
                                        <th class="text-center">Nama Barang</th>
                                        <th class="text-center">Jumlah</th>
                                        <th class="text-center">Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($barangMasuks as $bm)
                                        <tr>
                                            <td class="text-center fw-semibold">{{ $bm->tanggal_masuk }}</td>
                                            <td class="text-center">{{ $bm->barang->nama ?? '-' }}</td>
                                            <td class="text-center">
                                                <span class="badge bg-success px-2 px-md-3 py-1 py-md-2">{{ $bm->jumlah }}</span>
                                            </td>
                                            <td class="text-center fst-italic">
                                                {{ $bm->keterangan ?? ($bm->barang->keterangan ?? '-') }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center text-muted py-4">
                                                <i class="bi bi-inbox"></i> Tidak ada data barang masuk
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-4 mb-3">
                    <h2 class="fw-bold text-danger mb-0"><i class="bi bi-arrow-up-circle"></i> BARANG KELUAR</h2>
                </div>

                <!-- Barang Keluar -->
                <div class="card shadow-sm border-0 rounded-3">
                    <div class="card-header bg-danger text-white fw-bold">
                        <i class="bi bi-box-arrow-up"></i> Barang Keluar
                    </div>
                    <div class="card-body p-0">
                        <div class="table-wrapper">
                            <div class="table-scroll">
                                <table class="table table-striped table-bordered align-middle shadow-sm w-100">
                                <thead class="bg-cyan-600 text-white">
                                    <tr>
                                        <th class="text-center">Tanggal</th>
                                        <th class="text-center">Nama Barang</th>
                                        <th class="text-center">Jumlah</th>
                                        <th class="text-center">Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($barangKeluars as $bk)
                                        <tr>
                                            <td class="text-center fw-semibold">{{ $bk->tanggal_keluar }}</td>
                                            <td class="text-center text-capitalize">{{ $bk->barang->nama ?? '-' }}</td>
                                            <td class="text-center">
                                                <span class="badge bg-danger px-2 px-md-3 py-1 py-md-2">{{ $bk->jumlah }}</span>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge bg-secondary px-2 px-md-3 py-1 py-md-2">
                                                    {{ str_replace('Stok Awal Barang Baru: ', '', $bm->keterangan) ?? '-' }}
                                                </span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center text-muted py-4">
                                                <i class="bi bi-inbox"></i> Tidak ada data barang keluar
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

        /* Tombol Filter, Excel, PDF */
        .btn-filter {
            background: linear-gradient(135deg, #0d6efd, #00c6ff);
            color: white;
            font-weight: 600;
            border-radius: .5rem;
            border: none;
            transition: all 0.3s ease;
            white-space: nowrap;
        }

        .btn-filter:hover {
            background: linear-gradient(135deg, #0a58ca, #00c6ff);
            transform: translateY(-2px);
        }

        .btn-excel {
            background: linear-gradient(135deg, #198754, #28a745);
            color: white;
            font-weight: 600;
            border-radius: .5rem;
            border: none;
            transition: all 0.3s ease;
            white-space: nowrap;
        }

        .btn-excel:hover {
            background: linear-gradient(135deg, #146c43, #218838);
            transform: translateY(-2px);
        }

        .btn-pdf {
            background: linear-gradient(135deg, #dc3545, #e55360);
            color: white;
            font-weight: 600;
            border-radius: .5rem;
            border: none;
            transition: all 0.3s ease;
            white-space: nowrap;
        }

        .btn-pdf:hover {
            background: linear-gradient(135deg, #b02a37, #d6334c);
            transform: translateY(-2px);
        }

        /* Overlay */
        .overlay-toggle {
            display: none;
        }

        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.75);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 1050;
            padding: 20px;
        }

        .overlay-content {
            background: #fff;
            border-radius: 12px;
            width: 92%;
            height: 85%;
            display: flex;
            flex-direction: column;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.45);
        }

        .overlay-header {
            padding: 14px 18px;
            font-weight: 700;
            color: #fff;
        }

        .overlay-body {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f8f9fa;
            padding: 10px;
        }

        .overlay-body iframe {
            border: none;
            width: 90%;
            height: 90%;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.2);
            border-radius: 10px;
        }

        .overlay-footer {
            padding: 12px 16px;
            background: #f8f9fa;
            text-align: right;
        }

        .overlay-toggle:checked+.overlay {
            display: flex;
        }

        /* Table Scroll Wrapper */
        .table-wrapper {
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            border-radius: .5rem;
            background: #fff;
        }

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
            background-color: #198754;
            border-radius: 10px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            table-layout: auto;
            min-width: 600px;
            margin: 0;
        }

        .card-body {
            padding: 0 !important;
        }

        /* Table cells padding and alignment */
        .table th,
        .table td {
            vertical-align: middle;
            padding: 10px 8px;
            border: 1px solid #dee2e6;
            font-size: 0.95rem;
        }

        /* Badge styling */
        .badge {
            font-size: 0.85rem;
            border-radius: .5rem;
            display: inline-block;
        }

        /* ===== TABLET (md breakpoint) ===== */
        @media (min-width: 768px) and (max-width: 1024px) {
            .shadow-text-green {
                font-size: 1.75rem;
            }

            .table th,
            .table td {
                padding: 10px 8px;
                font-size: 0.9rem;
            }

            .btn-sm {
                font-size: 0.8rem;
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

            .table {
                font-size: 0.85rem;
                min-width: 100%;
            }

            .table th,
            .table td {
                padding: 8px 6px;
                font-size: 0.8rem;
            }

            .table th {
                font-size: 0.75rem;
            }

            .badge {
                font-size: 0.75rem;
                padding: 0.35rem 0.6rem;
            }

            .btn-sm {
                font-size: 0.75rem;
                padding: 0.25rem 0.5rem;
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

            .table th,
            .table td {
                padding: 6px 4px;
                font-size: 0.7rem;
            }

            .badge {
                font-size: 0.65rem;
            }

            .btn-sm {
                font-size: 0.7rem;
                padding: 0.2rem 0.4rem;
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

            .table th,
            .table td {
                padding: 6px 4px;
            }
        }
    </style>
@endsection
