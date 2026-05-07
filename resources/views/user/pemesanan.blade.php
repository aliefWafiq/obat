<h1>Pemesanan</h1>
@if (session('success'))
<p>{{ session('success') }}</p>
@elseif (session('error'))
<p>{{ session('error') }}</p>
@endif
<a href="{{ route('home') }}">Kembali ke Beranda</a>
@foreach ($pemesanan as $item)
<div class="pemesanan-item">
    <h2>Pesanan #{{ $item->kodePemesanan     }}</h2>
    <p>Total Harga: Rp {{ number_format($item->totalHarga, 0, ',', '.') }}</p>
    <p>Status: {{ $item->status }}</p>
    <p>Estimasi Pembayaran: {{ $item->estimasipembayaran }}</p>
    <p>Estimasi Pengiriman: {{ $item->estimasiPengantaran }}</p>
    @if ($item->status == 'Pending')
    <a href="{{ route('bayarUlang', $item->id) }}" class="btn-bayar">
        Bayar Sekarang
    </a>
    @endif
</div>
@endforeach