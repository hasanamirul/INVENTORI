<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\KategoriBarang;
use App\Models\BarangMasuk;
use App\Models\BarangKeluar; // Import model BarangMasuk
use Illuminate\Support\Carbon; // Import Carbon untuk tanggal

class BarangController extends Controller
{
    // Menggunakan boot() untuk Model Event agar log BarangMasuk terhapus otomatis
    // saat Barang dihapus. Ini lebih bersih daripada menuliskannya di destroy().
    public function __construct()
    {
        // Mendefinisikan aksi yang harus dilakukan sebelum Barang dihapus
        Barang::deleting(function ($barang) {
            // Hapus semua data BarangMasuk yang memiliki barang_id yang sama
            BarangMasuk::where('barang_id', $barang->id)->delete();
        });
    }

    public function index()
    {
        // Memuat relasi kategori untuk efisiensi
        $barangs = Barang::with('kategori')->get();
        return view('admin.barang.index', compact('barangs'));
    }

    public function create()
    {
        $kategoris = KategoriBarang::all();
        return view('admin.barang.create', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            // Menggunakan 'nama_barang' sesuai dengan $fillable di model Barang
            'nama_barang' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategori_barangs,id',
            'satuan' => 'nullable|string|max:50',
            'jumlah' => 'required|integer|min:1', // Harus ada jumlah minimal 1 untuk barang masuk
            // 'terpakai' tidak perlu divalidasi, akan diset 0
            // 'tanggal' tidak perlu divalidasi karena kita ambil tanggal hari ini
            'status' => 'nullable|string|max:50',
            'keterangan' => 'nullable|string',
        ]);

        // 1. Buat Barang baru
        $barang = Barang::create([
            'nama_barang' => $validated['nama_barang'],
            'kategori_id' => $validated['kategori_id'],
            'satuan' => $validated['satuan'],
            'jumlah' => $validated['jumlah'],
            // Set default/awal nilai
            'terpakai' => 0,
            'status' => $validated['status'] ?? 'Belum Terpakai',
            'keterangan' => $validated['keterangan'] ?? '-',
            'tanggal' => Carbon::now()->toDateString(), // Tambahkan tanggal pembuatan barang
        ]);

        // 2. Buat entri log BarangMasuk otomatis
        BarangMasuk::create([
            'barang_id' => $barang->id,
            'jumlah' => $barang->jumlah, // Jumlah barang yang masuk adalah jumlah saat dibuat
            'tanggal_masuk' => Carbon::now()->toDateString(), // Menggunakan tanggal hari ini
            'keterangan' => 'Stok Awal Barang Baru: ' . ($validated['keterangan'] ?? '-'),
        ]);

        return redirect()->route('admin.barang.index')->with('success', 'Barang baru dan log masuk berhasil ditambahkan.');
    }

    public function show($id)
    {
        $barang = Barang::findOrFail($id);
        return view('admin.barang.show', compact('barang'));
    }

    public function edit($id)
    {
        $barang = Barang::findOrFail($id);
        $kategoris = KategoriBarang::all();
        return view('admin.barang.edit', compact('barang', 'kategoris'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama_barang' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategori_barangs,id',
            'satuan' => 'nullable|string|max:50',
            // Jumlah barang boleh diubah, tapi tidak mempengaruhi log BarangMasuk secara otomatis
            'jumlah' => 'required|integer',
            'terpakai' => 'nullable|integer',
            'tanggal' => 'nullable|date',
            'status' => 'nullable|string|max:50',
            'keterangan' => 'nullable|string',
        ]);
        $barang = Barang::findOrFail($id);

        // Update data barang
        $barang->update($validated);

        return redirect()->route('admin.barang.index')->with('success', 'Barang berhasil diupdate.');
    }

    public function destroy($id)
    {
        $barang = Barang::findOrFail($id);

        // Penghapusan log BarangMasuk sudah ditangani oleh Model Event di __construct
        $barang->delete();

        return redirect()->route('admin.barang.index')->with('success', 'Barang dan semua log masuk terkait berhasil dihapus.');
    }

    // Aksi pakai dan batalkan
    public function pakai($id, Request $request)
    {
        $barang = Barang::findOrFail($id);
        $jumlahPakai = (int) $request->input('jumlah_pakai', 1);

        if ($jumlahPakai < 1 || $jumlahPakai > $barang->jumlah) {
            return back()->with('error', 'Jumlah pakai tidak valid atau melebihi stok tersedia.');
        }

        // Hitung sisa stok
        $sisaStok = $barang->jumlah - $jumlahPakai;

        // Kurangi stok barang
        $barang->jumlah = $sisaStok;
        $barang->terpakai = ($barang->terpakai ?? 0) + $jumlahPakai;
        $barang->updateStatus();
        $barang->save();

        // Catat barang keluar
        BarangKeluar::create([
            'barang_id'      => $barang->id,
            'jumlah'         => $jumlahPakai,
            'tanggal_keluar' => now()->toDateString(),
            'keterangan'     => $barang->keterangan ?? 'Pemakaian barang',
            'sisa_stok'      => $sisaStok,
        ]);

        return back()->with('success', "{$jumlahPakai} barang berhasil dipakai. Sisa stok: {$sisaStok}");
    }


    public function batalkanPakai($id, Request $request)
    {
        $barang = Barang::findOrFail($id);
        $jumlahBatal = (int) $request->input('jumlah_batal', 1);

        if ($jumlahBatal < 1 || $jumlahBatal > $barang->terpakai) {
            return back()->with('error', 'Jumlah batal tidak valid atau melebihi jumlah terpakai.');
        }

        // Kembalikan stok barang
        $barang->jumlah += $jumlahBatal;
        $barang->terpakai -= $jumlahBatal;
        $barang->updateStatus();
        $barang->save();

        // Hapus data barang keluar sesuai jumlah yang dibatalkan
        // Ambil transaksi terbaru dari barang keluar
        $barangKeluar = BarangKeluar::where('barang_id', $barang->id)
            ->orderBy('created_at', 'desc')
            ->first();

        if ($barangKeluar) {
            // Jika jumlah di barang keluar sama dengan jumlah batal → hapus transaksi
            if ($barangKeluar->jumlah == $jumlahBatal) {
                $barangKeluar->delete();
            }
            // Jika jumlah batal lebih kecil dari transaksi terakhir → kurangi
            elseif ($barangKeluar->jumlah > $jumlahBatal) {
                $barangKeluar->jumlah -= $jumlahBatal;
                $barangKeluar->sisa_stok = $barang->jumlah;
                $barangKeluar->save();
            }
        }

        return back()->with('success', "{$jumlahBatal} barang berhasil dibatalkan. Stok dikembalikan.");
    }
}
