<h1>HOME</h1>
<a href="{{ route('logOut') }}">Logout</a>
@foreach ($produk as $e)
<div>
    <img src="{{ asset('storage/' . $e->gambar) }}" alt="{{ $e->namaProduk }}" width="100">
    <p>{{ $e->namaProduk }}</p>
    <p>{{ $e->harga }}</p>
</div>
@endforeach