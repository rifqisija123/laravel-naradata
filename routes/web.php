<?php

use App\Http\Controllers\BarangController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\JenisController;
use App\Http\Controllers\LokasiController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RiwayatController;
use App\Http\Controllers\FilterController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

//route untuk halaman utama
Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        return view('home');
    })->name('home');

    //route untuk halaman dashboard
    Route::get('/dashboard', [BarangController::class, 'dashboard'])->name('dashboard');

    //route untuk halaman barang
    Route::get('/barang', [BarangController::class, 'index'])->name('barang.index');
    Route::get('/barang/create', [BarangController::class, 'create'])->name('barang.create');
    Route::post('/barang/store', [BarangController::class, 'store'])->name('barang.store');
    Route::get('/barang/show/{id}', [BarangController::class, 'show'])->name('barang.show');
    Route::get('/barang/edit/{id}', [BarangController::class, 'edit'])->name('barang.edit');
    Route::put('/barang/update/{id}', [BarangController::class, 'update'])->name('barang.update');
    Route::get('/barang/import', [BarangController::class, 'importPage'])->name('barang.import');
    Route::post('/import/barang', [BarangController::class, 'import'])->name('import.barang');
    Route::delete('/barang/delete/{id}', [BarangController::class, 'destroy'])->name('barang.destroy');

    //route untuk halaman kategori
    Route::get('/kategori', [KategoriController::class, 'index'])->name('kategori.index');
    Route::post('/kategori/store', [KategoriController::class, 'store'])->name('kategori.store');
    Route::get('/kategori/show/{id}', [KategoriController::class, 'show'])->name('kategori.show');
    Route::put('/kategori/update/{id}', [KategoriController::class, 'update'])->name('kategori.update');
    Route::delete('/kategori/delete/{id}', [KategoriController::class, 'destroy'])->name('kategori.destroy');

    //route untuk halaman lokasi
    Route::get('/lokasi', [LokasiController::class, 'index'])->name('lokasi.index');
    Route::post('/lokasi/store', [LokasiController::class, 'store'])->name('lokasi.store');
    Route::get('/lokasi/show/{id}', [LokasiController::class, 'show'])->name('lokasi.show');
    Route::put('/lokasi/update/{id}', [LokasiController::class, 'update'])->name('lokasi.update');
    Route::delete('/lokasi/delete/{id}', [LokasiController::class, 'destroy'])->name('lokasi.destroy');

    //route untuk halaman karyawan
    Route::get('/karyawan', [KaryawanController::class, 'index'])->name('karyawan.index');
    Route::get('/karyawan/create', [KaryawanController::class, 'create'])->name('karyawan.create');
    Route::post('/karyawan/store', [KaryawanController::class, 'store'])->name('karyawan.store');
    Route::get('/karyawan/show/{id}', [KaryawanController::class, 'show'])->name('karyawan.show');
    Route::get('/karyawan/edit/{id}', [KaryawanController::class, 'edit'])->name('karyawan.edit');
    Route::put('/karyawan/update/{id}', [KaryawanController::class, 'update'])->name('karyawan.update');
    Route::delete('/karyawan/delete/{id}', [KaryawanController::class, 'destroy'])->name('karyawan.destroy');

    //route untuk halaman jenis
    Route::get('/jenis', [JenisController::class, 'index'])->name('jenis.index');
    Route::post('/jenis/store', [JenisController::class, 'store'])->name('jenis.store');
    Route::get('/jenis/show/{id}', [JenisController::class, 'show'])->name('jenis.show');
    Route::put('/jenis/update/{id}', [JenisController::class, 'update'])->name('jenis.update');
    Route::delete('/jenis/delete/{id}', [JenisController::class, 'destroy'])->name('jenis.destroy');

    //route untuk halaman riwayat
    Route::get('/riwayat', [RiwayatController::class, 'index'])->name('riwayat.index');
    Route::get('/riwayat/create', [RiwayatController::class, 'create'])->name('riwayat.create');
    Route::post('/riwayat/store', [RiwayatController::class, 'store'])->name('riwayat.peminjaman.store');
    Route::get('/riwayat/show/{id}', [RiwayatController::class, 'show'])->name('riwayat.show');
    Route::get('/riwayat/edit/{id}', [RiwayatController::class, 'edit'])->name('riwayat.edit');
    Route::put('/riwayat/update/{id}', [RiwayatController::class, 'update'])->name('riwayat.update');
    Route::delete('/riwayat/delete/{id}', [RiwayatController::class, 'destroy'])->name('riwayat.destroy');
    Route::get('/riwayat/export/{format}', [RiwayatController::class, 'export'])->name('riwayat.export');
    Route::get('/riwayat/filter', [RiwayatController::class, 'filter'])->name('riwayat.filter');

    //route untuk edit profile
    Route::get('/profile/edit', [ProfileController::class, 'editProfile'])->name('edit.profile');
    Route::put('/profile/update', [ProfileController::class, 'updateProfile'])->name('profile.update');
});

//route untuk API barang berdasarkan jenis
Route::get('/api/barang-by-jenis/{jenis}', [BarangController::class, 'getBarangByJenis'])->name('barang.byJenis');

//route untuk filter riwayat
Route::get('/riwayat/filter/result', [FilterController::class, 'filterResult'])->name('filter.result');

// route auth  
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.action');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.action');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
