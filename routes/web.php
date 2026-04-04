<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

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

Route::get('/how-it-works', function () {
    return view('how-it-works');
})->name('how-it-works');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
});

Route::get('/admin/providers', function () {
    return view('admin.service_providers');
});

Route::get('/admin/all_bookings', function () {
    return view('admin.all_booking');
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:api');