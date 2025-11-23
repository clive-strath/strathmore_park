<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SecurityController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;

// Welcome page (landing page)
Route::get('/', function () {
    return view('welcome');
});

// Auth routes (Breeze/Jetstream automatically registers these, but you can ensure)
Auth::routes();

// Explicit logout route
Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout')->middleware('auth');

// Dashboard route (only accessible after authentication)
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->name('dashboard')
    ->middleware('auth');

// Security routes
Route::middleware(['auth', 'security'])->prefix('security')->group(function () {
    Route::post('/parking-lot/{parkingLot}/add-vehicle', [SecurityController::class, 'addVehicle'])
        ->name('security.add-vehicle');
    Route::post('/parking-lot/{parkingLot}/remove-vehicle', [SecurityController::class, 'removeVehicle'])
        ->name('security.remove-vehicle');
});

// Admin routes
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::put('/parking-lot/{parkingLot}', [AdminController::class, 'updateLot'])
        ->name('admin.update-lot');
    Route::post('/parking-lot/{parkingLot}/toggle', [AdminController::class, 'toggleLot'])
        ->name('admin.toggle-lot');
    Route::put('/users/{user}', [AdminController::class, 'updateUser'])
        ->name('admin.update-user');
    Route::delete('/users/{user}', [AdminController::class, 'deleteUser'])
        ->name('admin.delete-user');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
