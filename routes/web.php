<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LockScreenController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\SpaceController;
use App\Http\Controllers\WarehouseController;
use App\Http\Controllers\AdminSpaceController;
use App\Http\Controllers\AdminBookingController;
use App\Http\Controllers\TaskController;
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
    })->name('dashboard')->middleware(['client', CheckIfLocked::class]);

    Route::get('/admin', function () {
        return view('admin');
    })->name('admin')->middleware(['admin', CheckIfLocked::class]);

    Route::get('/hostmanager', function () {
        return view('hostmanager');
    })->name('hostmanager')->middleware(['hostmanager', CheckIfLocked::class]);

    // Super Admin routes
    Route::get('/superadmin', [SuperAdminController::class, 'index'])
        ->name('superadmin')
        ->middleware(['superadmin', CheckIfLocked::class]);

    // Lock screen routes
    Route::get('/lock', [LockScreenController::class, 'show'])->name('lock');
    Route::post('/unlock', [LockScreenController::class, 'unlock'])->name('unlock');

    // User routes
    Route::resource('users', UserController::class)->middleware([CheckIfLocked::class, AuthGates::class]);
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

    // Admin routes
    Route::middleware(['auth', 'admin'])->group(function () {
        Route::get('/admin/bookings', [AdminBookingController::class, 'index'])->name('admin.bookings.list');
        Route::get('/admin/spaces/create', [AdminSpaceController::class, 'create'])->name('admin.spaces.create');
        Route::get('/admin/spaces', [AdminSpaceController::class, 'index'])->name('admin.spaces.index');
        Route::get('/admin/spaces/edit/{id}', [AdminSpaceController::class, 'edit'])->name('admin.spaces.edit');
        Route::post('/admin/spaces/store', [AdminSpaceController::class, 'store'])->name('admin.spaces.store');
        Route::put('/admin/spaces/{id}', [AdminSpaceController::class, 'update'])->name('admin.spaces.update');
        Route::delete('/admin/spaces/{id}', [AdminSpaceController::class, 'destroy'])->name('admin.spaces.destroy');
        Route::post('/admin/bookings/update-status/{booking}', [AdminBookingController::class, 'updateStatus'])->name('admin.bookings.updateStatus');
        Route::get('/admin/bookings/{id}/edit', [AdminBookingController::class, 'edit'])->name('admin.bookings.edit');
        Route::put('/admin/bookings/{id}', [AdminBookingController::class, 'update'])->name('admin.bookings.update');
    });

    // Booking routes
    Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');
    Route::get('/bookings/{space_id}/form', [BookingController::class, 'showBookingForm'])->name('booking.form');
    Route::post('/bookings/{space_id}/submit', [BookingController::class, 'submitBookingForm'])->name('booking.submit');
    Route::post('/book', [BookingController::class, 'book'])->name('book');

    // Space routes
    Route::resource('spaces', SpaceController::class)->except(['show']);
    Route::get('spaces/{space}/bookings', [BookingController::class, 'index'])->name('spaces.bookings');
    Route::get('/spaces/search', [SpaceController::class, 'search'])->name('spaces.search');
    Route::get('/spaces/{space}/book', [SpaceController::class, 'showBookingForm'])->name('spaces.book');
    Route::post('/spaces/{space}/book', [SpaceController::class, 'book'])->name('spaces.book.submit');
    Route::get('/spaces/booking-form', [SpaceController::class, 'showBookingForm'])->name('spaces.book');
    Route::get('/spaces/book', [SpaceController::class, 'book'])->name('spaces.book');

    // Warehouse routes
    Route::get('/warehouses', [WarehouseController::class, 'index'])->name('warehouses.index');

    // Task routes
    Route::resource('tasks', TaskController::class)->middleware(CheckIfLocked::class);

    // Search routes
    Route::get('/search', [SearchController::class, 'search'])->name('search');
});

?>
