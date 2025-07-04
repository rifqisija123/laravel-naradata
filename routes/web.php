<?php

use App\Http\Controllers\BarangController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\JenisController;
use App\Http\Controllers\LokasiController;
use App\Http\Controllers\KaryawanController;
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
Route::post('/karyawan/store', [KaryawanController::class, 'store'])->name('karyawan.store');
Route::post('/barang/store', [BarangController::class, 'store'])->name('barang.store');
Route::delete('/barang/delete/{id}', [BarangController::class, 'destroy'])->name('barang.destroy');
Route::get('/barang', [BarangController::class, 'index'])->name('barang.index');
Route::get('/barang/create', [BarangController::class, 'create'])->name('barang.create');
Route::get('/barang/show/{id}', [BarangController::class, 'show'])->name('barang.show');
Route::get('/barang/edit/{id}', [BarangController::class, 'edit'])->name('barang.edit');
Route::put('/barang/update/{id}', [BarangController::class, 'update'])->name('barang.update');
Route::post('/jenis/store', [JenisController::class, 'store'])->name('jenis.store');
Route::get('/jenis', [JenisController::class, 'index'])->name('jenis.index');
Route::get('/jenis/show/{id}', [JenisController::class, 'show'])->name('jenis.show');
Route::put('/jenis/update/{id}', [JenisController::class, 'update'])->name('jenis.update');
Route::delete('/jenis/delete/{id}', [JenisController::class, 'destroy'])->name('jenis.destroy');
