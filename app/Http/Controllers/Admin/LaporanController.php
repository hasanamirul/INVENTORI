<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\BarangMasuk;
use App\Models\BarangKeluar;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\BarangExport;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $from = $request->get('from');
        $to = $request->get('to');

        $barangs = Barang::all();

        $barangMasuks = BarangMasuk::with('barang')
            ->when($from && $to, fn($q) => $q->whereBetween('tanggal_masuk', [$from, $to]))
            ->orderBy('tanggal_masuk', 'desc')
            ->get();

        $barangKeluars = BarangKeluar::with('barang')
            ->when($from && $to, fn($q) => $q->whereBetween('tanggal_keluar', [$from, $to]))
            ->orderBy('tanggal_keluar', 'desc')
            ->get();

        return view('admin.laporan.index', compact('barangs', 'barangMasuks', 'barangKeluars'));
    }

    public function export()
    {
        return Excel::download(new BarangExport, 'laporan-barang.xlsx');
    }

    public function exportPdf(Request $request)
    {
        $from = $request->get('from');
        $to = $request->get('to');

        $barangs = Barang::all();

        $barangMasuks = BarangMasuk::with('barang')
            ->when($from && $to, fn($q) => $q->whereBetween('tanggal_masuk', [$from, $to]))
            ->get();

        $barangKeluars = BarangKeluar::with('barang')
            ->when($from && $to, fn($q) => $q->whereBetween('tanggal_keluar', [$from, $to]))
            ->get();

        $pdf = Pdf::loadView('admin.laporan.pdf', compact('barangs', 'barangMasuks', 'barangKeluars'));
        return $pdf->download('laporan-barang.pdf');
    }

    public function previewExcel(Request $request)
    {
        $from = $request->get('from');
        $to = $request->get('to');

        $barangs = Barang::all();

        $barangMasuks = BarangMasuk::with('barang')
            ->when($from && $to, fn($q) => $q->whereBetween('tanggal_masuk', [$from, $to]))
            ->get();

        $barangKeluars = BarangKeluar::with('barang')
            ->when($from && $to, fn($q) => $q->whereBetween('tanggal_keluar', [$from, $to]))
            ->get();

        return view('admin.laporan.excel', compact('barangs', 'barangMasuks', 'barangKeluars'));
    }

    public function previewPdf(Request $request)
    {
        $from = $request->get('from');
        $to = $request->get('to');

        $barangs = Barang::all();

        $barangMasuks = BarangMasuk::with('barang')
            ->when($from && $to, fn($q) => $q->whereBetween('tanggal_masuk', [$from, $to]))
            ->get();

        $barangKeluars = BarangKeluar::with('barang')
            ->when($from && $to, fn($q) => $q->whereBetween('tanggal_keluar', [$from, $to]))
            ->get();

        $pdf = Pdf::loadView('admin.laporan.pdf', compact('barangs', 'barangMasuks', 'barangKeluars'));
        return $pdf->stream();
    }
}
