<?php

use App\Http\Controllers\Equipment\EquipmentBrandsController;
use App\Http\Controllers\Equipment\EquipmentController;
use App\Http\Controllers\Equipment\EquipmentFieldsController;
use App\Http\Controllers\Equipment\EquipmentModelsController;
use App\Http\Controllers\Equipment\EquipmentTypesController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::resource('equipment', EquipmentController::class)->whereNumber('equipment')->names('equipment.main');
    Route::prefix('/equipment')->group(function () {
        Route::resource('fields', EquipmentFieldsController::class)->whereNumber('field')->names('equipment.fields');
        Route::resource('models', EquipmentModelsController::class)->whereNumber('model')->names('equipment.models');
        Route::resource('brands', EquipmentBrandsController::class)->whereNumber('brand')->names('equipment.brands');
        Route::resource('types', EquipmentTypesController::class)->whereNumber('type')->names('equipment.types');
        Route::patch('/{id}/recovery', [EquipmentController::class, 'recovery'])->whereNumber('id')->name('equipment.main.recovery');
        Route::patch('/models/{id}/recovery', [EquipmentModelsController::class, 'recovery'])->whereNumber('id')->name('equipment.models.recovery');
        Route::patch('/brands/{id}/recovery', [EquipmentBrandsController::class, 'recovery'])->whereNumber('id')->name('equipment.brands.recovery');
        Route::patch('/types/{id}/recovery', [EquipmentTypesController::class, 'recovery'])->whereNumber('id')->name('equipment.types.recovery');
        Route::patch('/fields/{id}/recovery', [EquipmentFieldsController::class, 'recovery'])->whereNumber('id')->name('equipment.fields.recovery');
    });

});
