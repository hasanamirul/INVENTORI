<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BarangKeluar;
use App\Models\Barang;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class BarangKeluarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Muat relasi barang + kategori
        $barangKeluars = BarangKeluar::with('barang.kategori')->latest()->get();
        return view('admin.barang-keluar.index', compact('barangKeluars'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $barangs = Barang::all();
        return view('admin.barang-keluar.create', compact('barangs'));
    }

    /**
     * Store a newly created resource in storage.
     * Logika: Kurangi stok di Barang dan tambahkan ke 'terpakai'.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'barang_id' => 'required|exists:barangs,id',
            'jumlah' => 'required|integer|min:1',
            'tanggal_keluar' => 'nullable|date', // boleh kosong, auto isi hari ini
            'keterangan' => 'nullable|string',
        ]);

        return DB::transaction(function () use ($validated) {
            $barang = Barang::findOrFail($validated['barang_id']);

            // Pastikan stok cukup
            if ($validated['jumlah'] > $barang->jumlah) {
                return back()->with('error', 'Jumlah barang keluar melebihi stok tersedia (' . $barang->jumlah . ').');
            }

            // Simpan log BarangKeluar
            BarangKeluar::create([
                'barang_id' => $validated['barang_id'],
                'jumlah' => $validated['jumlah'],
                'tanggal_keluar' => $validated['tanggal_keluar'] ?? Carbon::now()->toDateString(),
                'keterangan' => $validated['keterangan'] ?? null,
            ]);

            // Update stok Barang
            $barang->jumlah -= $validated['jumlah'];
            $barang->terpakai = ($barang->terpakai ?? 0) + $validated['jumlah'];
            $barang->updateStatus();
            $barang->save();

            return redirect()->route('admin.barang-keluar.index')
                ->with('success', 'Barang keluar berhasil ditambahkan. Stok barang diperbarui.');
        });
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $barangKeluar = BarangKeluar::with('barang')->findOrFail($id);
        $barangs = Barang::all();
        return view('admin.barang-keluar.edit', compact('barangKeluar', 'barangs'));
    }

    /**
     * Update the specified resource in storage.
     * Logika: Hitung selisih jumlah untuk menyesuaikan stok kembali.
     */
    public function update(Request $request, string $id)
    {
        $barangKeluar = BarangKeluar::findOrFail($id);
        $oldJumlah = $barangKeluar->jumlah;

        $validated = $request->validate([
            'barang_id' => 'required|exists:barangs,id',
            'jumlah' => 'required|integer|min:1',
            'tanggal_keluar' => 'nullable|date',
            'keterangan' => 'nullable|string',
        ]);

        return DB::transaction(function () use ($validated, $barangKeluar, $oldJumlah) {
            $barang = Barang::findOrFail($validated['barang_id']);
            $newJumlah = $validated['jumlah'];
            $diffJumlah = $newJumlah - $oldJumlah;

            // Stok yang tersedia saat ini + jumlah lama (karena mau disesuaikan)
            $stokTersedia = $barang->jumlah + $oldJumlah;

            if ($newJumlah > $stokTersedia) {
                return back()->with('error', 'Update gagal. Jumlah baru melebihi stok tersedia.');
            }

            // Update log BarangKeluar
            $barangKeluar->update([
                'barang_id' => $validated['barang_id'],
                'jumlah' => $newJumlah,
                'tanggal_keluar' => $validated['tanggal_keluar'] ?? Carbon::now()->toDateString(),
                'keterangan' => $validated['keterangan'] ?? null,
            ]);

            // Update stok Barang
            $barang->jumlah -= $diffJumlah;
            $barang->terpakai = ($barang->terpakai ?? 0) + $diffJumlah;

            if ($barang->terpakai < 0) {
                $barang->terpakai = 0;
            }

            $barang->updateStatus();
            $barang->save();

            return redirect()->route('admin.barang-keluar.index')
                ->with('success', 'Barang keluar berhasil diupdate. Stok barang disesuaikan.');
        });
    }

    /**
     * Remove the specified resource from storage.
     * Logika: Kembalikan stok yang terpakai ke stok tersedia.
     */
    public function destroy(string $id)
    {
        $barangKeluar = BarangKeluar::findOrFail($id);

        return DB::transaction(function () use ($barangKeluar) {
            $barang = Barang::findOrFail($barangKeluar->barang_id);

            // Revert stok
            $barang->jumlah += $barangKeluar->jumlah;
            $barang->terpakai -= $barangKeluar->jumlah;

            if ($barang->terpakai < 0) {
                $barang->terpakai = 0;
            }

            $barang->updateStatus();
            $barang->save();

            // Hapus log
            $barangKeluar->delete();

            return redirect()->route('admin.barang-keluar.index')
                ->with('success', 'Barang keluar berhasil dihapus. Stok barang dikembalikan.');
        });
    }
}