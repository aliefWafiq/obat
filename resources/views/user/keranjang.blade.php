<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Belanja - ObatKita</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            font-family: 'Poppins', sans-serif;
            background: #f5f7fb;
            color: #111827;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            background: #f5f7fb;
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

        .cart-page {
            max-width: 1160px;
            margin: 0 auto;
            padding: 2.5rem 1.25rem 3rem;
        }

        .cart-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 1rem;
            margin-bottom: 2rem;
            flex-wrap: wrap;
        }

        .cart-header h1 {
            margin: 0;
            font-size: clamp(2rem, 2.5vw, 2.6rem);
            letter-spacing: -0.03em;
        }

        .cart-header p {
            margin: 0.75rem 0 0;
            color: #6b7280;
            line-height: 1.7;
            max-width: 720px;
        }

        .btn-back {
            display: inline-flex;
            align-items: center;
            gap: 0.6rem;
            padding: 0.95rem 1.3rem;
            border-radius: 999px;
            background: #2563eb;
            color: #ffffff;
            border: none;
            cursor: pointer;
            transition: background 0.2s ease;
        }

        .btn-back:hover {
            background: #1d4ed8;
        }

        .alert-box {
            border-radius: 18px;
            padding: 1rem 1.25rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 15px 40px rgba(15, 23, 42, 0.06);
        }

        .alert-success {
            background: #dcfce7;
            color: #14532d;
        }

        .alert-error {
            background: #fee2e2;
            color: #7f1d1d;
        }

        .cart-grid {
            display: grid;
            grid-template-columns: 1.8fr 1fr;
            gap: 1.5rem;
        }

        .cart-list,
        .cart-summary {
            background: #ffffff;
            border-radius: 28px;
            padding: 1.85rem;
            box-shadow: 0 20px 50px rgba(15, 23, 42, 0.08);
        }

        .cart-section-title {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .cart-section-title h2 {
            margin: 0;
            font-size: 1.3rem;
        }

        .cart-section-title p {
            margin: 0;
            color: #6b7280;
            font-size: 0.95rem;
        }

        .cart-item {
            display: grid;
            grid-template-columns: 110px minmax(0, 1fr) auto;
            gap: 1rem;
            align-items: center;
            padding: 1.1rem 0;
            border-bottom: 1px solid #e5e7eb;
        }

        .cart-item:last-child {
            border-bottom: none;
        }

        .cart-item img {
            width: 100%;
            min-height: 120px;
            border-radius: 20px;
            object-fit: cover;
        }

        .cart-item-details {
            display: flex;
            flex-direction: column;
            gap: 0.45rem;
        }

        .cart-item-details h3 {
            margin: 0;
            font-size: 1.05rem;
        }

        .cart-item-details p {
            margin: 0;
            color: #4b5563;
            font-size: 0.95rem;
            line-height: 1.6;
        }

        .cart-item-meta {
            display: flex;
            flex-direction: column;
            gap: 0.85rem;
            align-items: flex-end;
        }

        .cart-qty {
            display: inline-flex;
            justify-content: center;
            min-width: 70px;
            border-radius: 999px;
            background: #f3f4f6;
            padding: 0.65rem 0.95rem;
            color: #111827;
            font-weight: 600;
        }

        .cart-price {
            font-weight: 700;
            color: #111827;
        }

        .btn-remove {
            border: none;
            border-radius: 999px;
            padding: 0.75rem 1rem;
            background: #fee2e2;
            color: #991b1b;
            cursor: pointer;
            transition: transform 0.2s ease;
        }

        .btn-remove:hover {
            transform: translateY(-1px);
        }

        .summary-line {
            display: flex;
            justify-content: space-between;
            gap: 0.75rem;
            margin-bottom: 1rem;
            color: #4b5563;
            font-size: 0.96rem;
        }

        .summary-total {
            display: flex;
            justify-content: space-between;
            gap: 0.75rem;
            font-size: 1.15rem;
            font-weight: 700;
            margin: 1.5rem 0;
        }

        .checkout-button {
            width: 100%;
            border: none;
            border-radius: 18px;
            background: #16a34a;
            color: #ffffff;
            padding: 1rem 1.15rem;
            font-size: 1rem;
            font-weight: 700;
            cursor: pointer;
            transition: background 0.2s ease;
        }

        .checkout-button:hover {
            background: #15803d;
        }

        .checkout-button:disabled {
            background: #94a3b8;
            cursor: not-allowed;
        }

        .empty-cart {
            text-align: center;
            padding: 3rem 1.5rem;
        }

        .empty-cart i {
            font-size: 3rem;
            color: #2563eb;
            margin-bottom: 1rem;
        }

        .empty-cart h2 {
            margin: 0 0 0.75rem;
            font-size: 1.75rem;
        }

        .empty-cart p {
            margin: 0 0 1.5rem;
            color: #6b7280;
            line-height: 1.7;
        }

        .btn-primary {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.95rem 1.3rem;
            background: #2563eb;
            color: #ffffff;
            border: none;
            border-radius: 999px;
            cursor: pointer;
            transition: background 0.2s ease;
        }

        .btn-primary:hover {
            background: #1d4ed8;
        }

        @media (max-width: 980px) {
            .cart-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 640px) {
            .cart-item {
                grid-template-columns: 1fr;
            }

            .cart-item-meta {
                align-items: flex-start;
            }
        }
    </style>
</head>

<body>
    <main class="cart-page">
        <section class="cart-header">
            <div>
                <h1>Keranjang Belanja</h1>
                <p>Periksa pesanan Anda sebelum checkout. Tambahkan atau hapus item, lalu lanjutkan ke pembayaran dengan mudah.</p>
            </div>
            <a href="{{ route('home') }}" class="btn-back">← Lanjut Belanja</a>
        </section>

        @if(session('success'))
        <div class="alert-box alert-success">{{ session('success') }}</div>
        @elseif(session('error'))
        <div class="alert-box alert-error">{{ session('error') }}</div>
        @endif

        @if($items->isEmpty())
        <section class="cart-list empty-cart">
            <i class="fas fa-shopping-cart"></i>
            <h2>Keranjang Anda kosong</h2>
            <p>Tambahkan produk ke keranjang untuk melihat detail belanja dan melanjutkan checkout.</p>
            <a href="{{ route('home') }}" class="btn-primary">Mulai Belanja</a>
        </section>
        @else
        <div class="cart-grid">
            <section class="cart-list">
                <div class="cart-section-title">
                    <div>
                        <h2>Item di Keranjang</h2>
                        <p>{{ $items->count() }} barang siap dibayar.</p>
                    </div>
                </div>

                @foreach ($items as $item)
                <article class="cart-item">
                    <img src="{{ asset('storage/' . $item->produk->gambar) }}" alt="{{ $item->produk->namaProduk }}">
                    <div class="cart-item-details">
                        <h3>{{ $item->produk->namaProduk }}</h3>
                        <p>{{ \Illuminate\Support\Str::limit($item->produk->deskripsi, 100, '...') }}</p>
                        <p style="font-weight: 700; color: #111827;">Rp {{ number_format($item->produk->harga, 0, ',', '.') }}</p>
                    </div>
                    <div class="cart-item-meta">
                        <span class="cart-qty">Qty: {{ $item->jumlah }}</span>
                        <span class="cart-price">Subtotal: Rp {{ number_format($item->produk->harga * $item->jumlah, 0, ',', '.') }}</span>
                        <form action="{{ route('removeItemKeranjang', ['id' => $item->id]) }}" method="post" style="margin: 0;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-remove" onclick="return confirm('Hapus item dari keranjang?')">Hapus</button>
                        </form>
                    </div>
                </article>
                @endforeach
            </section>

            <aside class="cart-summary">
                <div class="cart-section-title">
                    <h2>Ringkasan Belanja</h2>
                </div>
                <div class="summary-line">
                    <span>Jumlah item</span>
                    <span>{{ $items->sum('jumlah') }}</span>
                </div>
                <div class="summary-line">
                    <span>Subtotal</span>
                    <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                </div>
                <div class="summary-line">
                    <span>Estimasi ongkos kirim</span>
                    <span>Gratis</span>
                </div>
                <div class="summary-total">
                    <span>Total bayar</span>
                    <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                </div>
                <form action="{{ route('createPemesanan') }}" method="post" id="checkout-form">
                    @csrf
                    <button type="submit" id="pay-button" class="checkout-button">Checkout Sekarang</button>
                </form>
                <p style="margin-top: 1rem; color: #6b7280; font-size: 0.95rem; line-height: 1.7;">Setelah klik checkout, Anda akan diarahkan ke proses pembayaran Midtrans untuk menyelesaikan pesanan.</p>
            </aside>
        </div>
        @endif
    </main>

    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
    <script>
        const checkoutForm = document.getElementById('checkout-form');
        if (checkoutForm) {
            checkoutForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const button = document.getElementById('pay-button');
                button.disabled = true;

                fetch("{{ route('createPemesanan') }}", {
                        method: "POST",
                        headers: {
                            "X-CSRF-TOKEN": "{{ csrf_token() }}",
                            "Content-Type": "application/json"
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.snapToken) {
                            window.snap.pay(data.snapToken, {
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
                                    button.disabled = false;
                                },
                                onClose: function() {
                                    alert('Anda menutup popup sebelum bayar.');
                                    button.disabled = false;
                                    window.location.href = "{{ route('pemesanan') }}";
                                }
                            });
                        } else {
                            alert('Gagal mengambil token pembayaran');
                            button.disabled = false;
                        }
                    })
                    .catch(error => {
                        console.error(error);
                        button.disabled = false;
                    });
            });
        }
    </script>
</body>

</html>