<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Tiket Wisata</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            background: #f4f6f8;
            padding: 30px;
        }

        .container {
            max-width: 700px;
            margin: auto;
            background: #ffffff;
            border-radius: 10px;
            overflow: hidden;
        }

        .header {
            background: #0d6efd;
            color: #ffffff;
            padding: 20px;
        }

        .header h2 {
            margin: 0;
            font-size: 20px;
        }

        .header p {
            margin: 5px 0 0;
            font-size: 13px;
        }

        .content {
            padding: 20px;
            color: #333;
            font-size: 13px;
        }

        .divider {
            border-top: 1px solid #ddd;
            margin: 15px 0;
        }

        .ticket-list {
            margin: 0;
            padding-left: 18px;
        }

        .ticket-list li {
            margin-bottom: 5px;
        }

        .total {
            font-size: 15px;
            font-weight: bold;
            margin-top: 10px;
        }

        .footer {
            background: #f1f1f1;
            padding: 12px;
            text-align: center;
            font-size: 11px;
            color: #666;
        }
    </style>
</head>
<body>

<div class="container">

    <!-- HEADER -->
    <div class="header">
        <h2>🎟️ Tiket Wisata Anda</h2>
        <div style="text-align:center;margin:20px 0">
            <img 
                src="{{ config('app.url') . '/storage/' . $order->qr_code_path }}" 
                alt="QR Code"
                width="200"
            />
        </div>
    </div>
        <div style="text-align:center; margin:20px 0">
            <img src="{{ public_path('storage/' . $order->qr_code_path) }}"
                width="160">
            <p style="font-size:11px;">Scan QR Code saat check-in</p>
        </div>

    <!-- CONTENT -->
    <div class="content">
        <p>Halo <strong>{{ $order->name }}</strong>,</p>
        <p>Terima kasih telah melakukan pemesanan tiket wisata.</p>

        <div class="divider"></div>

        <p><strong>Paket:</strong> {{ $order->package->name }}</p>
        <p><strong>Tanggal Kunjungan:</strong>
            {{ \Carbon\Carbon::parse($order->visit_date)->format('d M Y') }}
        </p>

        <p><strong>Detail Tiket:</strong></p>
        <ul class="ticket-list">
            @foreach ($order->items as $item)
                <li>
                    {{ $item->ticketVersion->category->name }}
                    - {{ $item->ticketVersion->name }}
                    × {{ $item->quantity }}
                    — Rp {{ number_format($item->subtotal,0,',','.') }}
                </li>
            @endforeach
        </ul>

        <div class="divider"></div>

        <p class="total">
            Total Pembayaran: Rp {{ number_format($order->total_price,0,',','.') }}
        </p>

        <p>
            Silakan tunjukkan email ini atau tiket PDF saat kedatangan.
        </p>

        <p>Terima kasih 🙏</p>
    </div>

    <!-- FOOTER -->
    <div class="footer">
        © {{ date('Y') }} Tiket Wisata • Sistem Pemesanan Resmi
    </div>

</div>

</body>
</html>
