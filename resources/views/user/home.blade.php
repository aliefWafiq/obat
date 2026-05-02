<h1>HOME</h1>
<a href="{{ route('logOut') }}">Logout</a>
<a href="{{ route('keranjang') }}">Keranjang</a>
@foreach ($produk as $e)
<div>
    <img src="{{ asset('storage/' . $e->gambar) }}" alt="{{ $e->namaProduk }}" width="100">
    <p>{{ $e->namaProduk }}</p>
    <p>{{ $e->harga }}</p>
    <form action="{{ route('masukKeranjang')}}" method="POST">
        @csrf
        <input type="hidden" name="produk_id" value="{{ $e->id }}">
        <input type="number" name="jumlah" min="1" value="1">
        <button type="submit">Tambah ke Keranjang</button>
    </form>
</div>
@endforeach