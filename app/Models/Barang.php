<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    protected $table = 'barangs';

    protected $fillable = [
        'nama_barang',
        'kategori_id',
        'satuan',
        'jumlah',
        'terpakai',
        'tanggal',
        'status',
        'stok',
        'keterangan',
    ];

    // alias nama
    public function setNamaAttribute($value)
    {
        $this->attributes['nama_barang'] = $value;
    }

    public function getNamaAttribute()
    {
        return $this->attributes['nama_barang'] ?? null;
    }

    // relasi kategori
    public function kategori()
    {
        return $this->belongsTo(KategoriBarang::class, 'kategori_id');
    }

    // update status otomatis
    public function updateStatus()
    {
        if ($this->jumlah == 0) {
            $this->status = 'Sudah Terpakai';
        } elseif ($this->terpakai > 0) {
            $this->status = 'Sebagian Terpakai';
        } else {
            $this->status = 'Belum Terpakai';
        }
        $this->save();
    }

    // stok sisa
    public function sisa()
    {
        return $this->jumlah;
    }
    public function barangMasuks()
    {
        return $this->hasMany(BarangMasuk::class, 'barang_id');
    }

    public function barangKeluars()
    {
        return $this->hasMany(BarangKeluar::class, 'barang_id');
    }
}
