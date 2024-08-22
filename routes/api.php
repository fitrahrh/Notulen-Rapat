<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\ProfileController;

// Dashboard Get Jadwal
Route::get('/jadwal', [JadwalController::class, 'getJadwal']);

// API USER
Route::post('/login', [AuthController::class, 'apiLogin']);
Route::post('/register', [AuthController::class, 'apiRegister']);
Route::post('/logout', [AuthController::class, 'apiLogout'])->middleware('auth:sanctum');

// API JADWAL RAPAT
Route::get('/jadwal-rapat', [JadwalController::class, 'apiIndex'])->middleware('auth:sanctum');
Route::post('/jadwal-rapat', [JadwalController::class, 'apiStore'])->middleware('auth:sanctum');
Route::get('/jadwal-rapat/{id}', [JadwalController::class, 'apiShow'])->middleware('auth:sanctum');
Route::delete('/jadwal-rapat/{id}', [JadwalController::class, 'apiDestroy'])->middleware('auth:sanctum');

// API PEGAWAI
Route::get('/pegawai', [PegawaiController::class, 'apiIndex'])->middleware('auth:sanctum');
Route::post('/pegawai', [PegawaiController::class, 'apiStore'])->middleware('auth:sanctum');
Route::get('/pegawai/{id}', [PegawaiController::class, 'apiShow'])->middleware('auth:sanctum');
Route::put('/pegawai/{id}', [PegawaiController::class, 'apiUpdate'])->middleware('auth:sanctum');
Route::delete('/pegawai/{id}', [PegawaiController::class, 'apiDestroy'])->middleware('auth:sanctum');

// API NOTULEN
Route::get('/notulen', [NotulenController::class, 'apiIndex'])->middleware('auth:sanctum');
Route::get('/notulen/{id}', [NotulenController::class, 'apiShow'])->middleware('auth:sanctum');
Route::get('/notulen/download-pdf/{id}', [NotulenController::class, 'apiDownloadPDF'])->middleware('auth:sanctum');
Route::get('/notulen/generate-pdf/{id}/{format}', [NotulenController::class, 'apiGeneratePDF'])->middleware('auth:sanctum');

Route::post('/profile', [ProfileController::class, 'updateProfileApi'])->middleware('auth:sanctum');
// Route baru untuk fitur pencarian jadwal rapat
Route::get('/search-jadwal', [JadwalController::class, 'searchJadwal'])->middleware('auth:sanctum');