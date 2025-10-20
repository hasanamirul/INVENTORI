<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('barangs', function (Blueprint $table) {
            $table->id();
            $table->string('nama_barang');
            $table->string('satuan'); // pcs, kg, kwintal,Rim, Kardus, Box, Liter
            $table->integer('jumlah')->default(0);
            $table->dateTime('tanggal')->nullable();
            $table->enum('status', ['Belum Terpakai', 'Sudah Terpakai'])->default('Belum Terpakai');
            $table->integer('jumlah_tersedia')->default(0);
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('barangs');
    }
};
