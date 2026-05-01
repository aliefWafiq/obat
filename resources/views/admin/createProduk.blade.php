<h1>CREATE PRODUK</h1>
<a href="{{ route('dashboard') }}">Back to Dashboard</a>

<form action="/produk/create" method="POST" enctype="multipart/form-data">
    @csrf
    <label for="gambar">Gambar:</label>
    <input type="file" id="gambar" name="gambar">

    <label for="namaProduk">Nama Produk:</label>
    <input type="text" id="namaProduk" name="namaProduk">

    <label for="harga">Harga:</label>
    <input type="number" id="harga" name="harga">

    <label for="stok">Stok:</label>
    <input type="number" id="stok" name="stok">

    <button type="submit">Create</button>
</form>