<?php

namespace App\Exports\Sheets;

use App\Models\BarangMasuk;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class BarangMasukSheet implements FromCollection, WithHeadings, WithStyles
{
    public function collection()
    {
        return BarangMasuk::with('barang')->get()->map(function ($bm) {
            return [
                'ID'            => $bm->id,
                'Nama Barang'   => $bm->barang ? $bm->barang->nama : '-',
                'Jumlah'        => $bm->jumlah,
                'Tanggal Masuk' => $bm->tanggal_masuk,
                'Keterangan'    => $bm->keterangan ?? '-',
            ];
        });
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nama Barang',
            'Jumlah',
            'Tanggal Masuk',
            'Keterangan',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->setTitle('Barang Masuk');

        $sheet->getStyle('A1:E1')->getFont()->setBold(true);
        $sheet->getStyle('A1:E1')->getAlignment()->setHorizontal('center');

        $lastRow = $sheet->getHighestRow();
        $sheet->getStyle("A2:E$lastRow")->getAlignment()->setHorizontal('center');

        $sheet->getStyle("A1:E$lastRow")->getBorders()->getAllBorders()
            ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

        return [];
    }
}
