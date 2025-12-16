<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('API TOKEN')->plainTextToken;
            return response()->json([
                'user' => $user,
                'token' => $token
            ], 200);
        }

        return response()->json(['error' => 'Credenciales invalidas', 401]);
    }
    
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logged out'], 200);
    }

    public function user(Request $request)
    {
        return response()->json($request->user(), 200);
    }
}
