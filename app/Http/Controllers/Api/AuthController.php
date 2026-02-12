<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\GymDetail;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    // ================= REGISTER =================
    public function register(Request $request)
    {
        $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|email|unique:users,email',
            'password'  => 'required|min:6',
            'mobile'    => 'required|digits:10|unique:users,mobile',
            'gym_name'  => 'required|string|max:255',
            'city'      => 'required|string|max:255',
            'address'   => 'required|string|max:255',
        ]);

        try {

            // Create User
            $user = User::create([
                'name'     => $request->name,
                'email'    => $request->email,
                'password' => Hash::make($request->password),
                'mobile'   => $request->mobile,
            ]);

            // Create Gym Details
            GymDetail::create([
                'user_id'  => $user->id,
                'gym_name' => $request->gym_name,
                'city'     => $request->city,
                'address'  => $request->address,
            ]);

            return successResponse(
                'User registered successfully',
                $user->load('gymDetail'),
                201
            );

        } catch (\Exception $e) {

            return errorResponse('Something went wrong', 500);
        }
    }

    // ================= LOGIN =================
public function login(Request $request)
{
    $credentials = $request->only('email', 'password');

    if (!$token = JWTAuth::attempt($credentials)) {
        return errorResponse('Invalid credentials', 401);
    }

    return successResponse(
        'Login successful',
        [
            'user'  => auth()->user()->load('gymDetail'),
            'token' => $token,
            'type'  => 'bearer'
        ]
    );
}

public function profile()
{
    return successResponse(
        'Profile fetched successfully',
        auth()->user()->load('gymDetail')
    );
}

public function logout()
{
    auth()->logout();

    return successResponse(
        'Logout successful'
    );
}
}