<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Transaksi - ObatKita</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary: #1e40af;
            --primary-light: #eff6ff;
            --primary-hover: #1e3a8a;
            --accent: #16a34a;
            --accent-light: #f0fdf4;
            --warning: #d97706;
            --warning-light: #fef3c7;
            --danger: #e11d48;
            --danger-light: #fff1f2;
            --bg-body: #f8fafc;
            --text-main: #0f172a;
            --text-muted: #475569;
            --border-color: #cbd5e1;
            --white: #ffffff;
            --shadow-sm: 0 1px 3px 0 rgba(0, 0, 0, 0.05), 0 1px 2px 0 rgba(0, 0, 0, 0.03);
            --shadow-md: 0 4px 12px -2px rgba(15, 23, 42, 0.06), 0 2px 6px -1px rgba(15, 23, 42, 0.03);
            --shadow-lg: 0 12px 24px -4px rgba(15, 23, 42, 0.08), 0 4px 12px -2px rgba(15, 23, 42, 0.04);
            font-family: 'Inter', sans-serif;
            background: var(--bg-body);
            color: var(--text-main);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            background: var(--bg-body);
            color: var(--text-main);
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
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
            outline: none;
        }

        /* Top Header Navigation */
        .cart-navbar {
            background: var(--white);
            border-bottom: 1px solid #e2e8f0;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: var(--shadow-sm);
        }

        .navbar-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0.85rem 1.25rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar-brand {
            display: flex;
            align-items: center;
            height: 52px;
        }

        .navbar-brand img {
            height: 120px;
            transform: scale(1.5);
            object-fit: contain;
            pointer-events: none;
            margin-left: -20px;
        }

        .btn-back-link {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            color: var(--primary);
            font-weight: 600;
            font-size: 0.9rem;
            transition: transform 0.2s ease, color 0.2s ease;
        }

        .btn-back-link:hover {
            color: var(--primary-hover);
            transform: translateX(-3px);
        }

        /* Main Page Wrapper */
        .order-history-page {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2.5rem 1.25rem 4rem;
        }

        /* Page Header */
        .history-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 1.5rem;
            flex-wrap: wrap;
            margin-bottom: 2.5rem;
        }

        .history-header h1 {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 1.85rem;
            font-weight: 750;
            color: var(--text-main);
            letter-spacing: -0.02em;
            margin-bottom: 0.4rem;
            display: flex;
            align-items: center;
            gap: 0.65rem;
        }

        .history-header h1 i {
            color: var(--primary);
            font-size: 1.6rem;
        }

        .history-header p {
            color: var(--text-muted);
            font-size: 0.92rem;
            max-width: 650px;
        }

        .btn-primary {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1.35rem;
            border-radius: 10px;
            background: var(--primary);
            color: var(--white);
            font-weight: 600;
            font-size: 0.9rem;
            border: none;
            cursor: pointer;
            transition: all 0.2s ease;
            box-shadow: var(--shadow-sm);
        }

        .btn-primary:hover {
            background: var(--primary-hover);
            transform: translateY(-1px);
        }

        /* Alert System */
        .alert-box {
            border-radius: 12px;
            padding: 0.85rem 1.25rem;
            margin-bottom: 2rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-weight: 600;
            font-size: 0.92rem;
            animation: slideIn 0.25s ease-out;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-8px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .alert-success {
            background: var(--accent-light);
            color: #15803d;
            border: 1px solid rgba(22, 163, 74, 0.2);
        }

        .alert-error {
            background: var(--danger-light);
            color: #b91c1c;
            border: 1px solid rgba(225, 29, 72, 0.2);
        }

        /* Order List Container */
        .order-list {
            display: grid;
            gap: 1.5rem;
        }

        /* Order Card - Professional semi-formal design */
        .order-card {
            background: var(--white);
            border-radius: 16px;
            padding: 1.75rem;
            box-shadow: var(--shadow-sm);
            border: 1px solid #e2e8f0;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .order-card:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
            border-color: #cbd5e1;
        }

        /* Card Header */
        .order-card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 1rem;
            flex-wrap: wrap;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #f1f5f9;
        }

        .order-card-header h2 {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 1.15rem;
            font-weight: 700;
            color: var(--text-main);
            letter-spacing: -0.01em;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .order-card-header h2 i {
            color: #64748b;
            font-size: 1rem;
        }

        .order-card-header p {
            color: var(--text-muted);
            font-size: 0.85rem;
            font-weight: 500;
        }

        /* Badges for status - rectangular-rounded, formal */
        .order-status {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            padding: 0.35rem 0.8rem;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status-pending {
            background: var(--warning-light);
            color: #92400e;
            border: 1px solid rgba(217, 119, 6, 0.2);
        }

        .status-lunas {
            background: var(--accent-light);
            color: #15803d;
            border: 1px solid rgba(22, 163, 74, 0.2);
        }

        .status-cancelled {
            background: var(--danger-light);
            color: #991b1b;
            border: 1px solid rgba(225, 29, 72, 0.2);
        }

        .order-type {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            padding: 0.35rem 0.8rem;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .type-cash {
            background: #f1f5f9;
            color: #475569;
            border: 1px solid #cbd5e1;
        }
        
        .type-credit {
            background: #eff6ff;
            color: #1e40af;
            border: 1px solid rgba(30, 64, 175, 0.2);
        }

        /* Order Info Grid */
        .order-info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 1rem;
            margin-bottom: 1.75rem;
        }

        /* Individual Info Cards */
        .order-info-card {
            background: #f8fafc;
            border-radius: 12px;
            padding: 1.15rem;
            border: 1px solid #e2e8f0;
            transition: all 0.2s ease;
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
        }

        .order-info-card:hover {
            background: #f1f5f9;
            border-color: #cbd5e1;
        }

        .order-info-card i {
            font-size: 1.15rem;
            color: #64748b;
            margin-top: 2px;
        }

        .order-info-card-content {
            display: flex;
            flex-direction: column;
        }

        .order-info-card span {
            color: var(--text-muted);
            font-size: 0.78rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 0.25rem;
        }

        .order-info-card strong {
            font-size: 1rem;
            font-weight: 700;
            color: var(--text-main);
        }

        /* Card Footer */
        .order-card-footer {
            display: flex;
            justify-content: space-between;
            gap: 1.5rem;
            flex-wrap: wrap;
            align-items: center;
            padding-top: 1.25rem;
            border-top: 1px solid #f1f5f9;
        }

        .order-card-footer p {
            color: var(--text-muted);
            font-size: 0.88rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 0.4rem;
        }

        .order-card-footer p i {
            color: #64748b;
        }

        .order-actions {
            display: flex;
            gap: 0.75rem;
            flex-wrap: wrap;
        }

        /* Premium semi-formal Buttons */
        .btn-action {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            padding: 0.7rem 1.25rem;
            border-radius: 10px;
            font-weight: 600;
            font-size: 0.88rem;
            border: none;
            cursor: pointer;
            color: var(--white);
            background: var(--primary);
            transition: all 0.2s ease;
            box-shadow: var(--shadow-sm);
        }

        .btn-action:hover {
            background: var(--primary-hover);
            transform: translateY(-1px);
        }

        .btn-secondary {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            padding: 0.7rem 1.25rem;
            border-radius: 10px;
            font-weight: 600;
            font-size: 0.88rem;
            color: var(--text-main);
            background: var(--white);
            border: 1px solid #cbd5e1;
            transition: all 0.2s ease;
            box-shadow: var(--shadow-sm);
        }

        .btn-secondary:hover {
            background: #f8fafc;
            border-color: #94a3b8;
            transform: translateY(-1px);
        }

        /* Empty State Screen */
        .empty-state {
            text-align: center;
            padding: 4.5rem 2rem;
            background: var(--white);
            border-radius: 16px;
            box-shadow: var(--shadow-sm);
            border: 1px solid #e2e8f0;
            max-width: 600px;
            margin: 3rem auto;
        }

        .empty-illustration {
            width: 120px;
            height: 120px;
            background: var(--primary-light);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.75rem;
            font-size: 3.5rem;
            color: var(--primary);
            position: relative;
        }

        .empty-illustration i {
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {
            0% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-6px);
            }
            100% {
                transform: translateY(0);
            }
        }

        .empty-state h2 {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 1.5rem;
            font-weight: 750;
            color: var(--text-main);
            margin-bottom: 0.5rem;
            letter-spacing: -0.02em;
        }

        .empty-state p {
            color: var(--text-muted);
            font-size: 0.92rem;
            max-width: 420px;
            margin: 0 auto 2rem;
            line-height: 1.6;
        }

        /* Responsive Breakpoints */
        @media (max-width: 768px) {
            .order-info-grid {
                grid-template-columns: 1fr;
            }

            .history-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .btn-primary {
                width: 100%;
                justify-content: center;
            }

            .order-card-footer {
                flex-direction: column;
                align-items: stretch;
            }

            .order-actions {
                flex-direction: column;
            }

            .btn-action, .btn-secondary {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
</head>

<body>
    <!-- Top Header Navigation -->
    <header class="cart-navbar">
        <div class="navbar-container">
            <a href="{{ route('home') }}" class="navbar-brand">
                <img src="{{ asset('img/obatkitalogo.png') }}" alt="ObatKita">
            </a>
            <a href="{{ route('home') }}" class="btn-back-link">
                <i class="fas fa-arrow-left"></i> Kembali Belanja
            </a>
        </div>
    </header>

    <main class="order-history-page">
        <section class="history-header">
            <div>
                <h1><i class="fas fa-history"></i> Riwayat Transaksi</h1>
                <p>Lihat semua pesanan Anda, status pembayaran, dan cetak struk jika pesanan sudah lunas.</p>
            </div>
            <a href="{{ route('home') }}" class="btn-primary"><i class="fas fa-shopping-bag"></i> Lanjut Belanja</a>
        </section>

        @if(session('success'))
        <div class="alert-box alert-success">
            <i class="fas fa-check-circle"></i>
            <div>{{ session('success') }}</div>
        </div>
        @elseif(session('error'))
        <div class="alert-box alert-error">
            <i class="fas fa-exclamation-circle"></i>
            <div>{{ session('error') }}</div>
        </div>
        @endif

        @if($pemesanan->isEmpty())
        <section class="empty-state">
            <div class="empty-illustration">
                <i class="fas fa-receipt"></i>
            </div>
            <h2>Belum ada transaksi</h2>
            <p>Pesanan yang sudah Anda buat akan muncul di sini. Silakan beli produk terlebih dahulu untuk melihat riwayat transaksi.</p>
            <a href="{{ route('home') }}" class="btn-primary"><i class="fas fa-capsules"></i> Belanja Sekarang</a>
        </section>
        @else
        <div class="order-list">
            @foreach ($pemesanan as $item)
            <article class="order-card">
                <div class="order-card-header">
                    <div>
                        <h2><i class="fas fa-box-open"></i> Pesanan #{{ $item->kodePemesanan }}</h2>
                        <p>Dipesan pada {{ $item->created_at->format('d M Y H:i') }}</p>
                    </div>
                    <div style="display: flex; gap: 0.5rem; align-items: center; flex-wrap: wrap;">
                        @if(in_array(strtolower($item->tipePembayaran ?? $item->typePembayaran), ['credit', 'kredit']))
                        <span class="order-type type-credit">
                            <i class="fas fa-calendar-alt"></i> Credit 21 Hari
                        </span>
                        @else
                        <span class="order-type type-cash">
                            <i class="fas fa-wallet"></i> Cash
                        </span>
                        @endif

                        @if(strtolower($item->status) == 'lunas')
                        <span class="order-status status-lunas">
                            <i class="fas fa-check-circle"></i> {{ ucfirst($item->status) }}
                        </span>
                        @elseif(in_array(strtolower($item->status), ['pending', 'credit']))
                        <span class="order-status status-pending">
                            <i class="fas fa-clock"></i> {{ ucfirst($item->status) }}
                        </span>
                        @else
                        <span class="order-status status-cancelled">
                            <i class="fas fa-times-circle"></i> {{ ucfirst($item->status) }}
                        </span>
                        @endif
                    </div>
                </div>

                <div class="order-info-grid">
                    <div class="order-info-card">
                        <i class="fas fa-wallet"></i>
                        <div class="order-info-card-content">
                            <span>Total Harga</span>
                            <strong>Rp {{ number_format($item->totalHarga, 0, ',', '.') }}</strong>
                        </div>
                    </div>
                    <div class="order-info-card">
                        <i class="fas fa-calendar-alt"></i>
                        <div class="order-info-card-content">
                            <span>Estimasi Pembayaran</span>
                            <strong>{{ $item->estimasipembayaran ?? '-' }}</strong>
                        </div>
                    </div>
                    <div class="order-info-card">
                        <i class="fas fa-shipping-fast"></i>
                        <div class="order-info-card-content">
                            <span>Estimasi Pengiriman</span>
                            <strong>{{ $item->estimasiPengantaran ?? '-' }}</strong>
                        </div>
                    </div>
                    <div class="order-info-card">
                        <i class="fas fa-info-circle"></i>
                        <div class="order-info-card-content">
                            <span>Status Pembayaran</span>
                            <strong>{{ $item->status }}</strong>
                        </div>
                    </div>
                </div>

                <div class="order-card-footer">
                    <p>
                        @if(in_array(strtolower($item->tipePembayaran ?? $item->typePembayaran), ['credit', 'kredit']))
                            <i class="fas fa-info-circle"></i> Pembayaran jatuh tempo pada {{ \Carbon\Carbon::parse($item->estimasipembayaran)->format('d M Y') }}.
                        @else
                            <i class="fas fa-info-circle"></i> Gunakan tombol di samping untuk melanjutkan pembayaran atau mencetak struk.
                        @endif
                    </p>
                    <div class="order-actions">
                        @if (in_array(strtolower($item->status), ['pending', 'credit']))
                        <button type="button" class="btn-action pay-now-btn" data-url="{{ route('bayarUlang', $item->id) }}"><i class="fas fa-credit-card"></i> Bayar Sekarang</button>
                        @endif
                        @if(strtolower($item->status) === 'lunas')
                        <a href="{{ route('cetakStruk', $item->id) }}" target="_blank" class="btn-action"><i class="fas fa-print"></i> Cetak Struk</a>
                        @endif
                        <a href="{{ route('keranjang') }}" class="btn-secondary"><i class="fas fa-shopping-cart"></i> Lihat Keranjang</a>
                    </div>
                </div>
            </article>
            @endforeach
        </div>
        @endif
    </main>

    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const payButtons = document.querySelectorAll('.pay-now-btn');
            payButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const url = this.getAttribute('data-url');
                    const originalText = this.innerHTML;
                    this.disabled = true;
                    this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memuat...';

                    fetch(url, {
                        method: 'GET',
                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.snapToken) {
                            window.snap.pay(data.snapToken, {
                                onSuccess: function(result) {
                                    alert('Pembayaran Berhasil! Pesanan Anda sedang diproses.');
                                    window.location.reload();
                                },
                                onPending: function(result) {
                                    alert('Menunggu pembayaran...');
                                    window.location.reload();
                                },
                                onError: function(result) {
                                    alert('Pembayaran gagal!');
                                    button.disabled = false;
                                    button.innerHTML = originalText;
                                },
                                onClose: function() {
                                    alert('Anda menutup popup sebelum bayar.');
                                    button.disabled = false;
                                    button.innerHTML = originalText;
                                }
                            });
                        } else if (data.error) {
                            alert(data.error);
                            button.disabled = false;
                            button.innerHTML = originalText;
                        } else {
                            alert('Gagal mengambil token pembayaran.');
                            button.disabled = false;
                            button.innerHTML = originalText;
                        }
                    })
                    .catch(error => {
                        console.error(error);
                        alert('Terjadi kesalahan koneksi.');
                        button.disabled = false;
                        button.innerHTML = originalText;
                    });
                });
            });
        });
    </script>
</body>
</html>