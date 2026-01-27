<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserProfileController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        if (! $user) {
            return response()->json([
                'success' => false,
                'message' => 'User tidak ditemukan atau belum login.',
            ], 401);
        }

        $iklanCount = $user->iklan()->count();
        $kritikCount = $user->kritikSaran()->count();

        return response()->json([
            'success' => true,
            'message' => 'Profil user',
            'data' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'created_at' => $user->created_at,
                'iklan_count' => $iklanCount,
                'kritik_count' => $kritikCount,
            ],
        ]);
    }
}
