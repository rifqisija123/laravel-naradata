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
use App\Http\Controllers\ChatController;
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
    Route::get('/kategori/import', [KategoriController::class, 'importPage'])->name('kategori.import');
    Route::post('/import/kategori', [KategoriController::class, 'import'])->name('import.kategori');
    Route::delete('/kategori/delete/{id}', [KategoriController::class, 'destroy'])->name('kategori.destroy');

    //route untuk halaman lokasi
    Route::get('/lokasi', [LokasiController::class, 'index'])->name('lokasi.index');
    Route::post('/lokasi/store', [LokasiController::class, 'store'])->name('lokasi.store');
    Route::get('/lokasi/show/{id}', [LokasiController::class, 'show'])->name('lokasi.show');
    Route::put('/lokasi/update/{id}', [LokasiController::class, 'update'])->name('lokasi.update');
    Route::get('/lokasi/import', [LokasiController::class, 'importPage'])->name('lokasi.import');
    Route::post('/import/lokasi', [LokasiController::class, 'import'])->name('import.lokasi');
    Route::delete('/lokasi/delete/{id}', [LokasiController::class, 'destroy'])->name('lokasi.destroy');

    //route untuk halaman karyawan
    Route::get('/karyawan', [KaryawanController::class, 'index'])->name('karyawan.index');
    Route::get('/karyawan/create', [KaryawanController::class, 'create'])->name('karyawan.create');
    Route::post('/karyawan/store', [KaryawanController::class, 'store'])->name('karyawan.store');
    Route::get('/karyawan/show/{id}', [KaryawanController::class, 'show'])->name('karyawan.show');
    Route::get('/karyawan/edit/{id}', [KaryawanController::class, 'edit'])->name('karyawan.edit');
    Route::put('/karyawan/update/{id}', [KaryawanController::class, 'update'])->name('karyawan.update');
    Route::get('/karyawan/import', [KaryawanController::class, 'importPage'])->name('karyawan.import');
    Route::post('/import/karyawan', [KaryawanController::class, 'import'])->name('import.karyawan');
    Route::delete('/karyawan/delete/{id}', [KaryawanController::class, 'destroy'])->name('karyawan.destroy');

    //route untuk halaman jenis
    Route::get('/jenis', [JenisController::class, 'index'])->name('jenis.index');
    Route::get('/jenis/autocomplete', [JenisController::class, 'autocomplete'])->name('jenis.autocomplete');
    Route::post('/jenis/store', [JenisController::class, 'store'])->name('jenis.store');
    Route::get('/jenis/show/{id}', [JenisController::class, 'show'])->name('jenis.show');
    Route::put('/jenis/update/{id}', [JenisController::class, 'update'])->name('jenis.update');
    Route::get('/jenis/import', [JenisController::class, 'importPage'])->name('jenis.import');
    Route::post('/import/jenis', [JenisController::class, 'import'])->name('import.jenis');
    Route::delete('/jenis/delete/{id}', [JenisController::class, 'destroy'])->name('jenis.destroy');

    //route untuk halaman riwayat peminjaman dan pengembalian
    Route::get('/riwayat', [RiwayatController::class, 'index'])->name('riwayat.index');
    Route::get('/riwayat/create', [RiwayatController::class, 'create'])->name('riwayat.create');
    Route::post('/riwayat/peminjaman/store', [RiwayatController::class, 'store'])->name('riwayat.peminjaman.store');
    Route::post('/riwayat/pengembalian/store', [RiwayatController::class, 'storePengembalian'])->name('riwayat.pengembalian.store');
    Route::get('/riwayat/show/{id}', [RiwayatController::class, 'show'])->name('riwayat.show');
    Route::get('/riwayat/show/pengembalian/{id}', [RiwayatController::class, 'showPengembalian'])->name('riwayat.pengembalian.show');
    Route::get('/riwayat/edit/{id}', [RiwayatController::class, 'edit'])->name('riwayat.edit');
    Route::get('/riwayat/edit/pengembalian/{id}', [RiwayatController::class, 'editPengembalian'])->name('riwayat.pengembalian.edit');
    Route::put('/riwayat/update/{id}', [RiwayatController::class, 'update'])->name('riwayat.update');
    Route::put('/riwayat/update/pengembalian/{id}', [RiwayatController::class, 'updatePengembalian'])->name('riwayat.pengembalian.update');
    Route::delete('/riwayat/delete/{id}', [RiwayatController::class, 'destroy'])->name('riwayat.destroy');
    Route::delete('/riwayat/delete/pengembalian/{id}', [RiwayatController::class, 'destroyPengembalian'])->name('riwayat.pengembalian.destroy');
    Route::get('/riwayat/export/{format}', [RiwayatController::class, 'export'])->name('riwayat.export');
    Route::get('/riwayat/export/pengembalian/{format}', [RiwayatController::class, 'exportPengembalian'])->name('riwayat.pengembalian.export');
    Route::get('/riwayat/filter', [RiwayatController::class, 'filter'])->name('riwayat.filter');

    //route untuk edit profile
    Route::get('/profile/edit', [ProfileController::class, 'editProfile'])->name('edit.profile');
    Route::put('/profile/update', [ProfileController::class, 'updateProfile'])->name('profile.update');
    Route::put('/profile/update/password', [ProfileController::class, 'updatePassword'])->name('profile.update.password');

    //route untuk halaman chat
    Route::get('/chat', [ChatController::class, 'index'])->name('chat');
    
    // API routes untuk chat
    Route::get('/api/chat/users', [ChatController::class, 'getUsers'])->name('chat.users');
    Route::get('/api/chat/messages', [ChatController::class, 'getMessages'])->name('chat.messages');
    Route::post('/api/chat/send', [ChatController::class, 'sendMessage'])->name('chat.send');
    Route::post('/api/chat/update-last-seen', [ChatController::class, 'updateLastSeen'])->name('chat.update-last-seen');
    Route::post('/api/chat/mark-read', [ChatController::class, 'markAsRead'])->name('chat.mark-read');
});

