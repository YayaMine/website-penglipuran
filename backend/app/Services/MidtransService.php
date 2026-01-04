<?php

namespace App\Services;

use App\Models\Order;
use Midtrans\Config;
use Midtrans\Snap;

class MidtransService
{
    public static function createSnap(Order $order): string
    {
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$isProduction = config('services.midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;

        $items = [];

        foreach ($order->items as $item) {
            $items[] = [
                'id'       => (string) $item->ticketVersion->id,
                'price'    => (int) $item->price,
                'quantity' => (int) $item->quantity,
                'name'     => $item->ticketVersion->category->name
                              . ' - ' .
                              $item->ticketVersion->name,
            ];
        }

        $params = [
            'transaction_details' => [
                'order_id'     => $order->order_code,
                'gross_amount'=> (int) $order->total_price,
            ],
            'customer_details' => [
                'first_name' => $order->name,
                'email'      => $order->email,
                'phone'      => $order->phone,
            ],
            'item_details' => $items,
            
            'finish_redirect_url' => 'http://localhost:5173/payment/finish',
        ];

     
        return Snap::getSnapToken($params);
    }
}
