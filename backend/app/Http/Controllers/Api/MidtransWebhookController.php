<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class MidtransWebhookController extends Controller
{
   public function handle(Request $request)
{
    $order = Order::where('order_code', $request->order_id)->first();

    if (! $order) return response()->json(['message' => 'Order not found']);

    if ($request->transaction_status === 'settlement') {
        $order->update([
            'payment_status' => 'paid',
            'paid_at' => now(),
        ]);
    } elseif (in_array($request->transaction_status, ['cancel','expire','deny'])) {
        $order->update(['payment_status' => 'failed']);
    }

    return response()->json(['message' => 'OK']);
}
}
