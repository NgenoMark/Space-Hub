<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LockScreenController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AuthGates;
use App\Http\Middleware\CheckIfLocked;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\SpaceController;
use App\Http\Controllers\WarehouseController;
use App\Http\Controllers\AdminSpaceController;
use App\Http\Controllers\AdminBookingController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\SpaceOwnerController;

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
    Route::resource('users', UserController::class)
        ->middleware([CheckIfLocked::class, AuthGates::class]);
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
        Route::get('/space-owner/chart-data', [SpaceOwnerController::class, 'getChartData'])->name('spaceowner.chartdata');
        Route::delete('/spaces/{space}', 'SpaceController@destroy')->name('spaces.destroy');
        //Route::get('/admin/spaces', [SpaceController::class, 'index'])->name('admin.spaces.index');


        Route::get('/admin/spaces/my-spaces', [SpaceController::class, 'mySpaces'])->name('admin.spaces.my-spaces');
        //Route::get('/admin/spaces/edit/{space_id}', [SpaceController::class, 'edit'])->name('admin.spaces.edit');



    });

    // Space routes
    Route::resource('spaces', SpaceController::class)->except(['show']);
    Route::get('spaces/{space}/bookings', [BookingController::class, 'index'])->name('spaces.bookings');
    Route::get('/spaces/search', [SpaceController::class, 'search'])->name('spaces.search');
    Route::get('/spaces/{space}/book', [SpaceController::class, 'showBookingForm'])->name('spaces.book');
    Route::post('/spaces/{space}/book', [SpaceController::class, 'book'])->name('spaces.book.submit');
    Route::get('/spaces/book', [SpaceController::class, 'mybooking'])->name('spaces.book');

    // Warehouse routes
    Route::get('/warehouses', [WarehouseController::class, 'index'])->name('warehouses.index');

    // Booking routes
    Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');
    Route::post('/book', [BookingController::class, 'book'])->name('book');
    Route::resource('spaces.bookings', BookingController::class);
    //Route::get('/bookings', [BookingController::class, 'uindex'])->name('bookings.uindex');


    // Task routes
    Route::resource('tasks', TaskController::class)->middleware(CheckIfLocked::class);

    Route::middleware(['auth'])->group(function () {
        Route::get('/admin/bookings', [BookingController::class, 'list'])->name('admin.bookings.list');
        Route::post('/admin/bookings/{id}/update-status', [BookingController::class, 'updateStatus'])->name('admin.bookings.updateStatus');

    });

    // Search routes
    Route::get('/search', [SearchController::class, 'search'])->name('search');

    // routes/web.php

Route::get('/search', [SpaceController::class, 'search'])->name('search');


Route::post('/book', [BookingController::class, 'store'])->name('book');
Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');

});

?>
