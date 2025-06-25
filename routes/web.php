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
    Route::get('/movie/list', [MovieController::class, 'index'])->name('movie.list');
    Route::get('/movie/add', [MovieController::class, 'addMovie'])->name('movie.add');
    Route::post('/movie/store', [MovieController::class, 'storeMovie'])->name('movie.store');
    Route::get('/movie/{id}', [MovieController::class, 'showMovie'])->name('movie.show');
    Route::get('/movie/edit/{id}', [MovieController::class, 'editMovie'])->name('movie.edit');
    Route::get('/rating/add', [MovieController::class, 'addRating'])->name('rating.add');
    Route::post('/rating/store', [MovieController::class, 'storeRating'])->name('rating.store');
    Route::post('/movie/delete',[MovieController::class, 'deleteMovie'])->name('movie.delete');
});

?>
