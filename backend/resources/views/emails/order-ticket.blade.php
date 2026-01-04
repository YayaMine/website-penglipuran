<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Tiket Wisata</title>
</head>
<body style="font-family: Arial, Helvetica, sans-serif; background:#f4f6f8; padding:30px">

<div style="max-width:600px; margin:auto; background:#ffffff; border-radius:10px; overflow:hidden">

    <div style="background:#0d6efd; color:white; padding:20px">
        <h2 style="margin:0">🎟️ Tiket Wisata Anda</h2>
        <div style="text-align:center;margin:20px 0">
            <img 
                src="{{ config('app.url') . '/storage/' . $order->qr_code_path }}" 
                alt="QR Code"
                width="200"
            />

            <p style="font-size:12px;color:#666">
                Tunjukkan QR Code ini saat kedatangan
            </p>
    </div>

    </div>
    <div style="margin-top:20px; text-align:center;">
        <p><strong>QR Code Tiket</strong></p>
       <img 
            src="{{ config('app.url') . '/storage/' . $order->qr_code_path }}" 
            alt="QR Code"
            width="200"
        />

        <p style="font-size:12px;color:#666">
            Tunjukkan QR Code ini saat kedatangan
        </p>
    </div>
    <div style="padding:20px; color:#333">
        <p>Halo <strong>{{ $order->name }}</strong>,</p>
        <p>Terima kasih telah melakukan pemesanan tiket wisata.</p>

        <hr>

        <p><strong>Paket:</strong> {{ $order->package->name }}</p>
        <p><strong>Tanggal Kunjungan:</strong> {{ \Carbon\Carbon::parse($order->visit_date)->format('d M Y') }}</p>

        <h4>Detail Tiket</h4>
        <ul>
            @foreach ($order->items as $item)
                <li>
                    {{ $item->ticketVersion->category->name }} - {{ $item->ticketVersion->name }}
                    × {{ $item->quantity }}
                    — <strong>Rp {{ number_format($item->subtotal,0,',','.') }}</strong>
                </li>
            @endforeach
        </ul>

        <hr>

        <h3>Total Pembayaran: Rp {{ number_format($order->total_price,0,',','.') }}</h3>

        <p style="margin-top:20px">
            Silakan tunjukkan email ini atau lampiran tiket PDF saat kedatangan.
        </p>

        <p>Terima kasih 🙏</p>
    </div>

    <div style="background:#f1f1f1; padding:15px; text-align:center; font-size:12px">
        © {{ date('Y') }} Tiket Wisata • Sistem Pemesanan Resmi
    </div>

</div>

</body>
</html>
