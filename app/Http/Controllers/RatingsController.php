<?php

namespace App\Http\Controllers;

use App\Models\RatingsReview;
use App\Models\ServiceOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RatingsController extends Controller
{
    /**
     * Store a new rating and review
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        
        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $validated = $request->validate([
            'service_provider_id' => 'required|integer|exists:service_providers,id',
            'service_order_id' => 'required|integer|exists:service_orders,id',
            'rating' => 'required|integer|min:1|max:5',
            'review_notes' => 'nullable|string|max:1000'
        ]);

        // Verify the order belongs to this customer
        $order = ServiceOrder::find($validated['service_order_id']);
        
        \Log::info('Rating submission attempt:', [
            'authenticated_user_id' => $user->id,
            'user_type' => get_class($user),
            'requested_order_id' => $validated['service_order_id'],
            'order_exists' => $order ? true : false,
            'order_data' => $order ? [
                'id' => $order->id,
                'customer_id' => $order->customer_id,
                'status' => $order->status
            ] : null,
        ]);

        if (!$order) {
            return response()->json(['message' => 'Order not found', 'debug_info' => 'Order ID: ' . $validated['service_order_id']], 404);
        }

        if ($order->customer_id != $user->id) {  // Use loose comparison == instead of strict ===
            return response()->json([
                'message' => 'This order does not belong to you',
                'debug_info' => 'Order customer_id: ' . $order->customer_id . ' (type: ' . gettype($order->customer_id) . '), Your user_id: ' . $user->id . ' (type: ' . gettype($user->id) . ')'
            ], 403);
        }

        // Check if already rated
        $existingRating = RatingsReview::where('customer_id', $user->id)
            ->where('service_order_id', $validated['service_order_id'])
            ->first();

        if ($existingRating) {
            return response()->json(['message' => 'You have already rated this order'], 422);
        }

        try {
            $rating = RatingsReview::create([
                'customer_id' => $user->id,
                'service_provider_id' => $validated['service_provider_id'],
                'service_order_id' => $validated['service_order_id'],
                'rating' => $validated['rating'],
                'review_notes' => $validated['review_notes'] ?? null,
                'review_date' => now()->toDateString()
            ]);

            // Update Provider's average rating
            $provider = \App\Models\ServiceProvider::find($validated['service_provider_id']);
            if ($provider) {
                $avgRating = RatingsReview::where('service_provider_id', $provider->id)->avg('rating');
                $provider->rating = number_format($avgRating, 1);
                $provider->save();
            }

            return response()->json([
                'message' => 'Rating submitted successfully',
                'data' => $rating
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to submit rating: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get ratings for a specific service provider
     */
    public function getProviderRatings($providerId)
    {
        $ratings = RatingsReview::where('service_provider_id', $providerId)
            ->with(['customer' => function ($query) {
                $query->select('id', 'fname', 'lname');
            }])
            ->orderBy('review_date', 'desc')
            ->get();

        return response()->json([
            'data' => $ratings,
            'average_rating' => $ratings->avg('rating') ?? 0,
            'total_reviews' => $ratings->count()
        ]);
    }

    /**
     * Get customer's reviews
     */
    public function getCustomerReviews()
    {
        $user = Auth::user();
        
        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $reviews = RatingsReview::where('customer_id', $user->id)
            ->with(['serviceProvider' => function ($query) {
                $query->select('id', 'fname', 'lname', 'phone');
            }])
            ->orderBy('review_date', 'desc')
            ->get();

        return response()->json(['data' => $reviews]);
    }
}