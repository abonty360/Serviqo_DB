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
        $providers = collect([
            [
                'fname' => 'Add',
                'lname' => 'providers'
            ]
        ]);
        return response()->json($providers);
    }
    public function all_bookings()
    {
        $bookings = \App\Models\ServiceOrder::with(['customer', 'items.offering.subService'])->get();
        return response()->json($bookings);
    }
}