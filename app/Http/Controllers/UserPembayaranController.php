<?php

namespace App\Http\Controllers;

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
        ->orderBy('tanggal', 'asc') // dari yang paling lama
        ->get();

    // 2️⃣ HISTORI (SEMUA STATUS)
    $histori = Pembayaran::where('id_user', $userId)
        ->orderBy('tanggal', 'desc')
        ->get();

    return view('users.pembayaran.index', compact(
        'tunggakan',
        'histori'
    ));
}

    public function detail($id)
    {
        $pembayaran = Pembayaran::where('id_user', Auth::id())
            ->where('id', $id)
            ->firstOrFail();

        return view('users.pembayaran.detail', compact('pembayaran'));
    }
}
