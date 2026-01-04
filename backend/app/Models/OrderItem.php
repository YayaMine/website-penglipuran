<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
class OrderItem extends Model
{
    protected $fillable = [
        'order_id',
        'ticket_version_id',
        'quantity',
        'price',
        'subtotal',
    ];

    public function ticketVersion()
    {
        return $this->belongsTo(TicketVersion::class);
    }
}



