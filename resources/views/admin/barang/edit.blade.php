@extends('admin.layouts.app')

@section('content')
<div class="container-fluid responsive-form">
    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-body p-3 p-md-4">
            <h1 class="fw-bold text-success mb-4 form-title">
                <i class="bi bi-pencil-square"></i> Edit Barang
            </h1>

            <form action="{{ route('admin.barang.update', $barang->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label fw-semibold">Nama Barang <span class="text-danger">*</span></label>
                    <input type="text" name="nama_barang" class="form-control form-control-responsive" 
                           value="{{ old('nama_barang', $barang->nama_barang) }}" required>
                    @error('nama_barang')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Kategori <span class="text-danger">*</span></label>
                    <select name="kategori_id" class="form-select form-control-responsive" required>
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($kategoris as $kategori)
                            <option value="{{ $kategori->id }}" {{ $barang->kategori_id == $kategori->id ? 'selected' : '' }}>
                                {{ $kategori->nama }}
                            </option>
                        @endforeach
                    </select>
                    @error('kategori_id')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Satuan <span class="text-danger">*</span></label>
                    <input type="text" name="satuan" class="form-control form-control-responsive" 
                           value="{{ old('satuan', $barang->satuan) }}" required>
                    @error('satuan')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Jumlah <span class="text-danger">*</span></label>
                    <input type="number" name="jumlah" class="form-control form-control-responsive" 
                           value="{{ old('jumlah', $barang->jumlah) }}" required min="0">
                    @error('jumlah')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Tanggal</label>
                    <input type="date" name="tanggal" class="form-control form-control-responsive" 
                           value="{{ old('tanggal', $barang->tanggal) }}">
                    @error('tanggal')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Keterangan</label>
                    <textarea name="keterangan" class="form-control form-control-responsive" rows="3">{{ old('keterangan', $barang->keterangan) }}</textarea>
                    @error('keterangan')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold">Gambar</label>
                    @if(!empty($barang->gambar))
                        <div class="mb-3">
                            <p class="small text-muted mb-2">Gambar Saat Ini:</p>
                            <img src="{{ asset('storage/' . $barang->gambar) }}" alt="Gambar_barang" 
                                 class="img-preview">
                        </div>
                    @endif
                    <input type="file" name="gambar" accept="image/*" class="form-control form-control-responsive">
                    <small class="text-muted">Format: JPG, PNG, GIF. Ukuran maksimal: 2MB</small>
                    @error('gambar')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex gap-2 flex-wrap">
                    <button type="submit" class="btn btn-add btn-responsive px-4 py-2">
                        <i class="bi bi-check-circle"></i> Update
                    </button>
                    <a href="{{ route('admin.barang.index') }}" class="btn btn-secondary btn-responsive px-4 py-2">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .responsive-form {
        padding: 0.5rem;
    }

    .form-title {
        font-size: 2rem;
        text-shadow: 2px 2px 5px rgba(0, 128, 0, 0.3);
    }

    .form-control-responsive,
    .form-select {
        border: 1px solid #ddd;
        border-radius: 0.5rem;
        padding: 0.6rem 0.9rem;
        font-size: 1rem;
        transition: border-color 0.3s ease;
    }

    .form-control-responsive:focus,
    .form-select:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
    }

    .img-preview {
        max-width: 150px;
        max-height: 150px;
        object-fit: cover;
        border-radius: 6px;
        border: 1px solid #ddd;
    }

    .btn-responsive {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        white-space: nowrap;
        transition: all 0.3s ease;
    }

    .btn-responsive:hover {
        transform: translateY(-2px);
    }

    @media (max-width: 768px) {
        .responsive-form {
            padding: 0.25rem;
        }

        .form-title {
            font-size: 1.5rem;
            text-align: center;
        }

        .form-control-responsive,
        .form-select {
            font-size: 0.95rem;
            padding: 0.5rem 0.8rem;
        }

        .form-label {
            font-size: 0.95rem;
        }

        .img-preview {
            max-width: 120px;
            max-height: 120px;
        }

        .d-flex {
            flex-direction: column;
        }

        .btn-responsive {
            width: 100%;
            justify-content: center;
            font-size: 0.9rem;
        }
    }

    @media (max-width: 480px) {
        .form-title {
            font-size: 1.2rem;
        }

        .form-control-responsive,
        .form-select {
            font-size: 0.9rem;
        }

        .form-label {
            font-size: 0.9rem;
        }

        textarea.form-control-responsive {
            font-size: 0.9rem;
        }

        .img-preview {
            max-width: 100px;
            max-height: 100px;
        }

        small {
            font-size: 0.75rem;
        }
    }
</style>
@endsection
