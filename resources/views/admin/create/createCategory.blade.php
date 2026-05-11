<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: Arial, sans-serif;
    }

    body {
        background: #f3f4f6;
        min-height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 20px;
    }

    .category-container {
        width: 100%;
        max-width: 450px;
        background: white;
        border-radius: 20px;
        padding: 35px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.05);
    }

    .category-container h1 {
        font-size: 32px;
        color: #111827;
        margin-bottom: 10px;
    }

    .back-btn {
        display: inline-block;
        margin-bottom: 30px;
        text-decoration: none;
        color: #6b7280;
        transition: 0.3s;
        font-size: 14px;
    }

    .back-btn:hover {
        color: #111827;
    }

    .form-group {
        margin-bottom: 20px;
    }

    label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        color: #111827;
    }

    input {
        width: 100%;
        padding: 14px;
        border-radius: 12px;
        border: 1px solid #d1d5db;
        background: #f9fafb;
        outline: none;
        transition: 0.3s;
    }

    input:focus {
        border-color: #111827;
        background: white;
    }

    button {
        width: 100%;
        padding: 14px;
        border: none;
        border-radius: 12px;
        background: #111827;
        color: white;
        font-weight: bold;
        font-size: 15px;
        cursor: pointer;
        transition: 0.3s;
    }

    button:hover {
        opacity: 0.9;
    }
</style>

<div class="category-container">

    <h1>CREATE CATEGORY</h1>

    <a href="{{ route('dashboard') }}" class="back-btn">
        ← Back to Dashboard
    </a>

    <form action="/category/create" method="POST" enctype="multipart/form-data">

        @csrf

        <div class="form-group">
            <label for="namaCategory">Nama Kategori:</label>

            <input type="text"
                   id="namaCategory"
                   name="namaCategory"
                   placeholder="Masukkan nama kategori">
        </div>

        <button type="submit">
            Create Category
        </button>

    </form>

</div>
```
