@extends('layouts.adminLayout')
@section('content')
<div class="main-content">
    <header class="header">
        <div class="header-left">
            <button class="menu-toggle">
                <i class="fas fa-bars"></i>
            </button>
            <h1 id="page-title">Edit Produk</h1>
        </div>
    </header>
    <section id="dashboard" class="content-section active" style="display: flex; justify-content: center;">
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div style="max-width: 600px; background: #fff; border-radius: 16px; padding: 2rem; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);">
            <form action="/produk/update/{{ $produk->id }}" method="POST" enctype="multipart/form-data" class="admin-form">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="gambar">
                        <i class="fas fa-image"></i> Gambar Produk
                    </label>
                    <div style="border: 2px dashed #e9ecef; border-radius: 8px; padding: 2rem; text-align: center; cursor: pointer;" id="upload-area">
                        <input type="file" id="gambar" name="gambar" style="display: none;" accept="image/*">
                        <div id="upload-placeholder">
                            <i class="fas fa-cloud-upload-alt" style="font-size: 2rem; color: #00d4aa; margin-bottom: 1rem; display: block;"></i>
                            <p>Klik untuk memilih atau drag gambar ke sini</p>
                            <small style="color: #999;">Format: JPG, PNG (Max 5MB)</small>
                        </div>
                        @if($produk->gambar)
                        <img id="image-preview" src="{{ asset('storage/' . $produk->gambar) }}" style="max-width: 200px; max-height: 200px; margin-top: 1rem; border-radius: 8px;">
                        @else
                        <img id="image-preview" style="max-width: 200px; max-height: 200px; margin-top: 1rem; display: none; border-radius: 8px;">
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <label for="namaProduk">
                        <i class="fas fa-pills"></i> Nama Produk <span style="color: #ff4757;">*</span>
                    </label>
                    <input type="text" id="namaProduk" name="namaProduk" required placeholder="Masukkan nama produk" value="{{ $produk->namaProduk }}">
                </div>

                <div class="form-group">
                    <label for="deskripsi">
                        <i class="fas fa-align-left"></i> Deskripsi
                    </label>
                    <textarea id="deskripsi" name="deskripsi" placeholder="Masukkan deskripsi produk" style="min-height: 120px; width: 100%; padding: 1rem; border: 2px solid #e9ecef; border-radius: 8px; font-family: inherit; font-size: 1rem; resize: vertical;">{{ $produk->deskripsi }}</textarea>
                </div>

                <div class="form-group">
                    <label for="idCategory">
                        <i class="fas fa-tags"></i> Kategori <span style="color: #ff4757;">*</span>
                    </label>
                    <select id="idCategory" name="idCategory" required>
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ $produk->idCategory == $category->id ? 'selected' : '' }}>{{ $category->namaCategory }}</option>
                        @endforeach
                    </select>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                    <div class="form-group">
                        <label for="harga">
                            <i class="fas fa-tag"></i> Harga (Rp) <span style="color: #ff4757;">*</span>
                        </label>
                        <input type="number" id="harga" name="harga" required placeholder="0" value="{{ $produk->harga }}" min="0">
                    </div>

                    <div class="form-group">
                        <label for="stok">
                            <i class="fas fa-boxes"></i> Stok <span style="color: #ff4757;">*</span>
                        </label>
                        <input type="number" id="stok" name="stok" required placeholder="0" value="{{ $produk->stok }}" min="0">
                    </div>
                </div>

                <div class="form-actions" style="margin-top: 2rem;">
                    <a href="{{ route('listProduk') }}" class="btn btn-secondary" style="background: #f8f9fa; color: #666; border: 2px solid #e9ecef; text-decoration: none;">
                        <i class="fas fa-arrow-left"></i> Batal
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-check"></i> Update Produk
                    </button>
                </div>
            </form>
        </div>
    </section>
</div>

<style>
    .alert {
        padding: 1rem;
        border-radius: 8px;
        margin-bottom: 2rem;
    }
    .alert-danger {
        background: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }
    .alert ul {
        margin: 0;
        padding-left: 1.5rem;
    }
    #upload-area:hover {
        background: #f8f9fa;
    }
    .btn-secondary {
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }
    .btn-primary {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }
</style>

<script src="{{ asset('js/edit-produk.js') }}"></script>
@endsection