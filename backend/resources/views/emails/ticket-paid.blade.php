<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Tiket Wisata</title>
</head>
<body style="font-family: Arial, Helvetica, sans-serif; background:#f4f6f8; padding:30px">

<div style="max-width:600px; margin:auto; background:#ffffff; border-radius:10px; overflow:hidden">

    <!-- HEADER -->
    <div style="background:#0d6efd; color:white; padding:20px">
        <h2 style="margin:0">🎟️ Tiket Wisata Anda</h2>
        <p style="margin:5px 0 0; font-size:14px">
            Simpan email ini sebagai bukti pemesanan
        </p>
    </div>

    <!-- BODY -->
    <div style="padding:20px; color:#333">

        <p>Halo <strong>{{ $order->name }}</strong>,</p>
        <p>Terima kasih telah melakukan pemesanan tiket wisata.</p>

        <!-- KODE ORDER & TIKET -->
        <div style="background:#f8f9fa; border-radius:8px; padding:15px; margin:20px 0">
            <p style="margin:0"><strong>Kode Order</strong></p>
            <h3 style="margin:5px 0; color:#0d6efd">{{ $order->order_code }}</h3>

            <p style="margin:15px 0 0"><strong>Kode Tiket</strong></p>
            <h3 style="margin:5px 0; color:#198754">{{ $order->ticket_code }}</h3>
        </div>

        <hr>

        <!-- DETAIL -->
        <p><strong>Paket Wisata:</strong> {{ $order->package->name }}</p>
        <p>
            <strong>Tanggal Kunjungan:</strong>
            {{ \Carbon\Carbon::parse($order->visit_date)->format('d M Y') }}
        </p>

        <h4>Detail Tiket</h4>
        <ul>
            @foreach ($order->items as $item)
                <li>
                    {{ $item->ticketVersion->category->name }}
                    - {{ $item->ticketVersion->name }}
                    × {{ $item->quantity }}
                    — <strong>Rp {{ number_format($item->subtotal,0,',','.') }}</strong>
                </li>
            @endforeach
        </ul>

        <hr>

        <h3>Total Pembayaran</h3>
        <h2 style="color:#dc3545; margin-top:5px">
            Rp {{ number_format($order->total_price,0,',','.') }}
        </h2>

        <p style="margin-top:20px">
            Silakan tunjukkan:
            <br>
            ✅ <strong>Kode Tiket</strong> atau
            <br>
            ✅ Email ini
            <br>
            saat kedatangan di lokasi wisata.
        </p>

        <p>Terima kasih 🙏</p>
    </div>

    <!-- FOOTER -->
    <div style="background:#f1f1f1; padding:15px; text-align:center; font-size:12px">
        © {{ date('Y') }} Tiket Wisata • Sistem Pemesanan Resmi
    </div>

</div>

</body>
</html>
