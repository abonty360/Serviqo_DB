<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            "name"=>"required",
            "email"=>"required|email|unique:users,email",
            "password"=>"required|min:6"
        ]);

        $user = User::create([
            "name"=>$request->name,
            "email"=>$request->email,
            "password"=>$request->password
        ]);

        $token = auth()->guard('api')->login($user);

        return response()->json([
            "error"=>false,
            "message"=>"Registration successful",
            "token"=>$token
        ]);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email','password');

        $user = User::where('email',$credentials['email'])
                ->where('password',$credentials['password'])
                ->first();

        if(!$user){
            return response()->json([
                "error"=>"Unauthorized"
            ],401);
        }

        $token = auth()->guard('api')->login($user);

        return response()->json([
            "error"=>false,
            "message"=>"Login successful",
            "token"=>$token
        ]);
    }

    public function logout()
    {
        auth()->guard('api')->logout();

        return response()->json([
            "error"=>false,
            "message"=>"Logged out"
        ]);
    }
}