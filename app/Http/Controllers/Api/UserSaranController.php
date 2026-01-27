<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\KritikSaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserSaranController extends Controller
{
    public function index()
    {
        $saran = KritikSaran::where('id_user', Auth::id())
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Daftar kritik & saran',
            'data' => $saran,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'isi' => 'required|string|max:500',
        ]);

        $saran = KritikSaran::create([
            'id_user' => Auth::id(),
            'isi' => $request->isi,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Kritik & saran berhasil dikirim!',
            'data' => $saran,
        ], 201);
    }
}
