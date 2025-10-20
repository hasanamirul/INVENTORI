@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-4">Tambah Barang Keluar</h3>

    <div class="card shadow p-4">
    <form action="{{ route('admin.barangkeluar.store') }}" method="POST">
            @csrf

            <!-- Pilih Barang -->
            <div class="mb-3">
                <label for="barang_id" class="form-label">Nama Barang</label>
                <select name="barang_id" id="barang_id" class="form-control" required>
                    <option value="">-- Pilih Barang --</option>
                    @foreach($barang as $barang)
                        <option value="{{ $barang->id }}">{{ $barang->nama }} (Stok: {{ $barang->jumlah }})</option>
                    @endforeach
                </select>
            </div>

            <!-- Kategori Barang -->
            <div class="mb-3">
                <label for="kategori" class="form-label">Kategori Barang</label>
                <input type="text" class="form-control" id="kategori" name="kategori" placeholder="Kategori barang">
            </div>

            <!-- Jumlah Keluar -->
            <div class="mb-3">
                <label for="jumlah" class="form-label">Jumlah Keluar</label>
                <input type="number" class="form-control" id="jumlah" name="jumlah" placeholder="Masukkan jumlah keluar" required>
            </div>

            <!-- Satuan -->
            <div class="mb-3">
                <label for="satuan" class="form-label">Satuan</label>
                <input type="text" class="form-control" id="satuan" name="satuan" placeholder="contoh: pcs, unit, box">
            </div>

            <!-- Status -->
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select name="status" id="status" class="form-control" required>
                    <option value="Terpakai">Terpakai</option>
                    <option value="Barang Keluar">Barang Keluar</option>
                </select>
            </div>

            <!-- Sisa Stok -->
            <div class="mb-3">
                <label for="sisa" class="form-label">Sisa Stok</label>
                <input type="number" class="form-control" id="sisa" name="sisa" placeholder="Sisa stok setelah keluar" readonly>
            </div>

            <!-- Keterangan -->
            <div class="mb-3">
                <label for="keterangan" class="form-label">Keterangan</label>
                <textarea class="form-control" id="keterangan" name="keterangan" rows="3"></textarea>
            </div>

            <!-- Tanggal Keluar -->
            <div class="mb-3">
                <label for="tanggal_keluar" class="form-label">Tanggal Keluar</label>
                <input type="date" class="form-control" id="tanggal_keluar" name="tanggal_keluar" value="{{ date('Y-m-d') }}">
            </div>

            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('admin.barang-keluar.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection
