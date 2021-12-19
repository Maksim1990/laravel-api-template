<?php

use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Route;

Route::post('login', [AuthController::class,'login'])->name('login');
Route::post('register', [AuthController::class,'register'])->name('register');

Route::middleware('auth-token')->group(function () {
    Route::resource('users', UserController::class)->except(['edit', 'create']);
    Route::resource('posts', PostController::class)->except(['edit', 'create']);
});
