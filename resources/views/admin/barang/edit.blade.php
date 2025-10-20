@extends('admin.layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Edit Barang</h1>

    <form action="{{ route('admin.barang.update', $barang->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-2">
            <label>Nama Barang</label>
            <input type="text" name="nama_barang" class="w-full border p-2" value="{{ old('nama_barang', $barang->nama_barang) }}" required>
        </div>

        <div class="mb-2">
            <label>Kategori</label>
            <select name="kategori_id" class="w-full border p-2" required>
                <option value="">-- Pilih Kategori --</option>
                @foreach($kategoris as $kategori)
                    <option value="{{ $kategori->id }}" {{ $barang->kategori_id == $kategori->id ? 'selected' : '' }}>
                        {{ $kategori->nama }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-2">
            <label>Satuan</label>
            <input type="text" name="satuan" class="w-full border p-2" value="{{ old('satuan', $barang->satuan) }}" required>
        </div>

        <div class="mb-2">
            <label>Jumlah</label>
            <input type="number" name="jumlah" class="w-full border p-2" value="{{ old('jumlah', $barang->jumlah) }}" required>
        </div>

        <div class="mb-2">
            <label>Tanggal</label>
            <input type="date" name="tanggal" class="w-full border p-2" value="{{ old('tanggal', $barang->tanggal) }}">
        </div>

        <div class="mb-2">
            <label>Keterangan</label>
            <textarea name="keterangan" class="w-full border p-2">{{ old('keterangan', $barang->keterangan) }}</textarea>
        </div>

        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">Update</button>
    </form>
</div>
@endsection
