<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\BarangMasuk;
use App\Models\BarangKeluar;

class Laporan extends Model
{
    // Karena ini model khusus laporan (bukan tabel tunggal),
    // kita bisa pakai cara custom (tidak butuh $table, $fillable, dll).

    /**
     * Ambil semua data laporan barang masuk dan barang keluar
     */
    public static function getLaporanBarang()
    {
        $barangMasuk = BarangMasuk::with('barang')->orderBy('tanggal_masuk', 'desc')->get();
        $barangKeluar = BarangKeluar::with('barang')->orderBy('tanggal_keluar', 'desc')->get();

        return [
            'barangMasuk' => $barangMasuk,
            'barangKeluar' => $barangKeluar,
        ];
    }
}
