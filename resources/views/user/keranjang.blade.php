<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Belanja - ObatKita</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary: #2563eb;
            /* Royal Blue */
            --primary-light: #eff6ff;
            --primary-hover: #1d4ed8;
            --accent: #10b981;
            /* Emerald Green */
            --accent-light: #ecfdf5;
            --bg-body: #f8fafc;
            --text-main: #0f172a;
            --text-muted: #64748b;
            --border-color: #e2e8f0;
            --white: #ffffff;
            --danger: #ef4444;
            --danger-light: #fef2f2;
            --danger-hover: #dc2626;
            --shadow-sm: 0 2px 8px rgba(15, 23, 42, 0.04);
            --shadow-md: 0 12px 35px rgba(15, 23, 42, 0.06);
            --shadow-lg: 0 24px 50px rgba(15, 23, 42, 0.08);
            font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
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
        input {
            font-family: inherit;
            outline: none;
        }

        /* Top Header Navigation */
        .cart-navbar {
            background: var(--white);
            border-bottom: 1px solid var(--border-color);
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

        /* Cart Page Wrapper */
        .cart-page {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem 1.25rem 4rem;
        }

        /* Cart Head Title */
        .cart-title-section {
            margin-bottom: 1.75rem;
        }

        .cart-title-section h1 {
            font-size: 1.85rem;
            font-weight: 800;
            color: var(--text-main);
            letter-spacing: -0.03em;
            margin-bottom: 0.35rem;
        }

        .cart-title-section p {
            color: var(--text-muted);
            font-size: 0.95rem;
        }

        /* Alert System */
        .alert-box {
            border-radius: 16px;
            padding: 1rem 1.25rem;
            margin-bottom: 1.75rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-weight: 550;
            font-size: 0.95rem;
            animation: slideIn 0.3s ease-out;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .alert-success {
            background: var(--accent-light);
            color: #065f46;
            border: 1px solid rgba(16, 185, 129, 0.2);
        }

        .alert-error {
            background: var(--danger-light);
            color: #991b1b;
            border: 1px solid rgba(239, 68, 68, 0.2);
        }

        /* Main Cart Layout */
        .cart-grid {
            display: grid;
            grid-template-columns: 1.9fr 1.1fr;
            gap: 1.75rem;
            align-items: start;
        }

        /* Left Column: Cart List */
        .cart-list {
            background: var(--white);
            border-radius: 20px;
            border: 1px solid var(--border-color);
            box-shadow: var(--shadow-sm);
            overflow: hidden;
        }

        .store-header {
            padding: 1.25rem 1.5rem;
            background: #fafafb;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .store-header i {
            color: var(--primary);
            font-size: 1.1rem;
        }

        .store-name {
            font-weight: 700;
            font-size: 1rem;
            color: var(--text-main);
        }

        .store-badge {
            background: var(--primary-light);
            color: var(--primary);
            font-size: 0.65rem;
            font-weight: 700;
            padding: 0.2rem 0.5rem;
            border-radius: 6px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Cart Item Card */
        .cart-item {
            display: grid;
            grid-template-columns: 120px 1fr;
            gap: 1.5rem;
            padding: 1.5rem;
            border-bottom: 1px solid var(--border-color);
            transition: background-color 0.2s ease;
        }

        .cart-item:last-child {
            border-bottom: none;
        }

        .cart-item:hover {
            background-color: #fafbfd;
        }

        .cart-item-image-box {
            position: relative;
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid var(--border-color);
            aspect-ratio: 1;
            background: #f8fafc;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .cart-item-image-box img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .cart-item:hover .cart-item-image-box img {
            transform: scale(1.05);
        }

        .cart-item-content {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .item-info {
            margin-bottom: 0.75rem;
        }

        .item-title {
            font-size: 1.05rem;
            font-weight: 700;
            color: var(--text-main);
            margin-bottom: 0.35rem;
            line-height: 1.4;
        }

        .item-desc {
            color: var(--text-muted);
            font-size: 0.85rem;
            line-height: 1.5;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        /* Price and Control Row */
        .item-actions-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
            padding-top: 0.75rem;
            border-top: 1px dashed #e2e8f0;
        }

        .item-price-info {
            display: flex;
            flex-direction: column;
            gap: 0.15rem;
        }

        .item-unit-price {
            font-size: 0.8rem;
            color: var(--text-muted);
        }

        .item-subtotal {
            font-size: 1.1rem;
            font-weight: 800;
            color: var(--accent);
        }

        .item-controls {
            display: flex;
            align-items: center;
            gap: 1.25rem;
        }

        .qty-display-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: var(--bg-body);
            padding: 0.45rem 0.85rem;
            border-radius: 30px;
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--text-main);
            border: 1px solid var(--border-color);
        }

        .qty-display-badge i {
            color: var(--text-muted);
            font-size: 0.75rem;
        }

        /* Delete Button */
        .btn-delete-form {
            margin: 0;
        }

        .btn-delete-text {
            background: transparent;
            border: none;
            color: var(--text-muted);
            font-weight: 600;
            font-size: 0.85rem;
            cursor: pointer;
            transition: all 0.2s ease;
            padding: 0.45rem 0.85rem;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .btn-delete-text:hover {
            color: var(--danger);
            background: var(--danger-light);
        }

        .btn-delete-text i {
            font-size: 0.95rem;
            pointer-events: none;
            /* Make click pass through to the button */
        }

        /* Right Column: Checkout Summary Sidebar */
        .cart-summary {
            background: var(--white);
            border-radius: 20px;
            border: 1px solid var(--border-color);
            box-shadow: var(--shadow-sm);
            padding: 1.5rem;
            position: sticky;
            top: 90px;
            /* offset for nav */
        }

        .summary-header {
            font-weight: 800;
            font-size: 1.15rem;
            color: var(--text-main);
            margin-bottom: 1.25rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .summary-header i {
            color: var(--primary);
        }

        .summary-details {
            display: flex;
            flex-direction: column;
            gap: 0.85rem;
            margin-bottom: 1.25rem;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            font-size: 0.92rem;
            color: var(--text-muted);
        }

        .summary-row.total-row {
            font-size: 1.15rem;
            font-weight: 800;
            color: var(--text-main);
            padding-top: 1rem;
            border-top: 1px dashed var(--border-color);
            margin-top: 0.5rem;
        }

        .summary-row.total-row .total-amount {
            color: var(--accent);
            font-size: 1.25rem;
        }

        .free-shipping-tag {
            color: var(--accent);
            font-weight: 700;
            background: var(--accent-light);
            padding: 0.15rem 0.5rem;
            border-radius: 6px;
            font-size: 0.75rem;
        }

        /* Modern Gradient Checkout Button */
        .checkout-button-container {
            margin-top: 1.5rem;
        }

        .checkout-button {
            width: 100%;
            border: none;
            border-radius: 14px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-hover) 100%);
            color: var(--white);
            padding: 1rem;
            font-size: 1rem;
            font-weight: 700;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            box-shadow: 0 4px 15px rgba(37, 99, 235, 0.25);
            transition: all 0.3s ease;
        }

        .checkout-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(37, 99, 235, 0.35);
        }

        .checkout-button:disabled {
            background: #cbd5e1;
            box-shadow: none;
            cursor: not-allowed;
            transform: none;
        }

        .checkout-tip {
            margin-top: 1rem;
            font-size: 0.78rem;
            color: var(--text-muted);
            line-height: 1.5;
            display: flex;
            gap: 0.5rem;
            align-items: flex-start;
        }

        .checkout-tip i {
            color: var(--accent);
            margin-top: 2px;
        }

        /* Trust Badges */
        .trust-badges-card {
            margin-top: 1.25rem;
            padding: 1rem;
            background: #fafafb;
            border-radius: 12px;
            border: 1px solid var(--border-color);
        }

        .trust-badge-item {
            display: flex;
            align-items: center;
            gap: 0.65rem;
            font-size: 0.78rem;
            color: var(--text-muted);
            margin-bottom: 0.65rem;
        }

        .trust-badge-item:last-child {
            margin-bottom: 0;
        }

        .trust-badge-item i {
            font-size: 0.9rem;
            color: var(--primary);
            width: 16px;
            text-align: center;
        }

        /* Empty State */
        .empty-cart-section {
            background: var(--white);
            border-radius: 24px;
            border: 1px solid var(--border-color);
            box-shadow: var(--shadow-sm);
            padding: 4.5rem 2rem;
            text-align: center;
            max-width: 600px;
            margin: 3rem auto;
        }

        .empty-cart-illustration {
            width: 140px;
            height: 140px;
            background: var(--primary-light);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.75rem;
            font-size: 4rem;
            color: var(--primary);
            position: relative;
        }

        .empty-cart-illustration i {
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {
            0% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-8px);
            }

            100% {
                transform: translateY(0);
            }
        }

        .empty-cart-section h2 {
            font-size: 1.6rem;
            font-weight: 800;
            color: var(--text-main);
            margin-bottom: 0.75rem;
            letter-spacing: -0.02em;
        }

        .empty-cart-section p {
            color: var(--text-muted);
            font-size: 0.95rem;
            max-width: 420px;
            margin: 0 auto 2rem;
            line-height: 1.6;
        }

        .btn-shopping-start {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.95rem 1.75rem;
            background: var(--primary);
            color: var(--white);
            font-weight: 700;
            border-radius: 30px;
            box-shadow: 0 4px 15px rgba(37, 99, 235, 0.2);
            transition: all 0.3s ease;
        }

        .btn-shopping-start:hover {
            background: var(--primary-hover);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(37, 99, 235, 0.3);
        }

        /* Responsive Breakpoints */
        @media (max-width: 992px) {
            .cart-grid {
                grid-template-columns: 1fr;
            }

            .cart-summary {
                position: static;
            }
        }

        @media (max-width: 600px) {
            .cart-item {
                grid-template-columns: 80px 1fr;
                gap: 1rem;
                padding: 1.15rem;
            }

            .item-actions-row {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.75rem;
            }

            .item-controls {
                width: 100%;
                justify-content: space-between;
            }

            .navbar-brand span {
                display: none;
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

    <main class="cart-page">
        <!-- Alert Banner System -->
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

        @if($pemesananPending->isNotEmpty())
        <div class="alert-box alert-error">
            <i class="fas fa-exclamation-circle"></i>
            <div>Ada Pemesanan yang belum lunas</div>
        </div>
        @endif

        @if($items->isEmpty())
        <!-- Gorgeous Empty Cart Screen -->
        <section class="empty-cart-section">
            <div class="empty-cart-illustration">
                <i class="fas fa-shopping-basket"></i>
            </div>
            <h2>Keranjang belanja Anda kosong</h2>
            <p>Sepertinya Anda belum menambahkan produk apapun. Mari jelajahi katalog produk kesehatan kami dan temukan kebutuhan Anda!</p>
            <a href="{{ route('home') }}" class="btn-shopping-start">
                <i class="fas fa-capsules"></i> Mulai Belanja Sekarang
            </a>
        </section>
        @else
        <!-- Cart Dashboard Grid -->
        <div class="cart-title-section">
            <h1>Keranjang Belanja</h1>
            <p>Periksa kembali produk pilihan Anda sebelum melanjutkan pembayaran.</p>
        </div>

        <div class="cart-grid">
            <!-- Left Side: Product List -->
            <section class="cart-list">
                <div class="store-header">
                    <i class="fas fa-store"></i>
                    <span class="store-name">Apotek ObatKita Resmi</span>
                    <span class="store-badge">Official Store</span>
                </div>

                @foreach ($items as $item)
                <article class="cart-item">
                    <div class="cart-item-image-box">
                        <img src="{{ asset('storage/' . $item->produk->gambar) }}" alt="{{ $item->produk->namaProduk }}">
                    </div>

                    <div class="cart-item-content">
                        <div class="item-info">
                            <h3 class="item-title">{{ $item->produk->namaProduk }}</h3>
                            <p class="item-desc">{{ \Illuminate\Support\Str::limit($item->produk->deskripsi, 120, '...') }}</p>

                            @if($item->has_diskon)
                            <div style="margin-top: 0.45rem;">
                                <span style="display: inline-flex; align-items: center; gap: 0.35rem; padding: 0.35rem 0.75rem; border-radius: 999px; background: var(--accent-light); color: #065f46; border: 1px solid rgba(16, 185, 129, 0.2); font-size: 0.78rem; font-weight: 700; width: fit-content; box-shadow: var(--shadow-sm);">
                                    Diskon Kuantitas ({{ number_format($item->diskon_rule->diskon, 0) }}%): -Rp {{ number_format($item->diskon_nominal, 0, ',', '.') }}
                                </span>
                            </div>
                            @endif

                            @if($item->next_diskon_rule)
                            <div style="margin-top: 0.45rem; background: var(--primary-light); border: 1px dashed rgba(37, 99, 235, 0.3); border-radius: 12px; padding: 0.5rem 0.75rem; font-size: 0.78rem; color: var(--primary-hover); width: fit-content; max-width: 100%; line-height: 1.5; box-sizing: border-box; font-weight: 600;">
                                💡 Beli <strong>{{ $item->next_diskon_rule->minimalBeli - $item->jumlah }}</strong> lagi untuk mendapat potongan <strong>{{ number_format($item->next_diskon_rule->diskon, 0) }}%</strong>!
                            </div>
                            @endif
                        </div>

                        <div class="item-actions-row">
                            <div class="item-price-info">
                                <span class="item-unit-price">Harga satuan: Rp {{ number_format($item->produk->harga, 0, ',', '.') }}</span>
                                @if($item->has_diskon)
                                <span class="item-subtotal">Subtotal:
                                    <del style="color: var(--text-muted); font-size: 0.9em; font-weight: normal; margin-right: 0.35rem;">Rp {{ number_format($item->subtotal_original, 0, ',', '.') }}</del>
                                    <span style="color: var(--accent);">Rp {{ number_format($item->subtotal_discounted, 0, ',', '.') }}</span>
                                </span>
                                @else
                                <span class="item-subtotal">Subtotal: Rp {{ number_format($item->subtotal_original, 0, ',', '.') }}</span>
                                @endif
                            </div>

                            <div class="item-controls">
                                <div class="qty-display-badge">
                                    <i class="fas fa-boxes"></i>
                                    <span>Jumlah: {{ $item->jumlah }}</span>
                                </div>

                                <form action="{{ route('removeItemKeranjang', ['id' => $item->id]) }}" method="post" class="btn-delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-delete-text" onclick="return confirm('Apakah Anda yakin ingin menghapus item ini dari keranjang?')" title="Hapus Item">
                                        <i class="far fa-trash-alt"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </article>
                @endforeach
            </section>

            <!-- Right Side: Sticky Checkout Card -->
            <aside class="cart-summary">
                <h2 class="summary-header">
                    <i class="fas fa-receipt"></i> Ringkasan Belanja
                </h2>

                <div class="summary-details">
                    <div class="summary-row">
                        <span>Total Barang</span>
                        <strong style="color: var(--text-main);">{{ $items->sum('jumlah') }} unit</strong>
                    </div>
                    <div class="summary-row">
                        <span>Subtotal</span>
                        <span>Rp {{ number_format($items->sum('subtotal_original'), 0, ',', '.') }}</span>
                    </div>
                    @if($items->sum('diskon_nominal') > 0)
                    <div class="summary-row" style="color: var(--accent); font-weight: 700;">
                        <span>Total Diskon Kuantitas</span>
                        <span>-Rp {{ number_format($items->sum('diskon_nominal'), 0, ',', '.') }}</span>
                    </div>
                    @endif
                    <div class="summary-row">
                        <span>Estimasi Ongkos Kirim</span>
                        <span class="free-shipping-tag">Gratis Ongkir</span>
                    </div>

                    <div class="summary-row total-row">
                        <span>Total Bayar</span>
                        <span class="total-amount">Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>
                </div>

                <div class="checkout-button-container" style="display: flex; flex-direction: column; gap: 0.75rem;">
                    <form action="{{ route('createPemesanan', ['type' => 'Cash']) }}" method="post" id="checkout-form">
                        @csrf
                        <input type="hidden" name="promo_code" id="hidden-promo-code" />
                        <button type="submit" id="pay-button" class="checkout-button">
                            <i class="fas fa-shield-alt"></i> Bayar Sekarang
                        </button>
                    </form>
                    
                    <form action="{{ route('createPemesanan', ['type' => 'Credit']) }}" method="post" id="credit-checkout-form">
                        @csrf
                        <input type="hidden" name="promo_code" id="hidden-promo-code-credit" />
                        <button type="submit" id="credit-pay-button" class="checkout-button" style="background: linear-gradient(135deg, var(--accent) 0%, #059669 100%); box-shadow: 0 4px 15px rgba(16, 185, 129, 0.25);">
                            <i class="fas fa-calendar-alt"></i> Bayar via Credit (21 Hari)
                        </button>
                    </form>
                </div>

                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const promoInput = document.getElementById('promo-input');
                        const applyPromoBtn = document.getElementById('apply-promo-btn');
                        const promoStatusMsg = document.getElementById('promo-status-msg');
                        const summaryDetails = document.querySelector('.summary-details');
                        const totalAmountEl = document.querySelector('.total-amount');
                        const hiddenPromoInput = document.getElementById('hidden-promo-code');

                        const originalTotal = {{ $total }};
                        let isPromoApplied = false;

                        // Quick input focus styles
                        promoInput.addEventListener('focus', function() {
                            this.style.borderColor = 'var(--primary)';
                            this.style.background = '#fff';
                            this.style.boxShadow = '0 0 0 3px rgba(37, 99, 235, 0.1)';
                        });
                        promoInput.addEventListener('blur', function() {
                            if (!isPromoApplied) {
                                this.style.borderColor = 'var(--border-color)';
                                this.style.background = '#f8fafc';
                            }
                            this.style.boxShadow = 'none';
                        });

                        applyPromoBtn.addEventListener('click', function() {
                            if (isPromoApplied) {
                                // Cancel promo
                                isPromoApplied = false;
                                promoInput.value = "";
                                promoInput.disabled = false;
                                promoInput.style.borderColor = 'var(--border-color)';
                                promoInput.style.background = '#f8fafc';
                                hiddenPromoInput.value = "";
                                const hiddenPromoInputCredit = document.getElementById('hidden-promo-code-credit');
                                if (hiddenPromoInputCredit) hiddenPromoInputCredit.value = "";

                                applyPromoBtn.textContent = "Terapkan";
                                applyPromoBtn.style.background = "var(--primary-light)";
                                applyPromoBtn.style.color = "var(--primary)";
                                applyPromoBtn.style.borderColor = "rgba(37, 99, 235, 0.08)";

                                promoStatusMsg.style.display = "none";

                                // Remove promo row from summary
                                const promoRow = document.getElementById('promo-summary-row');
                                if (promoRow) promoRow.remove();

                                // Reset Total Bayar
                                totalAmountEl.textContent = "Rp " + originalTotal.toLocaleString('id-ID');
                                return;
                            }

                            const code = promoInput.value.trim().toUpperCase();
                            if (code === "") {
                                promoStatusMsg.textContent = "Silakan masukkan kode promo terlebih dahulu.";
                                promoStatusMsg.style.color = "var(--danger)";
                                promoStatusMsg.style.display = "block";
                                return;
                            }

                            // Validate codes
                            let discountPercent = 0;
                            if (code === 'SEHAT20') {
                                discountPercent = 0.20;
                            } else if (code === 'DISKON10') {
                                discountPercent = 0.10;
                            } else if (code === 'PROMO50') {
                                discountPercent = 0.50;
                            } else {
                                promoStatusMsg.innerHTML = '<i class="fas fa-times-circle"></i> Kode promo tidak valid atau kadaluarsa.';
                                promoStatusMsg.style.color = "var(--danger)";
                                promoStatusMsg.style.display = "block";
                                return;
                            }

                            // Apply promo calculations
                            isPromoApplied = true;
                            const promoDiscount = Math.round(originalTotal * discountPercent);
                            const newTotal = originalTotal - promoDiscount;
                            hiddenPromoInput.value = code;
                            const hiddenPromoInputCredit = document.getElementById('hidden-promo-code-credit');
                            if (hiddenPromoInputCredit) hiddenPromoInputCredit.value = code;

                            // Visual feedback
                            promoInput.disabled = true;
                            promoInput.style.background = '#f1f5f9';
                            promoInput.style.borderColor = '#cbd5e1';

                            applyPromoBtn.textContent = "Batal";
                            applyPromoBtn.style.background = "var(--danger-light)";
                            applyPromoBtn.style.color = "var(--danger)";
                            applyPromoBtn.style.borderColor = "rgba(239, 68, 68, 0.1)";

                            promoStatusMsg.innerHTML = `<i class="fas fa-check-circle" style="color: var(--accent);"></i> Voucher <strong>${code}</strong> berhasil digunakan! Potongan ${discountPercent * 100}%.`;
                            promoStatusMsg.style.color = "var(--accent)";
                            promoStatusMsg.style.display = "block";

                            // Insert Promo Discount Row in Cart Summary
                            let promoRow = document.getElementById('promo-summary-row');
                            if (!promoRow) {
                                promoRow = document.createElement('div');
                                promoRow.id = 'promo-summary-row';
                                promoRow.className = 'summary-row';
                                promoRow.style.color = 'var(--accent)';
                                promoRow.style.fontWeight = '700';

                                // Insert directly before the total row
                                const totalRow = document.querySelector('.summary-row.total-row');
                                summaryDetails.insertBefore(promoRow, totalRow);
                            }

                            promoRow.innerHTML = `
                                <span>Potongan Voucher (${code})</span>
                                <span>-Rp ${promoDiscount.toLocaleString('id-ID')}</span>
                            `;

                            // Update Total Bayar with recalculations
                            totalAmountEl.textContent = "Rp " + newTotal.toLocaleString('id-ID');
                        });
                    });
                </script>

                <!-- Shopee/Tokopedia style Trust Seals -->
                <div class="trust-badges-card">
                    <div class="trust-badge-item">
                        <i class="fas fa-lock"></i>
                        <span>Midtrans Secure Encrypted Checkout</span>
                    </div>
                    <div class="trust-badge-item">
                        <i class="fas fa-award"></i>
                        <span>100% Produk Kesehatan Asli BPOM</span>
                    </div>
                    <div class="trust-badge-item">
                        <i class="fas fa-shipping-fast"></i>
                        <span>Pengiriman Terproteksi Sistem Cold Chain</span>
                    </div>
                </div>
            </aside>
        </div>
        @endif
    </main>

    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
    <script>
        const payButton = document.getElementById('pay-button');
        const creditPayButton = document.getElementById('credit-pay-button');

        function disableBothButtons() {
            if (payButton) payButton.disabled = true;
            if (creditPayButton) creditPayButton.disabled = true;
        }

        function enableBothButtons() {
            if (payButton) payButton.disabled = false;
            if (creditPayButton) creditPayButton.disabled = false;
        }

        const checkoutForm = document.getElementById('checkout-form');
        if (checkoutForm) {
            checkoutForm.addEventListener('submit', function(e) {
                e.preventDefault();
                disableBothButtons();

                fetch("{{ route('createPemesanan', ['type' => 'Cash']) }}", {
                        method: "POST",
                        headers: {
                            "X-CSRF-TOKEN": "{{ csrf_token() }}",
                            "Content-Type": "application/json"
                        },
                        body: JSON.stringify({
                            payment_method: 'online',
                            promo_code: document.getElementById('hidden-promo-code').value
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.snapToken) {
                            const triggerSnap = (token) => {
                                window.snap.pay(token, {
                                    onSuccess: function(result) {
                                        alert('Pembayaran Berhasil! Pesanan Anda sedang diproses.');
                                        window.location.href = "{{ route('pemesanan') }}";
                                    },
                                    onPending: function(result) {
                                        alert('Menunggu pembayaran...');
                                        window.location.reload();
                                    },
                                    onError: function(result) {
                                        alert('Pembayaran gagal!');
                                        enableBothButtons();
                                    },
                                    onClose: function() {
                                        alert('Pembayaran Cash harus diselesaikan. Silakan lanjutkan pembayaran Anda.');
                                        triggerSnap(token);
                                    }
                                });
                            };
                            triggerSnap(data.snapToken);
                        } else {
                            alert('Gagal mengambil token pembayaran');
                            enableBothButtons();
                        }
                    })
                    .catch(error => {
                        console.error(error);
                        enableBothButtons();
                    });
            });
        }

        const creditCheckoutForm = document.getElementById('credit-checkout-form');
        if (creditCheckoutForm) {
            creditCheckoutForm.addEventListener('submit', function(e) {
                e.preventDefault();
                disableBothButtons();

                fetch("{{ route('createPemesanan', ['type' => 'Credit']) }}", {
                        method: "POST",
                        headers: {
                            "X-CSRF-TOKEN": "{{ csrf_token() }}",
                            "Content-Type": "application/json"
                        },
                        body: JSON.stringify({
                            payment_method: 'credit',
                            promo_code: document.getElementById('hidden-promo-code-credit').value
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success && data.redirect) {
                            alert(data.message || 'Pemesanan via Credit 21 Hari berhasil dibuat!');
                            window.location.href = data.redirect;
                        } else {
                            alert('Gagal memproses pemesanan credit.');
                            enableBothButtons();
                        }
                    })
                    .catch(error => {
                        console.error(error);
                        enableBothButtons();
                    });
            });
        }
    </script>
</body>

</html>