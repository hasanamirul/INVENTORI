<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class BarangExport implements WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            new Sheets\BarangSheet(),
            new Sheets\BarangMasukSheet(),
            new Sheets\BarangKeluarSheet(),
        ];
    }
}
