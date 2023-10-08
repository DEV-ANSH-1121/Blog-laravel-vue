<?php

namespace App\Modules\Auth\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Modules\Auth\Http\Request\LoginRequest;
use App\Modules\Auth\Http\Request\RegistrationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(RegistrationRequest $request)
    {
        $data = $request->getValidatedData();
        $user = User::create($data);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'success' => true,
            'user' => [
                'access_token' => $token,
                'data' => $user
            ]
        ]);
    }

    public function login(LoginRequest $request)
    {
        $data = $request->validated();

        if (Auth::attempt($data)) {
            $user = User::where('email', $data['email'])->first();
            $token = $user->createToken('auth_token')->plainTextToken;
            return response()->json([
                'success' => true,
                'user' => [
                    'access_token' => $token,
                    'data' => $user
                ]
            ]);
        }

        return response()->json([
            'message' => 'Invalid Credentials',
        ], 401);
    }

    public function me()
    {
        $user = auth()->user();
        return response()->json([
            'data' => $user
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'message' => 'User Logged Out Successfully'
        ]);
    }
}
