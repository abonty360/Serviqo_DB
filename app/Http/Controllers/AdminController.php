<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\ServiceProvider;
use App\Models\Category;
use App\Models\SubService;
use App\Models\ServiceProviderOffering;
use App\Models\ServiceArea;
use App\Models\ServiceOrder;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function dashboard()
    {
        return response()->json(auth('api')->user());
    }

    public function providers()
    {
        $providers = ServiceProvider::with(['serviceArea', 'offerings'])
            ->where('full_name', '!=', 'System Provider')
            ->get();
        return response()->json($providers);
    }

    public function service_areas()
    {
        $areas = ServiceArea::all();
        return response()->json($areas);
    }

    public function sub_services()
    {
        $services = SubService::with('category')->get();
        return response()->json($services);
    }

    public function store_provider(Request $request)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|unique:service_providers,email',
            'phone' => 'required|string|max:20',
            'address' => 'nullable|string|max:255',
            'city' => 'required|string|max:100',
            'nid' => 'required|string|unique:service_providers,nid',
            'service_area_id' => 'required|exists:service_areas,id',
            'rating' => 'nullable|numeric|min:0|max:5',
            'offerings' => 'nullable|array',
            'offerings.*.service_name' => 'required|string',
            'offerings.*.category_name' => 'required|string'
        ]);

        DB::beginTransaction();
        try {
            $providerData = collect($validated)->except('offerings')->toArray();
            
            $providerData['rating'] = $providerData['rating'] ?? 0.0;
            $providerData['address'] = $providerData['address'] ?? '';

            $provider = ServiceProvider::create($providerData);

            if (!empty($validated['offerings'])) {
                foreach ($validated['offerings'] as $offering) {
                    $category = Category::firstOrCreate(
                        ['name' => $offering['category_name']],
                        ['description' => '']
                    );
                    $subService = SubService::firstOrCreate(
                        [
                            'service_name' => strtolower($offering['service_name'])
                        ],
                        [
                            'category_id' => $category->id,
                            'description' => ''
                        ]
                    );

                    ServiceProviderOffering::create([
                        'service_provider_id' => $provider->id,
                        'sub_service_id' => $subService->id,
                        'price_charged' => 0.00,
                        'rating' => 0
                    ]);
                }
            }

            DB::commit();

            return response()->json([
                'message' => 'Service provider and offerings created successfully',
                'provider' => $provider->load('serviceArea')
            ], 201);
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Failed to create provider',
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ], 500);
        }
    }

    public function all_bookings()
    {
        $bookings = ServiceOrder::with(['customer', 'items.offering.subService', 'items.offering.provider', 'payments'])->orderBy('created_at', 'desc')->get();

        return response()->json($bookings);
    }

    public function update_status(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|string'
        ]);

        \Illuminate\Support\Facades\Log::info('Updating status for order ' . $id . '. New status: ' . $request->status);

        $order = ServiceOrder::with('customer', 'items.offering.subService')->find($id);
        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        // Calculate total_amount if not set
        if (!$order->total_amount || $order->total_amount == 0) {
            $total = 0;
            if ($order->items) {
                foreach ($order->items as $item) {
                    $total += $item->item_price;
                }
            }
            $order->total_amount = $total;
            $order->save();
        }

        $oldStatus = trim(strtolower($order->status));
        $newStatus = trim(strtolower($request->status));
        
        $order->status = $request->status;
        $order->save();

        \Illuminate\Support\Facades\Log::info("Status Change Check: Old=[$oldStatus], New=[$newStatus]");

        if (($newStatus === 'confirmed' || $newStatus === 'approved' || $newStatus === 'order confirmed') && $oldStatus !== $newStatus) {
            // Create order confirmation
            $confirmation = new \App\Models\OrderConfirmation();
            $confirmation->service_order_id = $order->id;
            $confirmation->confirmation_status = 'confirmed';
            $confirmation->final_amount = $order->total_amount;
            $confirmation->confirmed_at = now();
            $confirmation->save();

            // Get service name from order items
            $serviceName = 'Order';
            if ($order->items && $order->items->count() > 0) {
                $firstItem = $order->items->first();
                if ($firstItem->offering && $firstItem->offering->subService) {
                    $serviceName = $firstItem->offering->subService->service_name;
                }
            }

            \Illuminate\Support\Facades\Log::info('Creating notification for customer ' . $order->customer_id . ' for order ' . $order->id);
            \App\Models\Notification::create([
                'customer_id' => $order->customer_id,
                'service_order_id' => $order->id,
                'title' => 'Your Order is Confirmed!',
                'message' => 'Your ' . $serviceName . ' order has been approved. Order ID: #' . str_pad($order->id, 5, '0', STR_PAD_LEFT),
                'is_read' => 0
            ]);
        }

        return response()->json(['message' => 'Status updated successfully', 'order' => $order]);
    }

    public function update_payment_status(Request $request, $id)
    {
        $request->validate([
            'payment_status' => 'required|string'
        ]);

        $order = ServiceOrder::find($id);
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
            'status' => 'nullable|in:assigned,not_assigned',
            'provider_id' => 'required_if:status,assigned|exists:service_providers,id'
        ]);

        $order = ServiceOrder::with('items.offering')->find($id);
        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        if ($request->provider_id) {
            $provider = ServiceProvider::find($request->provider_id);
            
            foreach ($order->items as $item) {
                if ($item->offering) {
                    $subServiceId = $item->offering->sub_service_id;
                    $offering = ServiceProviderOffering::firstOrCreate(
                        ['service_provider_id' => $provider->id, 'sub_service_id' => $subServiceId],
                        ['price_charged' => $item->item_price ?? 0.00, 'rating' => 0]
                    );
                    $item->service_provider_offering_id = $offering->id;
                    $item->save();
                }
            }
            $message = 'Provider assigned successfully';
        } else {
            // Unassign logic if needed, currently just marks status
            $message = 'Provider status marked as Not Assigned';
        }

        return response()->json(['message' => $message]);
    }
}