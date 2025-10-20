@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <h3>Tambah Barang Masuk</h3>

        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Oops!</strong> Ada kesalahan.<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

    <form action="{{ route('admin.barang-masuk.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="barang_id" class="form-label">Pilih Barang</label>
                <select name="barang_id" id="barang_id" class="form-control" required>
                    <option value="">-- Pilih Barang --</option>
                    @foreach ($barangs as $barang)
                        <option value="{{ $barang->id }}">
                            {{ $barang->nama_barang }} (Kategori: {{ $barang->kategori->nama }})
                        </option>
                    @endforeach
                </select>

            </div>

            <div class="mb-3">
                <label for="jumlah" class="form-label">Jumlah Masuk</label>
                <input type="number" name="jumlah" class="form-control" required min="1">
            </div>

            <div class="mb-3">
                <label for="tanggal" class="form-label">Tanggal Masuk</label>
                <input type="date" name="tanggal_masuk" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-success">Simpan</button>
            <a href="{{ route('admin.barang-masuk.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
@endsection
