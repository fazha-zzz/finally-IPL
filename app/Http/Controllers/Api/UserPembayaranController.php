<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pembayaran;
use Illuminate\Support\Facades\Auth;

class UserPembayaranController extends Controller
{
     public function index()
    {
        $userId = Auth::id();

        // 1️⃣ TUNGGAKAN (BELUM BAYAR)
        $tunggakan = Pembayaran::where('id_user', $userId)
            ->whereIn('status', [
                'belum terbayar',
                'menunggu pembayaran'
            ])
            ->orderBy('tanggal', 'asc')
            ->get();

        // 2️⃣ HISTORI (SEMUA STATUS)
        $histori = Pembayaran::where('id_user', $userId)
            ->orderBy('tanggal', 'desc')
            ->get();

            \Log::info('Tunggakan user '.$userId.': '.$tunggakan->count());
            \Log::info('Histori user '.$userId.': '.$histori->count());

        return response()->json([
            'success' => true,
            'message' => 'Data pembayaran berhasil diambil',
            'data' => [
                'tunggakan' => $tunggakan,
                'histori'   => $histori,
            ]
        ], 200);
    }

    public function detail($id)
{
    $userId = Auth::id();

    $pembayaran = Pembayaran::where('id_user', $userId)
        ->where('id', $id)
        ->first();

    if (!$pembayaran) {
        return response()->json([
            'success' => false,
            'message' => 'Data pembayaran tidak ditemukan'
        ], 404);
    }

    \Log::info('Detail pembayaran user '.$userId.': '.$pembayaran->id);

    return response()->json([
        'success' => true,
        'message' => 'Detail pembayaran berhasil diambil',
        'data'    => $pembayaran
    ], 200);
}
}
