<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegisterController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    Route::get('/register-pendapatan', [RegisterController::class, 'index'])->name('register.index');
    Route::get('/register-pendapatan/tambah', [RegisterController::class, 'create'])->name('register.create');
    Route::post('/register-pendapatan', [RegisterController::class, 'store'])->name('register.store');
    Route::get('/register-pendapatan/cetak', [RegisterController::class, 'print'])->name('register.print');

    // --- ROTE MANUAL CRUD REGISTER PENDAPATAN SIBEN ---
    // Menampilkan Form Edit Data (Membawa parameter ID unik data)
    Route::get('register-pendapatan{id}/edit', [RegisterController::class, 'edit'])->name('register.edit');
    // Memproses Simpan Perubahan Data (Update - Menggunakan Metode PUT)
    Route::put('/register-pendapatan{id}', [RegisterController::class, 'update'])->name('register.update');
    // Memproses Hapus Data Permanen (Destroy - Menggunakan Metode DELETE)
    Route::delete('/register-pendapatan{id}', [RegisterController::class, 'destroy'])->name('register.destroy');
});
    
require __DIR__ . '/auth.php';
