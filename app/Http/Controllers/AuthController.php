<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        
    }
    public function register(Request $request)
    {
        try {
            $request->validate([
                'fname' => 'required|string|max:255',
                'lname' => 'required|string|max:255',
                'dob' => 'required|date',
                'email' => [
                    'required',
                    'email',
                    'unique:customers,email',
                    'regex:/^[^@]+@[^@]+\.(com|org|net|edu|co|io|gov)$/i'
                ],
                'phone' => 'nullable|string',
                'password' => 'bail|required|min:6|confirmed',
                'address' => 'nullable|string',
                'city' => 'required|in:Dhaka,Chittagong,Sylhet,Barisal,Rangpur,Rajshahi,Khulna',
                'region' => 'required|string'
            ], [
                'email.regex' => 'Email must end with a valid domain'
            ]);

            Customer::create([
                'fname' => $request->fname,
                'lname' => $request->lname,
                'dob' => $request->dob,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => Hash::make($request->password),
                'address' => $request->address,
                'city' => $request->city,
                'region' => $request->region,
                'preferred_payment_method' => null
            ]);

            return redirect()->route('login', ['signup' => 'success']);
        } catch (ValidationException $e) {

            return back()->withErrors($e->validator)->withInput();

        } catch (\Exception $e) {

            return back()->with('error', 'Registration failed. Please try again.');
        }
    }

}