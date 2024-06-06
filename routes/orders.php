<?php

use App\Http\Controllers\Equipment\EquipmentBrandsController;
use App\Http\Controllers\Equipment\EquipmentController;
use App\Http\Controllers\Equipment\EquipmentFieldsController;
use App\Http\Controllers\Equipment\EquipmentModelsController;
use App\Http\Controllers\Equipment\EquipmentTypesController;
use App\Http\Controllers\OrdersController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::resource('orders', OrdersController::class)->names('orders');
    Route::patch('orders/{id}/recovery', [OrdersController::class, 'recovery'])->whereNumber('id')->name('orders.recovery');
});

Route::get('/orders/{id}/status/{status_code}', [OrdersController::class, 'changeStatus'])->whereNumber('id')->name('orders.status');
