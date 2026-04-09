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

    // Ambil tagihan terbaru, apapun statusnya (Lunas atau Belum)
    $tagihan = Pembayaran::where('id_user', $userId)
        ->latest('tanggal')
        ->first();

    $showPopupJatuhTempo = false;

    // Cek popup cuma kalau statusnya BUKAN berhasil dibayar
    if ($tagihan && $tagihan->status !== 'berhasil dibayar') {
        if (Carbon::now()->gt(Carbon::parse($tagihan->tanggal_jatuh_tempo))) {
            $showPopupJatuhTempo = true;
        }
    }

    return view('users.home.index', [
        'pengumuman' => Pengumuman::latest()->take(5)->get(),
        'iklans' => Iklan::latest()->take(5)->get(),
        'tagihan' => $tagihan, // Sekarang ini berisi data terakhir meskipun sudah lunas
        'totalPembayaran' => Pembayaran::where('id_user', $userId)
            ->where('status', 'berhasil dibayar')
            ->sum('total'),
        'showPopupJatuhTempo' => $showPopupJatuhTempo,
    ]);
}

   
}
