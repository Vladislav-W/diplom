<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\OrganizationController;
use App\Http\Controllers\Api\CityController;
use App\Http\Controllers\Api\DriverController;
use App\Http\Controllers\Api\AutoParkController;
use App\Http\Controllers\Api\ResponsiblePersonController;
use App\Http\Controllers\Api\CargoController;
use App\Http\Controllers\Api\RequestController;
use App\Http\Controllers\Api\RequestCargoController;
use App\Http\Controllers\Api\FileController;

Route::get('/test', function() {
    return response()->json(['message' => 'API работает']);
});

Route::prefix('v1')->group(function () {
    Route::apiResource('organizations', OrganizationController::class);
    Route::apiResource('cities', CityController::class);
    Route::apiResource('drivers', DriverController::class);
    Route::apiResource('auto-park', AutoParkController::class);
    Route::apiResource('responsible-people', ResponsiblePersonController::class);
    Route::apiResource('cargo', CargoController::class);
    Route::apiResource('requests', RequestController::class);
    Route::apiResource('request-cargo', RequestCargoController::class);
    Route::apiResource('files', FileController::class);
    
    // Маршруты для файлов заявки
    Route::post('/requests/{request}/files', [FileController::class, 'store']);
    Route::get('/requests/{request}/files', [FileController::class, 'index']);
    Route::get('/files/{file}/download', [FileController::class, 'download']);
});