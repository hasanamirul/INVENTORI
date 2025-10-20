@extends('admin.layouts.app')

@section('content')
<h1 class="text-2xl font-bold mb-4">Edit Barang Keluar</h1>
<form action="{{ route('admin.barang-keluar.update', $barangKeluar->id) }}" method="POST">
    @csrf
    @method('PUT')
    <label class="block mb-2">Barang</label>
    <select name="barang_id" class="border p-2 w-full mb-4" required>
        @foreach($barang as $b)
            <option value="{{ $b->id }}" @if($barangKeluar->barang_id == $b->id) selected @endif>{{ $b->nama }}</option>
        @endforeach
    </select>

    <label class="block mb-2">Jumlah</label>
    <input type="number" name="jumlah" value="{{ $barangKeluar->jumlah }}" class="border p-2 w-full mb-4" required>

    <label class="block mb-2">Tanggal</label>
    <input type="date" name="tanggal" value="{{ $barangKeluar->tanggal }}" class="border p-2 w-full mb-4" required>

    <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Update</button>
</form>
@endsection
