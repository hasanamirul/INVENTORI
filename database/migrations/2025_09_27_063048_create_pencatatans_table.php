<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pencatatans', function (Blueprint $table) {
            $table->id();
            $table->string('judul');          // contoh: judul pencatatan
            $table->text('deskripsi');        // contoh: deskripsi
            $table->date('tanggal');          // tanggal pencatatan
            $table->unsignedBigInteger('user_id')->nullable(); // jika ada user yang buat
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pencatatans');
    }
};
