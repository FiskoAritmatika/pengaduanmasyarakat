<?php

use App\Http\Controllers\PengaduanController;
use App\Http\Controllers\TanggapanController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::resource('pengaduan', PengaduanController::class)->middleware('auth');
Route::resource('tanggapan', TanggapanController::class)->middleware('auth');

Route::get('/laporan', [PengaduanController::class, 'laporan'])->middleware('auth');
Route::get('/laporan/cetak', [PengaduanController::class, 'pdf'])->middleware('auth');