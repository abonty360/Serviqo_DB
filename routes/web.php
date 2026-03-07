<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('home');
});

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', [AuthController::class, 'login'])->name('customer.login');

Route::get('/signup', function () {
    return view('auth.signup');
})->name('signup');
Route::post('/signup', [AuthController::class, 'register'])->name('customer.register');

Route::get('/guest', function () {
    session(['is_guest' => true]);
    return redirect('/');
});
Route::get('/profile', function () {
    return view('profile');
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:api');