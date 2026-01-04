<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
class Order extends Model
{
    protected $fillable = [
        'user_id',
        'package_id',
        'order_code',
        'ticket_code',
        'name',
        'email',
        'phone',
        'visit_date',
        'total_price',
        'payment_gateway',
        'payment_method',
        'payment_reference',
        'payment_status',
        'paid_at',
    ];
    protected $casts = [
        'visit_date' => 'date',
        'paid_at' => 'datetime',
    ];
    protected static function booted()
{
    static::creating(function ($order) {
        $order->order_code = 'ORD-' . strtoupper(uniqid());
        $order->ticket_code = 'TKT-' . strtoupper(uniqid());
    });
}

        public function items()
        {
            return $this->hasMany(OrderItem::class);
        }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function ticketVersion()
    {
        return $this->belongsTo(TicketVersion::class);
    }

     public function package()
    {
        return $this->belongsTo(Package::class);
    }
}
