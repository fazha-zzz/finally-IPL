<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Iklan;
use App\Models\Pembayaran;
use App\Models\Pengumuman;
use Illuminate\Support\Facades\Auth;

class UserDashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        $tagihan = Pembayaran::where('id_user', $userId)
            ->whereIn('status', ['belum terbayar', 'menunggu pembayaran'])
            ->latest('tanggal')
            ->first();

        return response()->json([
            'success' => true,
            'message' => 'Dashboard user',
            'data' => [
                'pengumuman' => Pengumuman::latest()->take(5)->get(),
                'iklans' => Iklan::latest()->take(5)->get(),
                'tagihan' => $tagihan,
                'total_pembayaran' => Pembayaran::where('id_user', $userId)
                    ->where('status', 'berhasil dibayar')
                    ->sum('total'),
            ],
        ], 200);
    }
}
