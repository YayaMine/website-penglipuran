<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MidtransCallbackController extends Controller
{
    public function handle(Request $request)
    {
        Log::info('Midtrans callback payload', $request->all());

        $orderCode = $request->input('order_id');
        $transactionStatus = $request->input('transaction_status');

        $order = Order::where('order_code', $orderCode)->first();

        if (! $order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        // ================= kalo bener yaa =================
        if (in_array($transactionStatus, ['capture', 'settlement'])) {
            $order->update([
                'payment_status'    => 'paid',
                'payment_reference' => $request->input('transaction_id'),
                'paid_at'           => now(),
            ]);
        }

        // ================= kalo gagal semoga ga =================
        if (in_array($transactionStatus, ['deny', 'cancel', 'expire'])) {
            $order->update([
                'payment_status' => 'failed',
            ]);
        }

        return response()->json([
            'message' => 'Callback processed',
        ]);
    }
}
