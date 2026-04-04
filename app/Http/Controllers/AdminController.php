<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
class AdminController extends Controller
{
    public function dashboard()
    {
        // Example stats (optional)
        $totalUsers = Customer::where('role', 'user')->count();
        $totalAdmins = Customer::where('role', 'admin')->count();

        return view('admin.dashboard', compact('totalUsers', 'totalAdmins'));
    }

    /**
     * Service Providers Page
     */
    public function providers()
    {
        // Example: assuming providers are stored in customers table
        $providers = Customer::where('role', 'provider')->get();

        return view('admin.service_providers', compact('providers'));
    }

    /**
     * Bookings Page
     */
    public function all_bookings()
    {
        // Replace with your actual Booking model if exists
        // Example:
        // $bookings = Booking::with('customer')->latest()->get();

        $bookings = []; // placeholder

        return view('admin.all_bookings', compact('bookings'));
    }
}