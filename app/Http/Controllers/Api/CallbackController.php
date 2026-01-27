<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CallbackController extends Controller
{
    public function handle(Request $request)
    {
        Log::info('MIDTRANS CALLBACK RAW', $request->all());

        $orderId = $request->order_id;
        $transactionStatus = $request->transaction_status;

        /*
        |--------------------------------------------------------------------------
        | 1. COBA: PEMBAYARAN GRUP (BAYAR SEMUA)
        |--------------------------------------------------------------------------
        */
        $groupPayments = Pembayaran::where('group_order_id', $orderId)->get();

        if ($groupPayments->isNotEmpty()) {

            if (in_array($transactionStatus, ['capture', 'settlement'])) {
                foreach ($groupPayments as $p) {
                    $p->update([
                        'transaction_status' => $transactionStatus,
                        'payment_type' => $request->payment_type,
                        'status' => 'berhasil dibayar',
                    ]);
                }
            }

            return response()->json(['message' => 'OK'], 200);
        }

        /*
        |--------------------------------------------------------------------------
        | 2. FALLBACK: PEMBAYARAN SATUAN
        |--------------------------------------------------------------------------
        */
        $payment = Pembayaran::where('order_id', $orderId)->first();

        // test dari dashboard Midtrans
        if (! $payment) {
            Log::warning('ORDER ID NOT FOUND (DASHBOARD TEST)', [
                'order_id' => $orderId,
            ]);

            return response()->json(['message' => 'OK'], 200);
        }

        if (in_array($transactionStatus, ['capture', 'settlement'])) {
            $payment->update([
                'transaction_status' => $transactionStatus,
                'payment_type' => $request->payment_type,
                'status' => 'berhasil dibayar',
            ]);
        }

        return response()->json(['message' => 'OK'], 200);
    }
}
