<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

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

Route::get('/services', function () {
    return view('Service');
})->name('services');

Route::get('/book', function () {
    return view('booking');
})->name('book');
Route::post('/book', [BookingController::class, 'store'])->name('book.store');
Route::post('/book/{id}/complete', [BookingController::class, 'complete'])->name('book.complete');

Route::get('/how-it-works', function () {
    return view('how-it-works');
})->name('how-it-works');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:api');
