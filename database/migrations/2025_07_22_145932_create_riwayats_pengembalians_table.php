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
        Schema::create('riwayats_pengembalians', function (Blueprint $table) {
            $table->string('id', 20)->primary()->unique();
            $table->string('karyawan_id');
            $table->string('nama_karyawan');
            $table->string('jenis_id');
            $table->string('barang_id');
            $table->string('nama_barang');
            $table->text('keterangan')->nullable();
            $table->text('kondisi');
            $table->date('tanggal');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('karyawan_id')->references('id')->on('karyawans');
            $table->foreign('jenis_id')->references('merek_id')->on('jenis');
            $table->foreign('barang_id')->references('id')->on('barangs');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('riwayats_pengembalians');
    }
};
