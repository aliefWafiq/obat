<h1>DASHBOARD</h1>
<p>{{ session('success') }}</p>
<a href="{{ route('logOut') }}">Logout</a>
<a href="{{ route('viewCreateProduk') }}">Create Produk</a>
@foreach ($produk as $item)
<div>
    <p>{{ $item->namaProduk }} - Harga: {{ $item->harga }} - Stok: {{ $item->stok }}</p>
    <a href="{{ route('viewEditProduk', $item->id) }}">Edit</a>
    <a href="{{ route('deleteProduk', $item->id) }}" onclick="return confirm('Are you sure?')">Delete</a>
</div>
@endforeach