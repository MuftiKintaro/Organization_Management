<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ], [
            'email.required'    => 'Email wajib diisi.',
            'email.email'       => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
        ]);

        if (!$token = auth('api')->attempt($credentials)) {
            return response()->json([
                'message' => 'Email atau password salah.',
            ], 401);
        }

        return response()->json([
            'access_token' => $token,
            'token_type'   => 'bearer',
            'user'         => auth('api')->user(),
        ], 200);
    }

    public function me()
    {
        return response()->json(auth('api')->user(), 200);
    }

    public function logout()
    {
        auth('api')->logout();

        return response()->json([
            'message' => 'Berhasil logout.',
        ], 200);
    }
}
