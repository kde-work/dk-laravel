<?php
use Illuminate\Support\Facades\Route;

Route::prefix('v2')->group(function () {
    require '../OpenAPI/Server/routes.php';
});