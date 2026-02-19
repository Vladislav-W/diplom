<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\OrganizationController;
use App\Http\Controllers\Api\CityController;
use App\Http\Controllers\Api\DriverController;
use App\Http\Controllers\Api\AutoParkController;
use App\Http\Controllers\Api\ResponsiblePersonController;
use App\Http\Controllers\Api\CargoController;
use App\Http\Controllers\Api\RequestController;

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
});

Route::options('/{any}', function () {
    return response('', 200)
        ->header('Access-Control-Allow-Origin', 'http://localhost:8080')
        ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
        ->header('Access-Control-Allow-Headers', 'Content-Type, Authorization, X-Requested-With');
})->where('any', '.*');