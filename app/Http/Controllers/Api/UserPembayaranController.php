<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pembayaran;
use Illuminate\Support\Facades\Auth;

class UserPembayaranController extends Controller
{
    public function belumDibayar(Request $request)
    {
        $user = $request->user(); // dari sanctum / auth api

        $pembayarans = Pembayaran::where('id_user', $user->id)
            ->whereIn('status', [
                'belum terbayar',
                'menunggu pembayaran'
            ])
            ->orderBy('tanggal', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $pembayarans
        ]);
    }
}
