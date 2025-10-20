<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\BarangMasuk;
use App\Models\BarangKeluar;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalBarang = Barang::count();
        $totalMasuk = BarangMasuk::count();
        $totalKeluar = BarangKeluar::count();

        // Ambil data bulanan untuk chart
        $bulan = [];
        $masuk = [];
        $keluar = [];

        for ($i = 5; $i <= 10; $i++) { // contoh Mei s/d Okt
            $bulan[] = date("F", mktime(0, 0, 0, $i, 1));

            $masuk[] = BarangMasuk::whereMonth('created_at', $i)
                ->whereYear('created_at', now()->year)
                ->count();

            $keluar[] = BarangKeluar::whereMonth('created_at', $i)
                ->whereYear('created_at', now()->year)
                ->count();
        }

        // Ambil data terbaru untuk tabel (misal 10 data terakhir)
        $barangMasuk = BarangMasuk::latest()->take(10)->get();
        $barangKeluar = BarangKeluar::latest()->take(10)->get();

        return view('user.dashboard', [
            'totalBarang' => $totalBarang,
            'totalMasuk' => $totalMasuk,
            'totalKeluar' => $totalKeluar,
            'labels' => $bulan,
            'masuk' => $masuk,
            'keluar' => $keluar,
            'barangMasuk' => $barangMasuk,
            'barangKeluar' => $barangKeluar,
        ]);
    }
}