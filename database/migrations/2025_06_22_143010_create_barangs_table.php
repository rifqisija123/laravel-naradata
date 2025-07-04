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
        Schema::create('barangs', function (Blueprint $table) {
            $table->string('id', 50)->primary()->unique();
            $table->string('nama_barang');
            $table->string('kategori_id');
            $table->string('jenis_id');
            $table->string('lokasi_id');
            $table->tinyInteger('kelengkapan')->default(0);
            $table->text('keterangan')->nullable();
            $table->tinyInteger('status')->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('kategori_id')->references('id')->on('kategoris');
            $table->foreign('jenis_id')->references('id')->on('jenis');
            $table->foreign('lokasi_id')->references('id')->on('lokasis');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barangs');
    }
};
