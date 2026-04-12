<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\RatingsController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware(['auth:api', 'prevent-back-history'])->group(function () {

    Route::get('/profile', function () {
        return auth('api')->user();
    });

    Route::get('/me', function () {
        $user = auth('api')->user();
        if ($user) {
            $user->load(['serviceOrders.items.offering.subService', 'reviews']);
        }
        return response()->json($user);
    });
    Route::post('/book', [BookingController::class, 'store']);
    Route::post('/book/{id}/complete', [BookingController::class, 'complete']);
    Route::put('/profile', [AuthController::class, 'updateProfile']);
    Route::post('/change-password', [AuthController::class, 'changePassword']);
    Route::post('/logout', [AuthController::class, 'logout']);

     Route::post('/ratings', [RatingsController::class, 'store']);
    Route::get('/ratings/customer', [RatingsController::class, 'getCustomerReviews']);
    Route::get('/ratings/provider/{providerId}', [RatingsController::class, 'getProviderRatings']);

    // Notifications
    Route::get('/notifications', [\App\Http\Controllers\NotificationController::class, 'index']);
    Route::post('/notifications/{id}/read', [\App\Http\Controllers\NotificationController::class, 'markAsRead']);
    Route::post('/notifications/read-all', [\App\Http\Controllers\NotificationController::class, 'markAllAsRead']);

});

Route::middleware(['auth:api'])->prefix('admin')->group(function () {

    Route::get('/dashboard', [AdminController::class, 'dashboard']);
    Route::get('/providers', [AdminController::class, 'providers']);
    Route::post('/providers', [AdminController::class, 'store_provider']);
    Route::get('/service-areas', [AdminController::class, 'service_areas']);
    Route::get('/sub-services', [AdminController::class, 'sub_services']);
    Route::get('/all_bookings', [AdminController::class, 'all_bookings']);
    Route::patch('/bookings/{id}/status', [AdminController::class, 'update_status']);
    Route::patch('/bookings/{id}/payment-status', [AdminController::class, 'update_payment_status']);
    Route::patch('/bookings/{id}/assign', [AdminController::class, 'assign_provider']);

});
