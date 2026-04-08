<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $user = auth('api')->user();
        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $notifications = Notification::with(['serviceOrder.items.offering.subService'])
            ->where('customer_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($notifications);
    }

    public function markAsRead($id)
    {
        $user = auth('api')->user();
        $notification = Notification::where('id', $id)
            ->where('customer_id', $user->id)
            ->first();

        if (!$notification) {
            return response()->json(['message' => 'Notification not found'], 404);
        }

        $notification->is_read = 1;
        $notification->save();

        return response()->json(['success' => true]);
    }

    public function markAllAsRead()
    {
        $user = auth('api')->user();
        Notification::where('customer_id', $user->id)
            ->where('is_read', 0)
            ->update(['is_read' => 1]);

        return response()->json(['success' => true]);
    }
}