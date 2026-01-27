<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pembayaran;
use Illuminate\Support\Facades\Auth;

class UserPembayaranController extends Controller
{
    public function index()
    {
        $pembayarans = Pembayaran::where('id_user', Auth::id())
            ->orderBy('tanggal', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Daftar pembayaran user',
            'data' => $pembayarans,
        ], 200);
    }

    public function riwayat()
    {
        $pembayarans = Pembayaran::where('id_user', Auth::id())
            ->orderBy('tanggal', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Riwayat pembayaran',
            'data' => $pembayarans,
        ]);
    }

    public function detail($id)
    {
        $pembayaran = Pembayaran::where('id_user', Auth::id())
            ->where('id', $id)
            ->firstOrFail();

        return response()->json([
            'success' => true,
            'message' => 'Detail pembayaran',
            'data' => $pembayaran,
        ]);
    }
}
