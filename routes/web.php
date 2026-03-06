<?php

use Illuminate\Support\Facades\Route;

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
    return view('login');
})->name('login');

Route::post('/login', function () {
    // In a real app, authentication logic would go here.
    return redirect('/');
});

Route::get('/signup', function () {
    return view('signup');
})->name('signup');

Route::post('/signup', function () {
    // In a real app, registration logic would go here.
    // Returning to login page with signup=success query parameter
    return redirect('/login?signup=success');
});
