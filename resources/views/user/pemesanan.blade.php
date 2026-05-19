<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Transaksi - ObatKita</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            font-family: 'Poppins', sans-serif;
            background: #f8fafc;
            color: #0f172a;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            background: #f8fafc;
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        button,
        input,
        textarea,
        select {
            font-family: inherit;
        }

        .order-history-page {
            max-width: 1120px;
            margin: 0 auto;
            padding: 2rem 1rem 3rem;
        }

        .history-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 1rem;
            flex-wrap: wrap;
            margin-bottom: 1.75rem;
        }

        .history-header h1 {
            margin: 0;
            font-size: clamp(2rem, 2.5vw, 2.4rem);
            line-height: 1.05;
        }

        .history-header p {
            margin: 0.75rem 0 0;
            color: #475569;
            max-width: 720px;
            line-height: 1.75;
        }

        .btn-primary {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.95rem 1.2rem;
            border-radius: 999px;
            background: #2563eb;
            color: #ffffff;
            border: none;
            cursor: pointer;
            transition: background 0.2s ease;
        }

        .btn-primary:hover {
            background: #1d4ed8;
        }

        .alert-box {
            border-radius: 20px;
            padding: 1rem 1.25rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 14px 35px rgba(15, 23, 42, 0.08);
        }

        .alert-success {
            background: #dcfce7;
            color: #14532d;
        }

        .alert-error {
            background: #fee2e2;
            color: #7f1d1d;
        }

        .order-list {
            display: grid;
            gap: 1.5rem;
        }

        .order-card {
            background: #ffffff;
            border-radius: 28px;
            padding: 1.6rem;
            box-shadow: 0 20px 50px rgba(15, 23, 42, 0.08);
            border: 1px solid rgba(148, 163, 184, 0.16);
        }

        .order-card-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 1rem;
            flex-wrap: wrap;
            margin-bottom: 1.25rem;
        }

        .order-card-header h2 {
            margin: 0;
            font-size: 1.15rem;
        }

        .order-status {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.55rem 0.95rem;
            border-radius: 999px;
            font-weight: 600;
            font-size: 0.95rem;
        }

        .status-pending {
            background: #fef3c7;
            color: #92400e;
        }

        .status-lunas {
            background: #dcfce7;
            color: #166534;
        }

        .status-cancelled {
            background: #fee2e2;
            color: #991b1b;
        }

        .order-info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .order-info-card {
            background: #f8fafc;
            border-radius: 18px;
            padding: 1rem 1.1rem;
            border: 1px solid #e2e8f0;
        }

        .order-info-card span {
            display: block;
            color: #94a3b8;
            font-size: 0.88rem;
            margin-bottom: 0.45rem;
        }

        .order-info-card strong {
            display: block;
            font-size: 1rem;
            color: #0f172a;
            line-height: 1.6;
        }

        .order-card-footer {
            display: flex;
            justify-content: space-between;
            gap: 1rem;
            flex-wrap: wrap;
            align-items: center;
        }

        .order-card-footer p {
            margin: 0;
            color: #64748b;
        }

        .order-actions {
            display: flex;
            gap: 0.85rem;
            flex-wrap: wrap;
        }

        .btn-secondary,
        .btn-action {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.85rem 1.1rem;
            border-radius: 999px;
            font-weight: 600;
            border: none;
            cursor: pointer;
            transition: background 0.2s ease;
            text-decoration: none;
        }

        .btn-secondary {
            background: #f8fafc;
            color: #334155;
            border: 1px solid #cbd5e1;
        }

        .btn-action {
            background: #2563eb;
            color: #ffffff;
        }

        .btn-action:hover {
            background: #1d4ed8;
        }

        .btn-secondary:hover {
            background: #e2e8f0;
        }

        .empty-state {
            text-align: center;
            padding: 3rem 1.5rem;
            background: #ffffff;
            border-radius: 28px;
            box-shadow: 0 20px 50px rgba(15, 23, 42, 0.08);
        }

        .empty-state h2 {
            margin: 0 0 0.75rem;
            font-size: 1.8rem;
        }

        .empty-state p {
            margin: 0 0 1.5rem;
            color: #64748b;
            line-height: 1.8;
        }

        @media (max-width: 768px) {
            .order-info-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>
    <main class="order-history-page">
        <section class="history-header">
            <div>
                <h1>Riwayat Transaksi</h1>
                <p>Lihat semua pesanan Anda, status pembayaran, dan cetak struk jika pesanan sudah lunas.</p>
            </div>
            <a href="{{ route('home') }}" class="btn-primary">Lanjut Belanja</a>
        </section>

        @if(session('success'))
        <div class="alert-box alert-success">{{ session('success') }}</div>
        @elseif(session('error'))
        <div class="alert-box alert-error">{{ session('error') }}</div>
        @endif

        @if($pemesanan->isEmpty())
        <section class="empty-state">
            <h2>Belum ada transaksi</h2>
            <p>Pesanan yang sudah Anda buat akan muncul di sini. Silakan beli produk terlebih dahulu untuk melihat riwayat transaksi.</p>
            <a href="{{ route('home') }}" class="btn-primary">Belanja Sekarang</a>
        </section>
        @else
        <div class="order-list">
            @foreach ($pemesanan as $item)
            <article class="order-card">
                <div class="order-card-header">
                    <div>
                        <h2>Pesanan #{{ $item->kodePemesanan }}</h2>
                        <p style="margin: 0.5rem 0 0; color: #64748b;">Dipesan pada {{ $item->created_at->format('d M Y H:i') }}</p>
                    </div>
                    <span class="order-status {{ strtolower($item->status) == 'lunas' ? 'status-lunas' : (strtolower($item->status) == 'pending' ? 'status-pending' : 'status-cancelled') }}">
                        {{ ucfirst($item->status) }}
                    </span>
                </div>

                <div class="order-info-grid">
                    <div class="order-info-card">
                        <span>Total Harga</span>
                        <strong>Rp {{ number_format($item->totalHarga, 0, ',', '.') }}</strong>
                    </div>
                    <div class="order-info-card">
                        <span>Estimasi Pembayaran</span>
                        <strong>{{ $item->estimasipembayaran ?? '-' }}</strong>
                    </div>
                    <div class="order-info-card">
                        <span>Estimasi Pengiriman</span>
                        <strong>{{ $item->estimasiPengantaran ?? '-' }}</strong>
                    </div>
                    <div class="order-info-card">
                        <span>Status Pembayaran</span>
                        <strong>{{ $item->status }}</strong>
                    </div>
                </div>

                <div class="order-card-footer">
                    <p>Gunakan tombol di samping untuk melanjutkan pembayaran atau mencetak struk.</p>
                    <div class="order-actions">
                        @if (strtolower($item->status) === 'pending')
                        <a href="{{ route('bayarUlang', $item->id) }}" class="btn-action">Bayar Sekarang</a>
                        @elseif(strtolower($item->status) === 'lunas')
                        <a href="{{ route('cetakStruk', $item->id) }}" target="_blank" class="btn-action">Cetak Struk</a>
                        @endif
                        <a href="{{ route('keranjang') }}" class="btn-secondary">Lihat Keranjang</a>
                    </div>
                </div>
            </article>
            @endforeach
        </div>
        @endif
    </main>
</body>

</html>