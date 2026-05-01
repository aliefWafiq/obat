<h1>EDIT PRODUK</h1>
<a href="{{ route('dashboard') }}">Back to Dashboard</a>

<form action="/produk/update/{{ $produk->id }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <label for="gambar">Gambar:</label>
    <input type="file" id="gambar" name="gambar">

    <label for="namaProduk">Nama Produk:</label>
    <input type="text" id="namaProduk" name="namaProduk" value="{{ $produk->namaProduk }}">

    <label for="harga">Harga:</label>
    <input type="number" id="harga" name="harga" value="{{ $produk->harga }}">

    <label for="stok">Stok:</label>
    <input type="number" id="stok" name="stok" value="{{ $produk->stok }}">

    <button type="submit">Update</button>
</form>