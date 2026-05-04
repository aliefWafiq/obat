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
<form action="{{ route('createPemesanan') }}" method="post">
    @csrf
    <button type="submit">Checkout</button>
</form>