<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use App\Models\TicketVersion;
use Illuminate\Support\Str;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::where('email', 'user@gmail.com')->first();

        $tickets = TicketVersion::take(3)->get(); // contoh 3 jenis tiket

        $order = Order::create([
            'user_id' => $user->id,
            'package_id' => $tickets->first()->package_id,
            'order_code' => 'ORD-' . strtoupper(Str::random(10)),
            'ticket_code' => 'TKT-' . strtoupper(Str::random(10)),
            'name' => 'Cahya Fajar Pianto',
            'email' => $user->email,
            'phone' => '089505954228',
            'visit_date' => now()->addDays(3),
            'total_price' => 0,
            'payment_gateway' => 'midtrans',
            'payment_status' => 'pending',
        ]);

        $total = 0;

        foreach ($tickets as $ticket) {
            $qty = rand(1, 2);
            $subtotal = $ticket->price * $qty;

            OrderItem::create([
                'order_id' => $order->id,
                'ticket_version_id' => $ticket->id,
                'quantity' => $qty,
                'price' => $ticket->price,
                'subtotal' => $subtotal,
            ]);

            $total += $subtotal;
        }

        // update total order
        $order->update([
            'total_price' => $total,
        ]);
    }
}
