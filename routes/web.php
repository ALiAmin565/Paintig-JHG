<?php

use App\Http\Controllers\Api\HotelController as ApiHotelController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\PaintingController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect()->route('login'));

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::resource('hotels', HotelController::class)->only(['index', 'show']);
    Route::get('paintings/{painting}/photo', [PaintingController::class, 'photo'])->name('paintings.photo');
    Route::resource('paintings', PaintingController::class);
    Route::get('/api/hotels', [ApiHotelController::class, 'index'])->name('api.hotels');
});
