<?php

use App\Http\Controllers\Api\AuthController;
use Automobile\Http\Controllers\ManufacturerController;
use Automobile\Http\Controllers\ModelController;
use Automobile\Http\Controllers\PartController;
use Automobile\Http\Controllers\VariantController;
use Automobile\Http\Controllers\VehicleController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);

    Route::middleware('auth.static')->group(function () {
        Route::get('user', [AuthController::class, 'user']);
        Route::post('logout', [AuthController::class, 'logout']);

        Route::apiResource('manufacturers', ManufacturerController::class);
        Route::apiResource('models', ModelController::class);
        Route::apiResource('variants', VariantController::class);
        Route::apiResource('vehicles', VehicleController::class);
        Route::apiResource('parts', PartController::class);
    });
});
