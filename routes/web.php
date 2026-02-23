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

// Authentication Routes for separate pages
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', function () {
    // Handle login logic here
    // For now, just redirect to home page after "successful" login with a 'logged_in' flash message
    return redirect('/')->with('logged_in', true);
});

Route::get('/signup', function () {
    return view('auth.signup');
})->name('signup');

Route::post('/signup', function () {
    // Handle registration logic here
    // Redirect to login with success message after successful signup
    return redirect()->route('login', ['signup' => 'success']);
});
