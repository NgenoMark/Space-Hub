<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\InactiveLogoutController;

// routes/api.php

Route::middleware('auth:sanctum')->post('/user/inactive-logout', [InactiveLogoutController::class, 'logout']);



Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// routes/api.php


Route::post('/user/inactive-logout', [InactiveLogoutController::class, 'logout']);

