<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\AuthController;

Route::get('/items', [UsersController::class, 'index']);
Route::get('/items/{id}', [UsersController::class, 'show']);
Route::post('/items', [UsersController::class, 'store']);
Route::put('/items/{id}', [UsersController::class, 'update']);
Route::patch('/items/{id}', [UsersController::class, 'patch']);
Route::delete('/items/{id}', [UsersController::class, 'destroy']);

Route::post('/register', [AuthController::class,'register']);
Route::post('/login', [AuthController::class,'login']);

Route::middleware(['auth:api','prevent-back-history'])->group(function () {

    Route::get('/profile', function () {
        return auth('api')->user();
    });

    Route::get('/me', function () {
        return response()->json(auth('api')->user());
    });

    Route::put('/profile', [AuthController::class, 'updateProfile']);

    Route::post('/logout', [AuthController::class,'logout']);

});