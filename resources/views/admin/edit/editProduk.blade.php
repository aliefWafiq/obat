<h1>EDIT PRODUK</h1>
<a href="{{ route('dashboard') }}">Back to Dashboard</a>

<form action="/produk/update/{{ $produk->id }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <label for="gambar">Gambar:</label>
    <input type="file" id="gambar" name="gambar">

    <label for="namaProduk">Nama Produk:</label>
    <input type="text" id="namaProduk" name="namaProduk" value="{{ $produk->namaProduk }}">

    <label for="deskripsi">Deskripsi:</label>
    <textarea id="deskripsi" name="deskripsi">{{ $produk->deskripsi }}</textarea>

    <label for="idCategory">Kategori:</label>
    <select id="idCategory" name="idCategory">
        <option value="">Pilih Kategori</option>
        @foreach($categories as $category)
            <option value="{{ $category->id }}" {{ $produk->idCategory == $category->id ? 'selected' : '' }}>{{ $category->namaCategory }}</option>
        @endforeach
    </select>

    <label for="harga">Harga:</label>
    <input type="number" id="harga" name="harga" value="{{ $produk->harga }}">

    <label for="stok">Stok:</label>
    <input type="number" id="stok" name="stok" value="{{ $produk->stok }}">

    <button type="submit">Update</button>
</form>