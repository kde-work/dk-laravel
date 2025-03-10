<?php
use Illuminate\Support\Facades\Route;

Route::prefix('v2')->group(function () {
    require './routes.php';
});