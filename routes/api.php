<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\RegisterController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [RegisterController::class, 'register'])->name('register');
Route::post('/login', [LoginController::class, 'login'])->name('login');

Route::middleware('auth:sanctum')->group(function () {
    Route::group(['prefix' => 'posts'], function () {
        Route::get('/', [PostController::class, 'list']);
        Route::get('/{id}', [PostController::class, 'getPost']);
        Route::post('/', [PostController::class, 'createPost']);
        Route::patch('/{id}', [PostController::class, 'updatePost']);
        Route::delete('/{id}', [PostController::class, 'deletePost']);
    });
});
