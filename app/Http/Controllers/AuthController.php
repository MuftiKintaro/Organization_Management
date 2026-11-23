<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    // WEEK 11 - TASK 01: Implement JWT Login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        /** @var \PHPOpenSourceSaver\JWTAuth\JWTGuard $guard */
        $guard = auth('api');

        if (!$token = $guard->attempt($credentials)) {
            return response()->json([
                'message' => 'Email atau password salah.'
            ], 401);
        }

        return response()->json([
            'access_token' => $token,
            'token_type'   => 'bearer',
            'expires_in'   => config('jwt.ttl', 60) * 60,
            'user'         => $guard->user(),
        ], 200);
    }

    // Cek profil user yang sedang login via JWT
    public function me()
    {
        return response()->json(auth('api')->user(), 200);
    }

    // Logout & nonaktifkan token JWT
    public function logout()
    {
        /** @var \PHPOpenSourceSaver\JWTAuth\JWTGuard $guard */
        $guard = auth('api');
        $guard->logout();

        return response()->json([
            'message' => 'Berhasil logout.'
        ], 200);
    }
}
