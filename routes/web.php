<?php

use App\Http\Controllers\DetailKonsinyasiController;
use App\Http\Controllers\DetailPembelianController;
use App\Http\Controllers\DetailPenjualanController;
use App\Http\Controllers\KonsinyasiController;
use App\Http\Controllers\KonsumenController;
use App\Http\Controllers\LaporanPembelianController;
use App\Http\Controllers\LaporanPenjualanController;
use App\Http\Controllers\PembelianController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\ProdukJualController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SupplierController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->group(function(){
    Route::resource('konsumen', KonsumenController::class);
    Route::resource('konsinyasi', KonsinyasiController::class);
    Route::resource('supplier', SupplierController::class);
    Route::resource('detailKonsinyasi', DetailKonsinyasiController::class);
    Route::resource('produk', ProdukController::class);
    Route::resource('produkJual', ProdukJualController::class);
    Route::resource('penjualan', PenjualanController::class);
    Route::resource('detailPenjualan', DetailPenjualanController::class);
    Route::resource('pembelian', PembelianController::class);
    Route::resource('detailPembelian', DetailPembelianController::class);
    Route::get('/produk/produk_name/{id}', [ProdukJualController::class, 'getProduk']);
    Route::resource('laporanPenjualan', LaporanPenjualanController::class);
    Route::resource('laporan_pembelian', LaporanPembelianController::class);

});


require __DIR__.'/auth.php';
