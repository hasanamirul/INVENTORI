@extends('admin.layouts.app')

@section('content')
    <h1 class="text-2xl font-bold mb-4 text-center sm:text-left">Edit Kategori Barang</h1>

    <div class="bg-white rounded-lg shadow-lg p-6 max-w-xl mx-auto w-full">
        <form action="{{ route('admin.kategori-barang.update', $kategori->id) }}" method="POST">
            @csrf
            @method('PUT')
            <label class="block mb-2 font-semibold">Nama Kategori</label>
            <input type="text" name="nama" value="{{ $kategori->nama }}"
                class="border border-gray-300 p-2 rounded w-full focus:ring-2 focus:ring-green-400 focus:outline-none"
                required>

            <button type="submit"
                class="bg-green-500 hover:bg-green-600 text-white px-6 py-2 mt-4 rounded w-full sm:w-auto transition duration-200 shadow-md">
                <i class="bi bi-check-circle"></i> Update
            </button>
        </form>
    </div>

    <style>
        @media (max-width: 768px) {
            h1 {
                text-align: center;
            }

            form {
                width: 100%;
            }

            button {
                width: 100%;
            }
        }
    </style>
@endsection
