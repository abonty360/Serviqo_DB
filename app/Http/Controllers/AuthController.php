<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use Carbon\Carbon;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (!$token = auth('api')->attempt($credentials)) {
            return response()->json([
                "error" => true,
                "message" => "Invalid email or password"
            ], 401);
        }
        session(['jwt_token' => $token]);

        return response()->json([
            "error" => false,
            "message" => "Login successful",
            "token" => $token,
            "customer" => auth('api')->user()
        ]);
    }
    public function register(Request $request)
    {
        try {
            $request->validate([
                'fname' => 'required|string|max:255',
                'lname' => 'required|string|max:255',
                'dob' => [
                    'required',
                    'date',
                    'before_or_equal:' . Carbon::now()->subYears(18)->toDateString()
                ],
                'email' => [
                    'required',
                    'email',
                    'unique:customers,email',
                    'regex:/^[^@]+@[^@]+\.(com|org|net|edu|co|io|gov)$/i'
                ],
                'phone' => [
                    'required',
                    'regex:/^(\+8801|01)[3-9][0-9]{8}$/'
                ],
                'password' => 'bail|required|min:6|confirmed',
                'address' => 'nullable|string',
                'city' => 'required|in:Dhaka,Chittagong,Sylhet,Barisal,Rangpur,Rajshahi,Khulna',
                'region' => 'required|string'
            ], [
                'email.regex' => 'Email must end with a valid domain',
                'phone.regex' => 'Enter a valid Bangladesh phone number',
                'dob.before_or_equal' => 'You must be at least 18 years old to sign up.'
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
                'preferred_payment_method' => null,
                'role' => 'user'
            ]);

            if ($request->expectsJson()) {
                return response()->json([
                    "message" => "Registration successful"
                ], 201);
            }

            return redirect()->route('login', ['signup' => 'success']);
        } catch (ValidationException $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    "errors" => $e->errors()
                ], 422);
            }

            return back()->withErrors($e->validator)->withInput();

        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    "error" => $e->getMessage()
                ], 500);
            }
            return back()->with('error', 'Registration failed: ' . $e->getMessage())->withInput();
        }
    }

    public function logout()
    {
        try {
            auth('api')->logout();

            return response()->json([
                "error" => false,
                "message" => "Logged out successfully"
            ]);

        } catch (\Exception $e) {
            return response()->json([
                "error" => true,
                "message" => "Token not provided or already invalid"
            ], 400);
        }
    }

    public function updateProfile(Request $request)
    {
        try {
            $user = auth('api')->user();

            $request->validate([
                'fname' => 'required|string|max:255',
                'lname' => 'required|string|max:255',
                'dob' => [
                    'required',
                    'date',
                    'before_or_equal:' . Carbon::now()->subYears(18)->toDateString()
                ],
                'email' => [
                    'required',
                    'email',
                    'unique:customers,email,' . $user->id,
                    'regex:/^[^@]+@[^@]+\.(com|org|net|edu|co|io|gov)$/i'
                ],
                'phone' => [
                    'required',
                    'regex:/^(\+8801|01)[3-9][0-9]{8}$/'
                ],
                'address' => 'nullable|string',
                'city' => 'required|in:Dhaka,Chittagong,Sylhet,Barisal,Rangpur,Rajshahi,Khulna',
                'region' => 'required|string'
            ], [
                'email.regex' => 'Email must end with a valid domain',
                'phone.regex' => 'Enter a valid Bangladesh phone number',
                'dob.before_or_equal' => 'You must be at least 18 years old to use our service.'
            ]);

            $user->update([
                'fname' => $request->fname,
                'lname' => $request->lname,
                'dob' => $request->dob,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
                'city' => $request->city,
                'region' => $request->region,
            ]);

            return response()->json([
                "error" => false,
                "message" => "Profile updated successfully",
                "customer" => $user
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                "error" => true,
                "errors" => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                "error" => true,
                "message" => "Failed to update profile: " . $e->getMessage()
            ], 500);
        }
    }
}