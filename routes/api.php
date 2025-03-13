<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;

Route::prefix('v2')->group(function () {
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/user', [UserController::class, 'show']); // Получение профиля
        Route::put('/user', [UserController::class, 'update']); // Обновление профиля
        Route::delete('/user', [UserController::class, 'destroy']); // Удаление пользователя
    });
});