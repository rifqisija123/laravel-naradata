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
        Schema::create('riwayats', function (Blueprint $table) {
            $table->string('id', 20)->primary()->unique();
            $table->string('jenis_id');
            $table->string('barang_id');
            $table->string('nama_barang');
            $table->string('karyawan_id');
            $table->text('keterangan')->nullable();
            $table->date('tanggal');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('jenis_id')->references('id')->on('jenis');
            $table->foreign('barang_id')->references('id')->on('barangs');
            $table->foreign('karyawan_id')->references('id')->on('karyawans');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('riwayats');
    }
};
