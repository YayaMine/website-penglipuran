<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Models\Order;
use App\Models\TicketVersion;
use App\Services\MidtransService;
use App\Mail\TicketPaidMail;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'package_id' => 'required|exists:packages,id',
            'name'       => 'required|string',
            'email'      => 'required|email',
            'phone'      => 'required|string',
            'visit_date' => 'required|date',
            'items'      => 'required|array|min:1',
            'items.*.ticket_version_id' => 'required|exists:ticket_versions,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        $user = $request->user();

        if (! $user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $result = DB::transaction(function () use ($data, $user) {

            $totalPrice = 0;

            // ================= order create =================
            $order = Order::create([
                'user_id'         => $user->id,
                'package_id'      => $data['package_id'],
                'order_code'      => 'ORD-' . strtoupper(uniqid()),
                'ticket_code'     => 'TKT-' . strtoupper(uniqid()),
                'name'            => $data['name'],
                'email'           => $data['email'],
                'phone'           => $data['phone'],
                'visit_date'      => $data['visit_date'],
                'total_price'     => 0,
                'payment_gateway' => 'midtrans',
                'payment_status'  => 'paid', 
                'paid_at'         => now(),
            ]);

            // ================= untuk order item=================
            foreach ($data['items'] as $item) {
                $ticket = TicketVersion::findOrFail($item['ticket_version_id']);

                $subtotal = $ticket->price * $item['quantity'];
                $totalPrice += $subtotal;

                $order->items()->create([
                    'ticket_version_id' => $ticket->id,
                    'quantity'          => $item['quantity'],
                    'price'             => $ticket->price,
                    'subtotal'          => $subtotal,
                ]);
            }

            $order->update([
                'total_price' => $totalPrice,
            ]);

            // ================= snap untuk midtrans =================
            $snapToken = MidtransService::createSnap($order);

            // ================= langsung ngesend ke email kalik =================
            Mail::to($order->email)->send(new TicketPaidMail($order));

            return [
                'order' => $order,
                'snap_token' => $snapToken,
            ];
        });

        return response()->json([
            'message'     => 'Pesanan berhasil',
            'snap_token'  => $result['snap_token'],
            'order_code'  => $result['order']->order_code,
            'ticket_code' => $result['order']->ticket_code,
        ], 201);
    }
}
