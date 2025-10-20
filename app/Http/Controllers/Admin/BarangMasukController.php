<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BarangMasuk;
use App\Models\Barang;

class BarangMasukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // gunakan nama variabel jamak supaya konsisten dengan blade
        $barangMasuks = BarangMasuk::with('barang.kategori')->get();
        return view('admin.barang-masuk.index', compact('barangMasuks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $barangs = Barang::all();
        return view('admin.barang-masuk.create', compact('barangs'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'barang_id' => 'required|exists:barangs,id',
            'jumlah' => 'required|integer|min:1',
            'tanggal_masuk' => 'required|date',
            'keterangan' => 'nullable|string',
        ]);

        // 1. Simpan log BarangMasuk
        $barangMasuk = BarangMasuk::create($validated);

        // 2. Update stok barang
        $barang = Barang::findOrFail($validated['barang_id']);
        $barang->jumlah += $validated['jumlah'];
        $barang->updateStatus();
        $barang->save();

        return redirect()->route('admin.barang-masuk.index')->with('success', 'Barang masuk berhasil ditambahkan. Stok barang telah diperbarui.');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        $barangMasuk = BarangMasuk::findOrFail($id);
        $barangs = Barang::all();
        return view('admin.barang-masuk.edit', compact('barangMasuk', 'barangs'));
    }

    public function update(Request $request, string $id)
    {
        $barangMasuk = BarangMasuk::findOrFail($id);
        $oldJumlah = $barangMasuk->jumlah;

        $validated = $request->validate([
            'barang_id' => 'required|exists:barangs,id',
            'jumlah' => 'required|integer|min:1',
            'tanggal_masuk' => 'required|date',
            'keterangan' => 'nullable|string',
        ]);

        if ($barangMasuk->barang_id != $validated['barang_id']) {
            return back()->with('error', 'Perubahan Barang harus dilakukan melalui proses terpisah untuk menjaga integritas stok.');
        }

        $diffJumlah = $validated['jumlah'] - $oldJumlah;

        $barangMasuk->update($validated);

        $barang = Barang::findOrFail($validated['barang_id']);
        $barang->jumlah += $diffJumlah;
        $barang->updateStatus();
        $barang->save();

        return redirect()->route('admin.barang-masuk.index')->with('success', 'Barang masuk berhasil diupdate. Stok barang telah disesuaikan.');
    }

    public function destroy(string $id)
    {
        $barangMasuk = BarangMasuk::findOrFail($id);

        $barang = Barang::findOrFail($barangMasuk->barang_id);
        $barang->jumlah -= $barangMasuk->jumlah;
        if ($barang->jumlah < 0) $barang->jumlah = 0;

        $barang->updateStatus();
        $barang->save();

        $barangMasuk->delete();

        return redirect()->route('admin.barang-masuk.index')->with('success', 'Barang masuk berhasil dihapus. Stok barang telah dikurangi.');
    }
}
