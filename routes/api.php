<?php

use App\Http\Controllers\PembelianController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('pembelian', [PembelianController::class, 'index'])->name('pembelian.index');
// Route::post('pembelianAdd', [PembelianController::class, 'store'])->name ('pembelian.store');
// Route::patch('pembelianUpdate/{id}', [PembelianController::class, 'update'])->name ('pembelian.update');
// Route::delete('pembelianDelete/{id}', [PembelianController::class, 'destroy'])->name ('pembelian.destroy');
// // Route::get('pembelianAdd', [PembelianController::class, 'store'])->name('pembelian.store');
// // Route::get('pembelianUpdate/{id}', [PembelianController::class, 'update'])->name('pembelian.update');
// // Route::get('pembelianDelete/{id}', [PembelianController::class, 'delete'])->name('pembelian.delete');


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
