<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderTicketMail;

class MidtransWebhookController extends Controller
{
    public function handle(Request $request)
    {
        // Ambil order berdasarkan order_code
        $order = Order::where('order_code', $request->order_id)->first();

        if (! $order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        $status = $request->transaction_status;

        if ($status === 'settlement') {
            $order->update([
                'payment_status' => 'paid',
                'paid_at' => now(),
            ]);

            // Kirim email + PDF tiket
            Mail::to($order->email)->send(new OrderTicketMail($order));
        }

        if (in_array($status, ['expire', 'cancel', 'deny'])) {
            $order->update([
                'payment_status' => 'failed',
            ]);
        }

        return response()->json(['status' => 'ok']);
    }
}
