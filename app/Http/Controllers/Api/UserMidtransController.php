<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Midtrans\Config;
use Midtrans\Snap;

class UserMidtransController extends Controller
{
    public function token(Request $request)
    {
        $request->validate([
            'tagihan_id' => 'required|exists:pembayarans,id',
        ]);

        $user = Auth::user();

        $pembayaran = Pembayaran::where('id', $request->tagihan_id)
            ->where('id_user', $user->id)
            ->firstOrFail();

        // Konfigurasi Midtrans
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;

        // Generate order ID unik
        $orderId = 'INV-'.$pembayaran->id.'-'.time();
        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => (int) $pembayaran->total,
            ],
            'customer_details' => [
                'first_name' => auth()->user()->name,
                'email' => auth()->user()->email,
            ],
            'callbacks' => [
                'finish' => config('app.url').'/midtrans/finish',
                'error' => config('app.url').'/midtrans/error',
                'pending' => config('app.url').'/midtrans/pending',
            ],
        ];

        $snapToken = Snap::getSnapToken($params);

        // Simpan order_id & status
        $pembayaran->update([
            'order_id' => $orderId,
            'status' => 'menunggu pembayaran',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Snap token berhasil dibuat',
            'data' => [
                'snap_token' => $snapToken,
                'order_id' => $orderId,
                'total' => $pembayaran->total,
            ],
        ], 200);
    }
}
