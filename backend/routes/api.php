<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


// server health check
Route::get('/', function () {
    return response()->json([
        'message' => 'Welcome to the API'
    ]);
});

//send otp
Route::post('/login', [\App\Http\Controllers\LoginController::class, 'submit']);
//verify otp
Route::post('/login/verify', [\App\Http\Controllers\LoginController::class, 'verify']);


Route::group(['middleware' => ['auth:sanctum']], function () {

    Route::get('/driver', [\App\Http\Controllers\DriverController::class, 'index']);
    Route::post('/driver', [\App\Http\Controllers\DriverController::class, 'store']);

    Route::post('/trip', [\App\Http\Controllers\TripController::class, 'store']);
    Route::get('trip/{trip}', [\App\Http\Controllers\TripController::class, 'show']);
    Route::post('/trip/{trip}/accept', [\App\Http\Controllers\TripController::class, 'accept']);
    Route::post('/trip/{trip}/start', [\App\Http\Controllers\TripController::class, 'start']);
    Route::post('/trip/{trip}/end', [\App\Http\Controllers\TripController::class, 'end']);
    Route::post('/trip/{trip}/location', [\App\Http\Controllers\TripController::class, 'location']);
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});
