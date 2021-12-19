<?php

use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

Route::resource('users', UserController::class)->except(['edit', 'create']);
Route::resource('posts', PostController::class)->except(['edit', 'create']);
