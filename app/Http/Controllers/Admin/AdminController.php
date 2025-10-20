<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Barang;
use App\Models\BarangMasuk;
use App\Models\BarangKeluar;
use App\Models\Pencatatan;

class AdminController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role !== 'admin') {
            abort(403, 'Unauthorized');
        }

        // Hitung jumlah data
        $barangCount = Barang::count();
        $rekapCount = BarangMasuk::count() + BarangKeluar::count();
        $pencatatanCount = Pencatatan::count();

        // Kirim ke view
        return view('admin.dashboard', compact('barangCount', 'rekapCount', 'pencatatanCount'));
    }
}
