<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::middleware('auth:sanctum')->group(function () {
    Route::group(['prefix' => 'posts'], function () {
        Route::get('/', [PostController::class, 'getPosts']);
        Route::get('/{id}', [PostController::class, 'getPost']);
        Route::post('/', [PostController::class, 'createPost']);
        Route::patch('/{id}', [PostController::class, 'updatePost']);
        Route::delete('/{id}', [PostController::class, 'deletePost']);
    });
});
