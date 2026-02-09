<?php

use App\Http\Controllers\Api\CallbackController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\UserDashboardController;
use App\Http\Controllers\Api\UserIklanController;
use App\Http\Controllers\Api\UserKegiatanController;
use App\Http\Controllers\Api\UserMidtransController;
use App\Http\Controllers\Api\UserPembayaranController;
use App\Http\Controllers\Api\UserPengumumanController;
use App\Http\Controllers\Api\UserProfileController;
use App\Http\Controllers\Api\UserSaranController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// login & logout
Route::post('/login', [UserController::class, 'login']);
Route::post('/logout', [UserController::class, 'logout'])->middleware('auth:sanctum');

// semua route yang butuh token Sanctum
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::get('/pembayaran', [UserPembayaranController::class, 'index']);
    Route::get('/pembayaran/{id}', [UserPembayaranController::class, 'detail']);
   
    

    Route::get('/dashboard', [UserDashboardController::class, 'index']);
    Route::get('/iklan', [UserIklanController::class, 'index']);

    Route::get('/pengumuman', [UserPengumumanController::class, 'index']);
    Route::get('/pengumuman/{id}', [UserPengumumanController::class, 'show']);

    Route::get('/kegiatan', [UserKegiatanController::class, 'index']);
    Route::get('/kegiatan/{id}', [UserKegiatanController::class, 'show']);

    Route::get('/my-profile', [UserProfileController::class, 'index']);

    Route::get('/saran', [UserSaranController::class, 'index']);
    Route::post('/saran', [UserSaranController::class, 'store']);

    Route::post('/midtrans/bayar-semua', [UserMidtransController::class, 'bayarSemua']);

    Route::post('/midtrans/token', [UserMidtransController::class, 'token']);
    Route::get('/midtrans/finish', function () {
        return redirect('/'); // atau halaman dashboard
    });
    Route::get('/midtrans/unfinish', function () {
        return redirect('/'); // atau halaman pembayaran gagal
    });
    Route::get('/midtrans/error', function () {
        return redirect('/'); // atau halaman pembayaran error

    });

});

Route::post('/midtrans/callback',
    [CallbackController::class, 'handle']
);
