<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan Barang</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }

        h2,
        h3 {
            text-align: center;
            margin-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        thead {
            background: #ddd;
        }

        th,
        td {
            padding: 6px;
            text-align: center;
        }
    </style>
</head>

<body>
    <h2> LAPORAN BARANG</h2>
    <br>

    <h3>Laporan Barang Masuk</h3>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Barang</th>
                <th>Jumlah Masuk</th>
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
                <th>Jumlah Keluar</th>
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
