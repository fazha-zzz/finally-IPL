<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Login API User
     */
    public function login(Request $request)
    {
        $request->validate([
            'no_rumah' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = User::where('no_rumah', $request->no_rumah)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'No rumah atau password salah',
            ], 401);
        }

        // Buat token Sanctum
        $token = $user->createToken('user-token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Login berhasil',
            'token' => $token,
            'user' => $user,
        ]);
    }

    /**
     * Logout API User
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Logout berhasil',
        ]);
    }
}
