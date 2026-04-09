<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Snap;

class UserMidtransController extends Controller
{
    private function initMidtrans()
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;

        // Solusi untuk error SSL Handshake di hosting
        \Midtrans\Config::$curlOptions = [
            CURLOPT_SSLVERSION => CURL_SSLVERSION_TLSv1_2,
            CURLOPT_SSL_VERIFYPEER => false,
        ];
    }

    public function token(Request $request)
    {
        $request->validate([
            'tagihan_id' => 'required|exists:pembayarans,id',
        ]);

        $pembayaran = Pembayaran::findOrFail($request->tagihan_id);

        $this->initMidtrans();

        $orderId = 'INV-' . $pembayaran->id . '-' . time();

        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => (int) $pembayaran->total_dengan_denda,
            ],
            'customer_details' => [
                'first_name' => auth()->user()->name,
                'email' => auth()->user()->email,
            ],
        ];

        $snapToken = Snap::getSnapToken($params);

        $pembayaran->update([
            'order_id' => $orderId,
            'status' => 'menunggu pembayaran',
        ]);

        return response()->json(['snap_token' => $snapToken]);
    }

    public function bayarSemua()
    {
        $userId = auth()->id();

        // PENTING: Samakan status pencarian dengan "berhasil dibayar" 
        // agar tagihan yang sudah lunas tidak muncul lagi
        $pembayarans = Pembayaran::where('id_user', $userId)
            ->where('status', '!=', 'berhasil dibayar') 
            ->get();

        if ($pembayarans->count() < 1) {
            return response()->json(['message' => 'Tidak ada tunggakan'], 400);
        }

        $total = $pembayarans->sum(function ($item) {
            return $item->total_dengan_denda;
        });

        $this->initMidtrans();

        $groupOrderId = 'BULK-' . $userId . '-' . time();

        $params = [
            'transaction_details' => [
                'order_id' => $groupOrderId,
                'gross_amount' => (int) $total,
            ],
            'customer_details' => [
                'first_name' => auth()->user()->name,
                'email' => auth()->user()->email,
            ],
        ];

        $snapToken = Snap::getSnapToken($params);

        Pembayaran::whereIn('id', $pembayarans->pluck('id'))
            ->update([
                'group_order_id' => $groupOrderId,
                'status' => 'menunggu pembayaran',
            ]);

        return response()->json(['snap_token' => $snapToken]);
    }
}
