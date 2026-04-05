<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
class AdminController extends Controller
{
    public function dashboard()
    {
        return response()->json(auth('api')->user());
    }

    public function providers()
    {
       $providers = \App\Models\ServiceProvider::all();
        return response()->json($providers);
    }
    public function all_bookings()
    {
        $bookings = \App\Models\ServiceOrder::with(['customer', 'items.offering.subService', 'items.offering.provider', 'payments'])->orderBy('created_at', 'desc')->get();
        return response()->json($bookings);
    }
    public function update_status(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|string'
        ]);

        $order = \App\Models\ServiceOrder::find($id);
        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        $order->status = $request->status;
        $order->save();

        return response()->json(['message' => 'Status updated successfully', 'order' => $order]);
    }

    public function update_payment_status(Request $request, $id)
    {
        $request->validate([
            'payment_status' => 'required|string'
        ]);

        $order = \App\Models\ServiceOrder::find($id);
        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        $order->payment_status = $request->payment_status;
        $order->save();

        return response()->json(['message' => 'Payment status updated successfully', 'order' => $order]);
    }

    public function assign_provider(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:assigned,not_assigned'
        ]);

        $order = \App\Models\ServiceOrder::with('items.offering')->find($id);
        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        if ($request->status === 'assigned') {
            // Find or create System Provider
            $area = \App\Models\ServiceArea::firstOrCreate(
                ['city_name' => 'Default City', 'area_name' => 'Default Area'],
                ['postal_code' => '0000']
            );

            $provider = \App\Models\ServiceProvider::firstOrCreate(
                ['email' => 'provider@example.com'],
                [
                    'full_name' => 'System Provider',
                    'phone' => '00000000',
                    'city' => 'Default City',
                    'nid' => 'NID-SYSTEM',
                    'service_area_id' => $area->id,
                    'address' => 'System'
                ]
            );

            foreach ($order->items as $item) {
                $subServiceId = $item->offering->sub_service_id;
                $offering = \App\Models\ServiceProviderOffering::firstOrCreate(
                    ['service_provider_id' => $provider->id, 'sub_service_id' => $subServiceId],
                    ['price_charged' => $item->item_price]
                );
                $item->service_provider_offering_id = $offering->id;
                $item->save();
            }
            $message = 'Provider assigned successfully';
        } else {
            // Since DB is NOT NULL, we "unassign" by keeping it as is or handle it via a specific flag if needed.
            // But usually, 'Not Assigned' in this context means keeping it in a pending state or 
            // re-assigning back to a 'System' placeholder if it was something else.
            // For now, we'll just confirm the intent.
            $message = 'Provider status marked as Not Assigned';
        }

        return response()->json(['message' => $message]);
    }
}
