<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;

// Public Routes
Route::post('/register', [ApiController::class, 'register'])->name('auth.register');
Route::post('/login', [ApiController::class, 'login'])->name('auth.login');
Route::post('/logout', [ApiController::class, 'logout'])->name('auth.logout')->middleware('auth:sanctum');

// Protected Routes
Route::prefix('v1')->middleware(['auth:sanctum'])->group(function () {
    Route::prefix('movie')->group(function () {
        Route::get('/', [ApiController::class, 'listMovies'])->name('movies.list');
        Route::get('/{id}', [ApiController::class, 'showMovie'])->name('movies.show');
    });
});

?>