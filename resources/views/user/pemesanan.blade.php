<h1>Pemesanan</h1>
<a href="{{ route('home') }}">Kembali ke Beranda</a>
@foreach ($pemesanan as $item)
    <div class="pemesanan-item">
        <h2>Pesanan #{{ $item->kodePemesanan     }}</h2>
        <p>Total Harga: Rp {{ number_format($item->totalHarga, 0, ',', '.') }}</p>
        <p>Status: {{ $item->status }}</p>
        <p>Estimasi Pembayaran: {{ $item->estimasipembayaran }}</p>
        <p>Estimasi Pengiriman: {{ $item->estimasiPengantaran }}</p>
    </div>
@endforeach