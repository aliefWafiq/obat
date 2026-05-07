<h1>KERANJANG</h1>
@if(session('success'))
<p>{{ session('success') }}</p>
@elseif(session('error'))
<p>{{ session('error') }}</p>
@endif
<a href="{{ route('home') }}">Home</a>
@foreach ($items as $e)
<p>{{ $e->produk->namaProduk }} - {{ $e->jumlah }}</p>
<form action="{{ route('removeItemKeranjang', ['id' => $e->id]) }}" method="post">
    @csrf
    @method('DELETE')
    <button type="submit" onclick="return confirm('Hapus item dari keranjang?')">Hapus</button>
</form>
@endforeach
<p>Total: {{ $total }}</p>
<form action="{{ route('createPemesanan') }}" method="post" id="checkout-form">
    @csrf
    <button type="submit" id="pay-button">Checkout</button>
</form>

<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
<script>
    const checkoutForm = document.getElementById('checkout-form');

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
</script>