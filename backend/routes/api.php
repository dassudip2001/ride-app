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
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});
