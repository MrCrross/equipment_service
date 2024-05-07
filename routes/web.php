<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\RolesController;
use Illuminate\Support\Facades\Route;

Route::post('/language', [AuthenticatedSessionController::class, 'setLanguage'])->name('language');

Route::middleware('locale')->group(function () {
    Route::get('/', function () {
        return view('welcome');
    });

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware(['auth', 'verified'])->name('dashboard');

    Route::middleware('auth')->group(function () {
        Route::resource('roles', RolesController::class);
    });

    require __DIR__ . '/auth.php';
    require __DIR__ . '/users.php';
    require __DIR__ . '/equipment.php';
    require __DIR__ . '/orders.php';
});
