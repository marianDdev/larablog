<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\Admin;
use App\Http\Middleware\Author;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::middleware('auth:sanctum')->group(function () {
    Route::group(['prefix' => 'posts'], function () {
        Route::get('/', [PostController::class, 'getPosts']);
        Route::get('/{id}', [PostController::class, 'getPost']);

        // only users with role author can access this routes
        Route::middleware(Author::class)->group(function () {
            Route::post('/', [PostController::class, 'createPost']);
            Route::patch('/{id}', [PostController::class, 'updatePost']);
            Route::delete('/{id}', [PostController::class, 'deletePost']);
        });
    });

    Route::group(['prefix' => 'users'], function () {
        Route::middleware(Admin::class)->group(function () {
            Route::get('/', [UserController::class, 'getUsers']);
            Route::get('/{id}', [UserController::class, 'getUser']);
        });
    });
});
