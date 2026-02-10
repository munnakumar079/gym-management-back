<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\GymDetail;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // 🔹 REGISTER
    public function register(Request $request)
    {
        $request->validate([
            'name'      => 'required|string',
            'email'     => 'required|email|unique:users',
            'password'  => 'required|min:6',

            'gym_name'  => 'required|string',
            'city'      => 'required|string',
            'address'   => 'required|string',
        ]);

        // 1️⃣ User create
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // 2️⃣ Gym details create
        GymDetail::create([
            'user_id'  => $user->id,
            'gym_name' => $request->gym_name,
            'city'     => $request->city,
            'address'  => $request->address,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'User registered successfully',
            'data' => $user->load('gymDetail')
        ], 201);
    }

    // 🔹 LOGIN (basic)
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid credentials'
            ], 401);
        }

        return response()->json([
            'status' => true,
            'message' => 'Login successful',
            'data' => $user->load('gymDetail')
        ]);
    }
}