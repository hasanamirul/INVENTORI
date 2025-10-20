@extends('admin.layouts.app')

@section('content')
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-5 flex-wrap">
        <h1 class="fw-bold text-success mb-3 text-center shadow-text-green w-full sm:w-auto">
            <i class="bi bi-tags"></i> KATEGORI BARANG
        </h1>
        <a href="{{ route('admin.kategori-barang.create') }}" class="btn btn-add px-4 py-2 mt-2 sm:mt-0">
            Tambah Kategori
        </a>
    </div>

    <!-- Tabel -->
    <div class="overflow-x-auto shadow-lg rounded-lg bg-white">
        <table class="min-w-full text-sm text-center border border-gray-300">
            <thead class="bg-cyan-600 text-white">
                <tr>
                    <th class="border px-4 py-3">ID</th>
                    <th class="border px-4 py-3">Nama</th>
                    <th class="border px-4 py-3">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-gray-50">
                @foreach ($kategori as $item)
                    <tr class="hover:bg-blue-50 transition duration-200">
                        <td class="border px-4 py-3">{{ $item->id }}</td>
                        <td class="border px-4 py-3">{{ $item->nama }}</td>
                        <td class="border px-4 py-3">
                            <div class="flex flex-col sm:flex-row justify-center gap-2">
                                <a href="{{ route('admin.kategori-barang.edit', $item->id) }}"
                                    class="btn btn-edit flex items-center justify-center gap-1 px-3 py-2 text-sm">
                                    <i class="bi bi-pencil-square"></i> Edit
                                </a>
                                <form action="{{ route('admin.kategori-barang.destroy', $item->id) }}" method="POST"
                                    onsubmit="return confirm('Yakin hapus?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="btn btn-delete flex items-center justify-center gap-1 px-3 py-2 text-sm w-full sm:w-auto">
                                        <i class="bi bi-trash"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Custom Styles -->
    <style>
        .shadow-text-green {
            font-size: 2rem;
            font-weight: 900;
            text-shadow: 2px 2px 5px rgba(0, 128, 0, 0.3);
            letter-spacing: 1px;
        }

        .btn-add {
            background: linear-gradient(135deg, #0d6efd, #00c6ff);
            color: white;
            font-weight: 600;
            border-radius: 0.5rem;
            transition: all 0.3s ease;
        }

        .btn-add:hover {
            background: linear-gradient(135deg, #0a58ca, #00b4e6);
            color: #fff;
        }

        .btn-edit {
            background: linear-gradient(135deg, #ffc107, #ffca2c);
            color: #212529;
            font-weight: 600;
            border-radius: 0.5rem;
            transition: all 0.3s ease;
        }

        .btn-edit:hover {
            background: linear-gradient(135deg, #e0a800, #ffcd39);
        }

        .btn-delete {
            background: linear-gradient(135deg, #dc3545, #e55360);
            color: #fff;
            font-weight: 600;
            border-radius: 0.5rem;
            transition: all 0.3s ease;
        }

        .btn-delete:hover {
            background: linear-gradient(135deg, #b02a37, #d6334c);
        }

        /* Responsif Mobile */
        @media (max-width: 768px) {
            table {
                font-size: 0.9rem;
            }

            th, td {
                padding: 0.6rem;
            }

            .btn {
                width: 100%;
                text-align: center;
            }

            .btn-add {
                width: 100%;
                margin-top: 1rem;
            }
        }
    </style>
@endsection
