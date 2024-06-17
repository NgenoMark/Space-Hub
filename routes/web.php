<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers;
use App\Http\Controllers\LockScreenController;
use App\Http\Middleware\AuthGates;
use App\Http\Middleware\CheckIfLocked;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard')->middleware(['client'] , (CheckIfLocked::class));

    Route::get('/admin', function () {
        return view('admin');
    })->name('admin')->middleware(['admin'], (CheckIfLocked::class));

    Route::get('/superadmin', function () {
        return view('superadmin');
    })->name('superadmin')->middleware(['superadmin'], (CheckIfLocked::class));


    // Lock screen routes
    Route::get('/lock', [LockScreenController::class, 'show'])->name('lock');
    Route::post('/unlock', [LockScreenController::class, 'unlock'])->name('unlock');

    // Resources
    Route::resource('tasks', Controllers\TaskController::class)->middleware(CheckIfLocked::class);
    Route::resource('users', Controllers\UserController::class)->middleware([CheckIfLocked::class, AuthGates::class]);
});