<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Iklan;
use App\Models\Pembayaran;
use App\Models\Pengumuman;
use Illuminate\Support\Facades\Auth;

class UserDashboardController extends Controller
{
    public function index()
    {
         $userId = Auth::id();

    // tagihan aktif
    $tagihan = Pembayaran::where('id_user', $userId)
        ->whereIn('status', ['belum terbayar', 'menunggu pembayaran'])
        ->latest('tanggal')
        ->first();

    $showPopupJatuhTempo = false;

    if ($tagihan && $tagihan->status !== 'berhasil dibayar') {
        if (Carbon::now()->gt(Carbon::parse($tagihan->tanggal_jatuh_tempo))) {
            $showPopupJatuhTempo = true;
        }
    }

    return view('users.home.index', [
        'pengumuman' => Pengumuman::latest()->take(5)->get(),
        'iklans' => Iklan::latest()->take(5)->get(),
        'tagihan' => $tagihan,
        'totalPembayaran' => Pembayaran::where('id_user', $userId)
            ->where('status', 'berhasil dibayar')
            ->sum('total'),
        'showPopupJatuhTempo' => $showPopupJatuhTempo,
    ]);
    }

   
}
