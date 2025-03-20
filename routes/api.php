<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\AuthController;

Route::prefix('v2')->group(function () {
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/user', [UserController::class, 'show']);
        Route::put('/user', [UserController::class, 'update']);
        Route::delete('/user', [UserController::class, 'destroy']);

        Route::patch('/user/email', [UserController::class, 'updateEmail']);
        Route::patch('/user/password', [UserController::class, 'updatePassword']);
        Route::patch('/user/photo', [UserController::class, 'updatePhoto']);
        Route::patch('/user/photos', [UserController::class, 'updatePhotos']);
    });

    Route::post('/auth/register', [AuthController::class, 'register']);
    Route::post('/auth/login', [AuthController::class, 'login']);
});
