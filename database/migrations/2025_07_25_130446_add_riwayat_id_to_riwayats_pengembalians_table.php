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
        Schema::table('riwayats_pengembalians', function (Blueprint $table) {
            $table->string('riwayat_id')->after('barang_id')->nullable();
            $table->foreign('riwayat_id')->references('id')->on('riwayats')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('riwayats_pengembalians', function (Blueprint $table) {
            $table->dropForeign(['riwayat_id']);
            $table->dropColumn('riwayat_id');
        });
    }
};
