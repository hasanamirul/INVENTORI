@extends('admin.layouts.app')

@section('title', 'Laporan Barang')

@section('content')
    <div class="container-fluid">
        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-body p-4">

                <!-- Header -->
                <div class="d-flex justify-content-between align-items-center mb-5">
                    <h1 class="fw-bold text-success mb-0 text-center shadow-text-green w-100">
                        📊 LAPORAN BARANG
                    </h1>
                </div>

                <!-- Filter -->
                <form method="GET" action="{{ route('admin.laporan.index') }}" class="row g-3 mb-4 p-6 ">
                    <div class="border border-primary" style="width: 25%">
                        <div class="col-md-3 border border-primary">
                            <label class="form-label fw-semibold">📅 Dari Tanggal</label>
                            <input type="date" name="from" value="{{ request('from') }}" class="form-control">
                        </div>
                        <div class="col-md-3 border border-primary">
                            <label class="form-label fw-semibold">📅 Sampai Tanggal</label>
                            <input type="date" name="to" value="{{ request('to') }}" class="form-control">
                        </div>
                    </div>

                    <br>
                    <div class="col-md-6 d-flex align-items-end gap-2">
                        <button type="submit" class="btn btn-filter px-4 py-2">
                            <i class="bi bi-funnel"></i> Filter
                        </button>


                        <!-- Tombol overlay Excel -->
                        <label for="excelToggle" class="btn btn-excel px-4 py-2 p-6 m-2">
                            <i class="bi bi-file-earmark-excel"></i> Preview Excel
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
                        <label for="pdfToggle" class="btn btn-pdf px-4 py-2 p-6 m-2">
                            <i class="bi bi-file-earmark-pdf"></i> Preview PDF
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

                <div class="ms-4">
                    <h2 class="bi bi-arrow-down-circle"> BARANG MASUK</h2>
                </div>

                <!-- Barang Masuk -->
                <div class="card mb-4 shadow-sm border-0 rounded-3">
                    <div class="card-header bg-success text-white fw-bold">
                        <i class="bi bi-box-arrow-in-down"></i> Barang Masuk
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped w-100">
                                <thead>
                                    <tr class="bg-success text-white">
                                        <th class="text-center" style="width: 20%">Tanggal</th>
                                        <th style="width: 30%">Nama Barang</th>
                                        <th class="text-center" style="width: 15%">Jumlah</th>
                                        <th style="width: 35%">Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($barangMasuks as $bm)
                                        <tr>
                                            <td class="text-center fw-semibold">{{ $bm->tanggal_masuk }}</td>
                                            <td>{{ $bm->barang->nama ?? '-' }}</td>
                                            <td class="text-center">
                                                <span class="badge bg-success px-3 py-2">{{ $bm->jumlah }}</span>
                                            </td>
                                            <td class="fst-italic">
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

                <br>
                <div class="ms-4">
                    <h2 class="bi bi-arrow-up-circle"> BARANG KELUAR</h2>
                </div>

                <!-- Barang Keluar -->
                <div class="card shadow-sm border-0 rounded-3">
                    <div class="card-header bg-danger text-white fw-bold">
                        <i class="bi bi-box-arrow-up"></i> Barang Keluar
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered align-middle shadow-sm w-100">
                                <thead class="bg-danger text-white">
                                    <tr>
                                        <th class="text-center" style="width: 20%">Tanggal</th>
                                        <th class="text-start" style="width: 30%">Nama Barang</th>
                                        <th class="text-center" style="width: 15%">Jumlah</th>
                                        <th class="text-start" style="width: 35%">Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($barangKeluars as $bk)
                                        <tr>
                                            <td class="text-center fw-semibold">{{ $bk->tanggal_keluar }}</td>
                                            <td class="text-capitalize">{{ $bk->barang->nama ?? '-' }}</td>
                                            <td class="text-center">
                                                <span class="badge bg-danger px-3 py-2">{{ $bk->jumlah }}</span>
                                            </td>
                                            <td>
                                                <span class="badge bg-secondary px-3 py-2">
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

    <style>
        /* Header */
        .shadow-text-green {
            font-size: 2rem;
            font-weight: 900;
            text-shadow: 2px 2px 5px rgba(0, 128, 0, 0.3);
        }

        /* Tombol */
        .btn-filter {
            background: linear-gradient(135deg, #0d6efd, #00c6ff);
            color: white;
            font-weight: 600;
            border-radius: .5rem;
            padding: .5rem !important;
        }

        .btn-filter:hover {
            background: linear-gradient(135deg, #0a58ca, #00c6ff);
            color: white;
        }

        .btn-excel {
            background: linear-gradient(135deg, #198754, #28a745);
            color: white;
            font-weight: 600;
            border-radius: .5rem;

        }

        .btn-excel:hover {
            background: linear-gradient(135deg, #146c43, #218838);
            color: white;
        }

        .btn-pdf {
            background: linear-gradient(135deg, #dc3545, #e55360);
            color: white;
            font-weight: 600;
            border-radius: .5rem;

        }

        .btn-pdf:hover {
            background: linear-gradient(135deg, #b02a37, #d6334c);
            color: white;
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

        /* ✅ Atur body overlay supaya iframe center */
        .overlay-body {
            flex: 1;
            display: flex;
            /* aktifkan flex */
            align-items: center;
            /* center vertical */
            justify-content: center;
            /* center horizontal */
            background: #f8f9fa;
            /* biar lebih soft */
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

        /* Toggle tampil */
        .overlay-toggle:checked+.overlay {
            display: flex;
        }

        /* Table */
        /* Buat tabel isi full ke kanan */
        .table-responsive {
            width: 100% !important;
            margin: 0 !important;
            padding: 10px !important;
        }

        .table {
            width: 100% !important;
            margin: 0 !important;
        }

        .card-body {
            padding: 0 !important;
            /* biar tabel nempel ke kanan */
        }

        /* Table head */
        .table thead th {
            background-color: hsl(200, 72%, 46%) !important;
            text-align: center;
            color: #fff !important;
            font-weight: 700;
            text-transform: uppercase;
            border: 1px solid #dee2e6 !important;
            padding: 8px !important;
        }

        /* Table body */
        .table tbody td {
            border: 1px solid #dee2e6 !important;
            text-align: center;
            padding: 8px !important;
        }
    </style>
@endsection
