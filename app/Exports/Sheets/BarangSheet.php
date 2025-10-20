<?php

namespace App\Exports\Sheets;

use App\Models\Barang;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class BarangSheet implements FromCollection, WithHeadings, WithStyles
{
    public function collection()
    {
        // Ambil data dengan nama kategori (relasi)
        return Barang::with('kategori')->get()->map(function ($b) {
            return [
                'ID'         => $b->id,
                'Nama'       => $b->nama_barang,
                'Kategori'   => $b->kategori ? $b->kategori->nama : '-',
                'Satuan'     => $b->satuan,
                'Jumlah'     => $b->jumlah,
                'Terpakai'   => $b->terpakai,
                'Tanggal'    => $b->tanggal,
                'Status'     => $b->status,
                'Keterangan' => $b->keterangan,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nama Barang',
            'Kategori',
            'Satuan',
            'Jumlah',
            'Terpakai',
            'Tanggal',
            'Status',
            'Keterangan',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->setTitle('Barang'); // nama sheet

        // Header bold + center
        $sheet->getStyle('A1:I1')->getFont()->setBold(true);
        $sheet->getStyle('A1:I1')->getAlignment()->setHorizontal('center');

        // Semua isi rata tengah
        $lastRow = $sheet->getHighestRow();
        $sheet->getStyle("A2:I$lastRow")->getAlignment()->setHorizontal('center');

        // Border semua sel
        $sheet->getStyle("A1:I$lastRow")->getBorders()->getAllBorders()
            ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

        return [];
    }
}
