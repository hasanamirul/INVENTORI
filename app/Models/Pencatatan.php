<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pencatatan extends Model
{
    use HasFactory;

    protected $table = 'pencatatans'; // tabel sesuai migration
    protected $fillable = [
        'judul',
        'deskripsi',
        'tanggal',
    ];
}
