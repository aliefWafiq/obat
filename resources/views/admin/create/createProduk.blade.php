```blade
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: Arial, sans-serif;
    }

    body {
        background: #f3f4f6;
        color: #111827;
        padding: 30px;
    }

    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
    }

    .page-header h1 {
        font-size: 36px;
        font-weight: bold;
    }

    .back-btn {
        text-decoration: none;
        background: white;
        padding: 12px 18px;
        border-radius: 12px;
        color: #111827;
        border: 1px solid #e5e7eb;
        transition: 0.3s;
    }

    .back-btn:hover {
        background: #111827;
        color: white;
    }

    .main-container {
        display: flex;
        gap: 25px;
        align-items: flex-start;
    }

    /* LEFT SIDE */
    .produk-list {
        flex: 2;
        background: white;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 5px 20px rgba(0,0,0,0.05);
    }

    .table-header {
        padding: 25px;
        border-bottom: 1px solid #e5e7eb;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .table-header h2 {
        font-size: 28px;
    }

    .total-box {
        background: #f9fafb;
        padding: 12px 20px;
        border-radius: 12px;
        border: 1px solid #e5e7eb;
        font-weight: bold;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th {
        text-align: left;
        padding: 20px;
        background: #fafafa;
        border-bottom: 1px solid #e5e7eb;
    }

    td {
        padding: 20px;
        border-bottom: 1px solid #f1f1f1;
        vertical-align: middle;
    }

    .produk-img {
        width: 70px;
        height: 70px;
        border-radius: 12px;
        object-fit: cover;
        background: #f3f4f6;
    }

    /* RIGHT SIDE */
    .create-box {
        flex: 1;
        background: white;
        border-radius: 20px;
        padding: 30px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        position: sticky;
        top: 20px;
    }

    .create-box h2 {
        margin-bottom: 25px;
        font-size: 30px;
    }

    form {
        display: flex;
        flex-direction: column;
        gap: 18px;
    }

    label {
        font-weight: 600;
        margin-bottom: 6px;
        display: block;
    }

    input,
    textarea,
    select {
        width: 100%;
        padding: 14px;
        border-radius: 12px;
        border: 1px solid #d1d5db;
        outline: none;
        background: #f9fafb;
        transition: 0.3s;
    }

    input:focus,
    textarea:focus,
    select:focus {
        border-color: #111827;
        background: white;
    }

    textarea {
        min-height: 120px;
        resize: vertical;
    }

    button {
        margin-top: 10px;
        padding: 15px;
        border: none;
        border-radius: 12px;
        background: #111827;
        color: white;
        font-size: 16px;
        font-weight: bold;
        cursor: pointer;
        transition: 0.3s;
    }

    button:hover {
        opacity: 0.9;
    }

    @media(max-width: 1000px) {
        .main-container {
            flex-direction: column;
        }

        .create-box {
            width: 100%;
            position: static;
        }
    }
</style>

<div class="page-header">
    <h1>Daftar Produk</h1>

    <a href="{{ route('dashboard') }}" class="back-btn">
        ← Back Dashboard
    </a>
</div>

<div class="main-container">

    <!-- LEFT -->
    <div class="produk-list">

        <div class="table-header">
            <h2>Daftar Produk</h2>

            <div class="total-box">
                Total: {{ count($categories) }}
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Gambar</th>
                    <th>Nama Produk</th>
                    <th>Kategori</th>
                    <th>Harga</th>
                    <th>Stok</th>
                </tr>
            </thead>

            <tbody>
                <!-- Contoh Dummy -->
                <tr>
                    <td>
                        <img src="https://via.placeholder.com/70"
                             class="produk-img">
                    </td>
                    <td>Produk Sample</td>
                    <td>Elektronik</td>
                    <td>Rp 100.000</td>
                    <td>20</td>
                </tr>

                <tr>
                    <td>
                        <img src="https://via.placeholder.com/70"
                             class="produk-img">
                    </td>
                    <td>Produk Kedua</td>
                    <td>Fashion</td>
                    <td>Rp 250.000</td>
                    <td>10</td>
                </tr>
            </tbody>
        </table>

    </div>

    <!-- RIGHT -->
    <div class="create-box">

        <h2>Create Produk</h2>

        <form action="/produk/create" method="POST" enctype="multipart/form-data">
            @csrf

            <div>
                <label for="gambar">Gambar:</label>
                <input type="file" id="gambar" name="gambar">
            </div>

            <div>
                <label for="namaProduk">Nama Produk:</label>
                <input type="text" id="namaProduk" name="namaProduk">
            </div>

            <div>
                <label for="deskripsi">Deskripsi:</label>
                <textarea id="deskripsi" name="deskripsi"></textarea>
            </div>

            <div>
                <label for="idCategory">Kategori:</label>

                <select id="idCategory" name="idCategory">
                    <option value="">Pilih Kategori</option>

                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">
                            {{ $category->namaCategory }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="harga">Harga:</label>
                <input type="number" id="harga" name="harga">
            </div>

            <div>
                <label for="stok">Stok:</label>
                <input type="number" id="stok" name="stok">
            </div>

            <button type="submit">
                Create Produk
            </button>

        </form>

    </div>

</div>
```
