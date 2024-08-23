<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserEditorController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BidangController;
use App\Http\Controllers\DpaController;
use App\Http\Controllers\KegiatanController;
use App\Http\Controllers\UraianController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\NotulenController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\JenisRapatController;


Route::get('/pdf', [PdfController::class, 'generatePDF'])->middleware('auth');
// Notulen
Route::resource('notulen', NotulenController::class)->middleware('auth');
Route::get('notulen/generatePDF/{id}', [NotulenController::class, 'generatePDF'])->name('notulen.generatePDF')->middleware('auth');
Route::put('/notulen/{id}', [NotulenController::class, 'update'])->name('notulen.update')->middleware('auth');
Route::get('/notulen/{id}', [NotulenController::class, 'show'])->name('notulen.show')->middleware('auth');

// Menampilkan formulir untuk meminta link reset password
Route::get('/password/reset', [PasswordResetController::class, 'showLinkRequestForm'])->name('password.request');

// Mengirimkan link reset password
Route::post('/password/email', [PasswordResetController::class, 'sendResetLinkEmail'])->name('password.email');


// Rute untuk halaman reset password
Route::get('/password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');

// Route User Editor
Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show')->middleware('auth');
Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update')->middleware('auth');

Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show')->middleware('auth');
Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update')->middleware('auth');

// Route Bidang
Route::resource('bidang', BidangController::class)->middleware('auth');
// Route DPA
Route::resource('dpa', DpaController::class)->middleware('auth');

// Route login
Route::get('/login', [AuthController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'authenticate']);
Route::get('/register', [AuthController::class, 'register']);
Route::post('/register', [AuthController::class, 'process']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth');

// Route dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth');
Route::get('/', [DashboardController::class, 'index'])->middleware('auth');

// Reports
Route::resource('reports', ReportController::class)->middleware('auth');

// route jadwal rapat
Route::resource('jadwal-rapat', JadwalController::class)->middleware('auth');

// route Uraian
Route::resource('uraian', UraianController::class)->middleware('auth');


// route kegiatan
Route::resource('kegiatan', KegiatanController::class)->middleware('auth');

Route::resource('pegawai', PegawaiController::class)->middleware('auth');

// route jenis rapat
Route::resource('jenis-rapat', JenisRapatController::class)->middleware('auth');