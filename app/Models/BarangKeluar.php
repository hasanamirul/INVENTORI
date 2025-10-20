<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangKeluar extends Model
{
    use HasFactory;

    protected $table = 'barang_keluars';

    // Pastikan kolom yang digunakan di view dan controller dapat diisi
    protected $fillable = [
        'barang_id',
        'nama_barang',
        'kategori',
        'jumlah',
        'sisa_stok',
        'keterangan',
        'tanggal_keluar',
    ];

    /**
     * Relasi ke model Barang.
     */
    public function barang()
    {
        return $this->belongsTo(Barang::class, 'barang_id');
    }
}
