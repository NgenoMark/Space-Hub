<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers;
use App\Http\Controllers\LockScreenController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AuthGates;
use App\Http\Middleware\CheckIfLocked;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\SpaceController;
//use App\Http\Controllers\HomeController;
use App\Http\Controllers\WarehouseController;
use App\Http\Controllers\AdminSpaceController;
use App\Http\Controllers\AdminBookingController;

Route::middleware(['auth', 'admin'])->group(function () {
    // Define route for listing bookings
    Route::get('/admin/bookings', [AdminBookingController::class, 'index'])->name('admin.bookings.list');
});


Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/spaces/create', [AdminSpaceController::class, 'create'])->name('admin.spaces.create');
    Route::get('/admin/spaces', [AdminSpaceController::class, 'index'])->name('admin.spaces.index');
    Route::get('/admin/spaces/edit/{id}', [AdminSpaceController::class, 'edit'])->name('admin.spaces.edit');
    Route::post('/admin/spaces/update/{id}', [AdminSpaceController::class, 'update'])->name('admin.spaces.update');
});



Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');


Route::get('/warehouses', [WarehouseController::class, 'index'])->name('warehouses.index');



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
    })->name('dashboard')->middleware(['client', CheckIfLocked::class]);

    Route::get('/admin', function () {
        return view('admin');
    })->name('admin')->middleware(['admin', CheckIfLocked::class]);

    Route::get('/hostmanager', function () {
        return view('hostmanager');
    })->name('hostmanager')->middleware(['hostmanager', CheckIfLocked::class]);

    Route::get('/superadmin', [SuperAdminController::class, 'index'])
        ->name('superadmin')
        ->middleware(['superadmin', CheckIfLocked::class]);

    // Lock screen routes
    Route::get('/lock', [LockScreenController::class, 'show'])->name('lock');
    Route::post('/unlock', [LockScreenController::class, 'unlock'])->name('unlock');

    Route::get('/search', [App\Http\Controllers\UserController::class, 'search'])->name('search');
    Route::post('/book', [App\Http\Controllers\UserController::class, 'book'])->name('book');

    // Book and Serach functionality
    Route::post('/spaces', [SpaceController::class, 'store'])->name('spaces.store');
    Route::get('/search', [SearchController::class, 'search'])->name('search');
    Route::post('/book', [BookingController::class, 'book'])->name('book');
    Route::resource('spaces', SpaceController::class);
    Route::resource('spaces.bookings', BookingController::class);
    //Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');
    Route::resource('spaces', SpaceController::class)->except(['show']);
    Route::get('spaces/{space}/bookings', [BookingController::class, 'index'])->name('spaces.bookings');
    Route::get('spaces/{space}/bookings', [SpaceController::class, 'bookings'])->name('spaces.bookings');



    // Resources
    Route::resource('tasks', Controllers\TaskController::class)->middleware(CheckIfLocked::class);

    // Resourceful routes for users with additional routes for editing and deleting users
    Route::resource('users', UserController::class)
        ->middleware([CheckIfLocked::class, AuthGates::class]);

    // Custom routes for user edit and delete
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

    Route::get('/spaces/index', 'SpacesController@index')->name('spaces.index');
Route::get('/spaces/bookings/{space}', 'SpacesController@bookings')->name('spaces.bookings');
Route::get('/spaces/create', 'SpacesController@create')->name('spaces.create');
});
