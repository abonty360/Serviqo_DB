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
        $providers = Customer::all();
        return response()->json($providers);
    }
    public function all_bookings()
    {
        $bookings = [];
        return response()->json($bookings);
    }
}