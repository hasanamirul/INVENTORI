<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Preview Laporan Excel</title>
    <style>
        h2,
        h3 {
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 6px;
            text-align: center;
        }

        thead {
            background: #f2f2f2;
        }
    </style>
</head>

<body>
    <h2>LAPORAN BARANG</h2>
    <br>

    <h3>Laporan Barang Masuk</h3>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Barang</th>
                <th>Jumlah</th>
                <th>Tanggal Masuk</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($barangMasuks as $masuk)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $masuk->barang->nama ?? '-' }}</td>
                    <td>{{ $masuk->jumlah }}</td>
                    <td>{{ $masuk->tanggal_masuk }}</td>
                    <td>
                        <span class="badge bg-secondary px-3 py-2">
                            {{ str_replace('Stok Awal Barang Baru: ', '', $masuk->keterangan) ?? '-' }}
                        </span>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h3>Laporan Barang Keluar</h3>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Barang</th>
                <th>Jumlah</th>
                <th>Tanggal Keluar</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($barangKeluars as $keluar)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $keluar->barang->nama ?? '-' }}</td>
                    <td>{{ $keluar->jumlah }}</td>
                    <td>{{ $keluar->tanggal_keluar }}</td>
                    <td>{{ $keluar->keterangan ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
