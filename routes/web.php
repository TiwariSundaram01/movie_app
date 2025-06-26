<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MovieController;

Route::get('/', function () {
    return view('auth.register');
})->name('register');

Route::get('/add_admin', function () {
    return view('auth.register');
})->name('admin.register');

Route::get('/login', function(){
    return view('auth.login');
})->name('login');

Route::post('/register', [AuthController::class, 'register'])->name('auth.register');

Route::post('/login', [AuthController::class, 'login'])->name('auth.login');

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/logout', [AuthController::class, 'logout'])->name('auth.logout');

    Route::prefix('movie')->group(function () {
        Route::get('/list', [MovieController::class, 'index'])->name('movie.list');
        Route::get('/show/{id}', [MovieController::class, 'showMovie'])->name('movie.show');
    });
   
    Route::prefix('rating')->group(function () {
        Route::get('/add', [MovieController::class, 'addRating'])->name('rating.add');
        Route::post('/store', [MovieController::class, 'storeRating'])->name('rating.store');
    });

    Route::get('/notifications', function() {
        return auth()->user()->unreadNotifications;
    });
});

Route::middleware(['auth:sanctum', 'is.admin'])->group(function () {
    Route::prefix('movie')->group(function () {
        Route::get('/add', [MovieController::class, 'addMovie'])->name('movie.add');
        Route::get('/edit/{id}', [MovieController::class, 'editMovie'])->name('movie.edit');
        Route::post('/store', [MovieController::class, 'storeMovie'])->name('movie.store');
        Route::post('/delete',[MovieController::class, 'deleteMovie'])->name('movie.delete');
    });
});
?>