//route untuk API barang berdasarkan jenis
Route::get('/api/barang-by-jenis/{jenis}', [BarangController::class, 'getBarangByJenis'])->name('barang.byJenis');

//route untuk API merek berdasarkan jenis
Route::get('/api/merek-by-jenis/{jenisId}', [BarangController::class, 'getMerekByJenis']);

//route untuk API barang berdasarkan jenis dan merek
Route::get('/api/barang-by-jenis-merek/{jenisId}/{merekId}', [BarangController::class, 'getBarangByJenisMerek']);

//route untuk API barang berdasarkan karyawan
Route::get('/api/barang-by-karyawan/{karyawan_id}', [BarangController::class, 'getBarangByKaryawan']);

//route untuk API edit barang berdasarkan barang yang sedang dipakai
Route::get('/api/barang-tersedia', [RiwayatController::class, 'getBarangTersedia']);

Route::get('/api/merek-by-jenis-karyawan/{jenis_id}/{karyawan_id}', [RiwayatController::class, 'getMerekByJenisAndKaryawan']);

Route::get('/api/barang-edit', [RiwayatController::class, 'getBarangEdit']);

Route::get('/api/jenisByKaryawan/{karyawan_id}', [RiwayatController::class, 'getJenisByKaryawan']);

//route untuk API barang berdasarkan karyawan dan jenis & merek
Route::get('/barang-by-jenis-karyawan/{jenis_id}/{karyawan_id}', [BarangController::class, 'getBarangByJenisAndKaryawan']);

Route::get('/merek-by-jenis-karyawan/{jenis_id}/{karyawan_id}', [BarangController::class, 'getMerekByJenisAndKaryawan']);

Route::get('/barang-by-karyawan-jenis-merek/{karyawan_id}/{jenis_id}/{merek_id}', [BarangController::class, 'getBarangByKaryawanJenisMerek']);

//route untuk API merek berdasarkan karyawan dan jenis
Route::get('/api/merek-by-karyawan-jenis/{karyawan_id}/{jenis_id}', [BarangController::class, 'getMerekByKaryawanAndJenis']);

//route untuk API barang berdasarkan karyawan, jenis, dan merek
Route::get('/api/barang-by-karyawan-jenis-merek/{karyawan_id}/{jenis_id}/{merek_id}', [BarangController::class, 'getBarangByKaryawanJenisMerek']);

//route untuk API jenis berdasarkan karyawan
Route::get('/api/jenis-by-karyawan/{karyawan_id}', [BarangController::class, 'getJenisByKaryawan']);

// Route API Fun Fact
Route::get('/api/fun-facts', [BarangController::class, 'getFunFacts'])->name('api.funfacts');

//route untuk filter riwayat
Route::get('/riwayat/filter/result', [FilterController::class, 'filterResult'])->name('filter.result');

// route auth
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.action');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.action');
Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('forgot.password');
Route::post('/forgot-password', [AuthController::class, 'handleForgotPassword'])->name('forgot.password.submit');
Route::get('/reset-password', [AuthController::class, 'showResetPassword'])->name('forgot.reset.password');
Route::post('/reset-password', [AuthController::class, 'handleResetPassword'])->name('forgot.reset.password.submit');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
