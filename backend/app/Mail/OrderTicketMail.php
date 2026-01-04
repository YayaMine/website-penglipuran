<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Barryvdh\DomPDF\Facade\Pdf;

class OrderTicketMail extends Mailable
{
    use SerializesModels;

    public Order $order;

    public function __construct(Order $order)
    {
        // load relasi biar aman di view & pdf
        $this->order = $order->load(
            'items.ticketVersion.category',
            'package'
        );
    }

    public function build()
    {
        // Generate PDF tiket
        $pdf = Pdf::loadView('pdf.ticket', [
            'order' => $this->order,
        ]);

        return $this
            ->subject('Tiket Wisata - ' . $this->order->order_code)
            ->view('emails.order-ticket') // body email
            ->attachData(
                $pdf->output(),
                'tiket-' . $this->order->order_code . '.pdf',
                [
                    'mime' => 'application/pdf',
                ]
            );
    }
}
