<?php

namespace App\Http\Controllers;

use App\Models\Iklan;
use App\Models\Pembayaran;
use App\Models\Pengumuman;
use Illuminate\Support\Facades\Auth;

class UserDashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        return view('users.home.index', [
            'pengumuman' => Pengumuman::latest()->take(5)->get(),
            'iklans' => Iklan::latest()->take(5)->get(),

            // tagihan aktif (belum dibayar / pending)
            'tagihan' => Pembayaran::where('id_user', $userId)
                ->whereIn('status', ['belum terbayar', 'menunggu pembayaran'])
                ->latest('tanggal')
                ->first(),

            'totalPembayaran' => Pembayaran::where('id_user', $userId)
                ->where('status', 'berhasil dibayar')
                ->sum('total'),
        ]);
    }
}
