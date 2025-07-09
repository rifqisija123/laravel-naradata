<?php

use App\Http\Controllers\BarangController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\JenisController;
use App\Http\Controllers\LokasiController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\RiwayatController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::get('/dashboard', [BarangController::class, 'dashboard'])->name('dashboard');
Route::get('/barang/import', [BarangController::class, 'importPage'])->name('barang.import');
Route::post('/import/barang', [BarangController::class, 'import'])->name('import.barang');
Route::post('/kategori/store', [KategoriController::class, 'store'])->name('kategori.store');
Route::get('/kategori', [KategoriController::class, 'index'])->name('kategori.index');
Route::get('/kategori/show/{id}', [KategoriController::class, 'show'])->name('kategori.show');
Route::put('/kategori/update/{id}', [KategoriController::class, 'update'])->name('kategori.update');
Route::delete('/kategori/delete/{id}', [KategoriController::class, 'destroy'])->name('kategori.destroy');
Route::post('/lokasi/store', [LokasiController::class, 'store'])->name('lokasi.store');
Route::get('/lokasi', [LokasiController::class, 'index'])->name('lokasi.index');
Route::get('/lokasi/show/{id}', [LokasiController::class, 'show'])->name('lokasi.show');
Route::put('/lokasi/update/{id}', [LokasiController::class, 'update'])->name('lokasi.update');
Route::delete('/lokasi/delete/{id}', [LokasiController::class, 'destroy'])->name('lokasi.destroy');
Route::get('/karyawan', [KaryawanController::class, 'index'])->name('karyawan.index');
Route::get('/karyawan/create', [KaryawanController::class, 'create'])->name('karyawan.create');
Route::post('/karyawan/store', [KaryawanController::class, 'store'])->name('karyawan.store');
Route::get('/karyawan/show/{id}', [KaryawanController::class, 'show'])->name('karyawan.show');
Route::get('/karyawan/edit/{id}', [KaryawanController::class, 'edit'])->name('karyawan.edit');
Route::put('/karyawan/update/{id}', [KaryawanController::class, 'update'])->name('karyawan.update');
Route::delete('/karyawan/delete/{id}', [KaryawanController::class, 'destroy'])->name('karyawan.destroy');
Route::post('/barang/store', [BarangController::class, 'store'])->name('barang.store');
Route::delete('/barang/delete/{id}', [BarangController::class, 'destroy'])->name('barang.destroy');
Route::get('/barang', [BarangController::class, 'index'])->name('barang.index');
Route::get('/api/barang-by-jenis/{jenis}', [BarangController::class, 'getBarangByJenis'])->name('barang.byJenis');
Route::get('/barang/create', [BarangController::class, 'create'])->name('barang.create');
Route::get('/barang/show/{id}', [BarangController::class, 'show'])->name('barang.show');
Route::get('/barang/edit/{id}', [BarangController::class, 'edit'])->name('barang.edit');
Route::put('/barang/update/{id}', [BarangController::class, 'update'])->name('barang.update');
Route::post('/jenis/store', [JenisController::class, 'store'])->name('jenis.store');
Route::get('/jenis', [JenisController::class, 'index'])->name('jenis.index');
Route::get('/jenis/show/{id}', [JenisController::class, 'show'])->name('jenis.show');
Route::put('/jenis/update/{id}', [JenisController::class, 'update'])->name('jenis.update');
Route::delete('/jenis/delete/{id}', [JenisController::class, 'destroy'])->name('jenis.destroy');
Route::get('/riwayat', [RiwayatController::class, 'index'])->name('riwayat.index');
Route::get('/riwayat/create', [RiwayatController::class, 'create'])->name('riwayat.create');
Route::post('/riwayat/store', [RiwayatController::class, 'store'])->name('riwayat.store');
Route::get('/riwayat/show/{id}', [RiwayatController::class, 'show'])->name('riwayat.show');
Route::get('/riwayat/edit/{id}', [RiwayatController::class, 'edit'])->name('riwayat.edit');
Route::put('/riwayat/update/{id}', [RiwayatController::class, 'update'])->name('riwayat.update');
Route::delete('/riwayat/delete/{id}', [RiwayatController::class, 'destroy'])->name('riwayat.destroy');
Route::get('/riwayat/export/{format}', [RiwayatController::class, 'export'])->name('riwayat.export');
Route::get('/riwayat/filter', [RiwayatController::class, 'filter'])->name('riwayat.filter');
