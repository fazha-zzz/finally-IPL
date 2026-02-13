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
                'gross_amount' => (int) ($pembayaran->total + $pembayaran->denda),
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
                'order_id'   => $orderId,
                'total'      => $pembayaran->total,
                'denda'      => $pembayaran->denda,
                'total_final'=> $pembayaran->total + $pembayaran->denda,
            ],
        ], 200);

    }

    public function bayarSemua()
    {
        $userId = auth()->id();

        $pembayarans = Pembayaran::where('id_user', $userId)
            ->where('status', '!=', 'pembayaran berhasil')
            ->get();

        if ($pembayarans->count() < 1) {
            return response()->json(['message' => 'Tidak ada tunggakan'], 400);
        }

        $total = $pembayarans->sum('total');
        $groupOrderId = 'BULK-'.$userId.'-'.time();

        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;

        $params = [
    'transaction_details' => [
        'order_id'     => $groupOrderId,
        'gross_amount' => (int) $total,
    ],
    'customer_details'    => [
        'first_name' => auth()->user()->name,
        'email'      => auth()->user()->email,
    ],
    'callbacks'           => [
        'finish' => config('app.url') . '/midtrans/finish',
    ],
];


        $snapToken = \Midtrans\Snap::getSnapToken($params);

        Pembayaran::whereIn('id', $pembayarans->pluck('id'))
            ->update([
                'group_order_id' => $groupOrderId,
                'status' => 'menunggu pembayaran',
            ]);

        return response()->json([
            'success' => true,
            'message' => 'Snap token untuk pembayaran semua berhasil dibuat',
            'data' => [
                'snap_token' => $snapToken,
                'group_order_id' => $groupOrderId,
                'total' => $total,
            ],
        ], 200);
    }
}
