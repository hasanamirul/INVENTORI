<?php

namespace App\Exports\Sheets;

use App\Models\BarangKeluar;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class BarangKeluarSheet implements FromCollection, WithHeadings, WithStyles
{
    public function collection()
    {
        return BarangKeluar::with('barang')->get()->map(function ($bk) {
            return [
                'ID'            => $bk->id,
                'Nama Barang'   => $bk->barang ? $bk->barang->nama : '-',
                'Jumlah'        => $bk->jumlah,
                'Sisa Stok'     => $bk->sisa_stok,
                'Tanggal Keluar' => $bk->tanggal_keluar,
                'Keterangan'    => $bk->keterangan ?? '-',
            ];
        });
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nama Barang',
            'Jumlah',
            'Sisa Stok',
            'Tanggal Keluar',
            'Keterangan',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->setTitle('Barang Keluar');

        $sheet->getStyle('A1:F1')->getFont()->setBold(true);
        $sheet->getStyle('A1:F1')->getAlignment()->setHorizontal('center');

        $lastRow = $sheet->getHighestRow();
        $sheet->getStyle("A2:F$lastRow")->getAlignment()->setHorizontal('center');

        $sheet->getStyle("A1:F$lastRow")->getBorders()->getAllBorders()
            ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

        return [];
    }
}
