<?php

use Automobile\Http\Controllers\ManufacturerController;
use Automobile\Http\Controllers\ModelController;
use Automobile\Http\Controllers\PartController;
use Automobile\Http\Controllers\VariantController;
use Automobile\Http\Controllers\VehicleController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Automobile package routes
|--------------------------------------------------------------------------
|
| Loaded by Automobile\AutomobileServiceProvider when config
| "automobile.routes.enabled" is true. The prefix and middleware stack are
| applied by the service provider from config("automobile.routes").
|
*/

Route::apiResource('manufacturers', ManufacturerController::class);
Route::apiResource('models', ModelController::class);
Route::apiResource('variants', VariantController::class);
Route::apiResource('vehicles', VehicleController::class);
Route::apiResource('parts', PartController::class);
