<?php

namespace App\Http\Controllers;

use App\Models\ServiceOrder;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\OrderConfirmation;
use App\Models\SubService;
use App\Models\ServiceProviderOffering;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function store(Request $request)
    {
        try {
            $request->validate([
                'service' => 'required|string',
                'date' => 'required|date|after_or_equal:today',
                'time' => 'required',
                'address' => 'required|string',
                'phone' => ['required', 'string', 'regex:/^(?:\+?88|88)?01[3-9]\d{8}$/'],
                'payment_method' => 'required|string'
            ], [
                'date.after_or_equal' => 'Past dates are invalid. Order will not be confirmed.',
                'phone.regex' => 'Please provide a valid Bangladesh phone number.'
            ]);

            $user = auth('api')->user() ?? auth()->user();
            $customerId = $user ? $user->id : 1; 

            $realCustomer = \App\Models\Customer::find($customerId);
            if (!$realCustomer) {
                $firstCustomer = \App\Models\Customer::first();
                if ($firstCustomer) {
                    $customerId = $firstCustomer->id;
                } else {
                    $customer = \App\Models\Customer::create([
                        'fname' => 'Guest',
                        'lname' => 'User',
                        'email' => 'guest_' . time() . '@example.com',
                        'password' => bcrypt('password'),
                        'city' => 'Unknown',
                        'phone' => $request->phone
                    ]);
                    $customerId = $customer->id;
                }
            }

            $scheduledDatetime = date('Y-m-d H:i:s', strtotime("$request->date $request->time"));

            $order = new ServiceOrder();
            $order->customer_id = $customerId;
            $order->status = 'Pending';
            $order->payment_status = 'unpaid';
            $order->scheduled_datetime = $scheduledDatetime;
            $order->save();

            $subService = SubService::where('service_name', 'like', "%{$request->service}%")->first();
            $offeringId = null; 
            $itemPrice = $request->amount ?? 0.00;

            if ($subService) {
                $offering = ServiceProviderOffering::where('sub_service_id', $subService->id)->first();
                if ($offering) {
                    $offeringId = $offering->id;
                    // Use database price if frontend didn't send one, otherwise trust frontend for now
                    if (!$itemPrice) {
                        $itemPrice = $offering->price_charged;
                    }
                }
            }
            
           
            if (!$offeringId) {
                $cat = \App\Models\Category::firstOrCreate(['name' => 'General Services'], ['description' => 'System Auto Category']);
                
                $sub = SubService::firstOrCreate(
                    ['category_id' => $cat->id, 'service_name' => strtolower($request->service)],
                    ['description' => 'Auto generated service']
                );
                
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
                        'nid' => 'NID-' . time(),
                        'service_area_id' => $area->id,
                        'address' => 'N/A'
                    ]
                );
                
                $offering = ServiceProviderOffering::firstOrCreate([
                    'service_provider_id' => $provider->id,
                    'sub_service_id' => $sub->id,
                ], [
                    'price_charged' => $itemPrice > 0 ? $itemPrice : 500.00
                ]);
                
                $offeringId = $offering->id;
                $itemPrice = $offering->price_charged;
            }

            $order->total_amount = $itemPrice;
            $order->save();

            $orderItem = new OrderItem();
            $orderItem->service_order_id = $order->id;
            $orderItem->service_provider_offering_id = $offeringId;
            $orderItem->quantity = 1;
            $orderItem->item_price = $itemPrice;
            $orderItem->item_status = 'pending';
            $orderItem->save();

            if ($request->payment_method) {
                $payment = new Payment();
                $payment->service_order_id = $order->id;
                $payment->payment_method = $request->payment_method;
                $payment->payable_amount = $itemPrice;
                $payment->save();
            }

            
            $confirmation = new OrderConfirmation();
            $confirmation->service_order_id = $order->id;
            $confirmation->confirmation_status = 'confirmed';
            $confirmation->final_amount = $itemPrice;
            $confirmation->confirmed_at = now();
            $confirmation->save();

            return response()->json([
                'success' => true,
                'message' => 'Order saved successfully',
                'booking_id' => $order->id,
                'amount' => $order->total_amount
            ]);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            $firstError = collect($e->errors())->flatten()->first();
            return response()->json([
                'success' => false,
                'message' => $firstError
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => substr($e->getMessage(), 0, 150)
            ], 200); 
        }
    }

    public function complete($id)
    {
        $order = ServiceOrder::find($id);
        
        if ($order) {
            $order->status = 'completed';
            $order->save();

            $confirmation = new OrderConfirmation();
            $confirmation->service_order_id = $order->id;
            $confirmation->confirmation_status = 'confirmed';
            $confirmation->final_amount = $order->total_amount;
            $confirmation->confirmed_at = now();
            $confirmation->save();

            return response()->json(['success' => true, 'message' => 'Order marked as completed']);
        }

        return response()->json(['success' => false, 'message' => 'Not a valid order'], 400);
    }
}
