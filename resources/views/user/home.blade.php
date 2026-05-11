@extends('layouts.mainLayout')
@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,300;1,400&family=DM+Sans:ital,wght@0,300;0,400;0,500;1,300&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('style/product.css') }}" />
@endpush
@section('nav')
<div class="search-box">
    <svg class="search-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <circle cx="11" cy="11" r="8" />
        <path d="m21 21-4.35-4.35" />
    </svg>
    <input type="text" id="search-input" placeholder="Cari produk..." class="search-input" />
</div>
@endsection
@section('content')
<!-- HERO -->
<section class="hero">
    <span class="hero-label">Produk</span>
    <h1>Katalog <em>Unggulan</em></h1>
    <p>Produk kesehatan terbaik dengan kualitas terjamin dan harga terpercaya.</p>
</section>

<!-- CATALOG -->
<section class="catalog">
    <div class="catalog-header">
        <div>
            <span class="eyebrow">Koleksi Kami</span>
            <h2 class="catalog-h2" id="catalog-title">Semua <em>Produk</em></h2>
        </div>
    </div>

    <!-- FILTER TABS -->
    <div class="filter-tabs" id="filter-tabs">
        <button class="tab active" data-cat="semua">Semua</button>
        @foreach ($categories as $e)
            <button class="tab" data-cat="{{ $e->id }}">{{ $e->namaCategory }}</button>
        @endforeach
    </div>

    <!-- SORT ROW -->
    <div class="sort-row">
        <span id="result-count"></span>
        <select class="sort-select" id="sort-select">
            <option value="default">Terpopuler</option>
            <option value="price-asc">Harga: Rendah ke Tinggi</option>
            <option value="price-desc">Harga: Tinggi ke Rendah</option>
            <option value="newest">Terbaru</option>
        </select>
    </div>

    <!-- PRODUCT GRID -->
    <div class="product-grid" id="product-grid">
        @foreach ($produk as $e)
        <form action="{{ route('masukKeranjang')}}" method="POST" class="product-card" data-id="{{ $e->idCategory }}">
            @csrf
            <div class="card-img-wrap">
                <div class="card-img-placeholder">
                    <img src="{{ asset('storage/' . $e->gambar) }}" alt="{{ $e->namaProduk }}" class="card-img">
                </div>
                @if ($e->stok == 0)
                <div class="card-overlay">Habis</div>
                @else
                <button type="submit" class="card-overlay" style="cursor: pointer;">Tambah ke Keranjang</button>
                @endif
            </div>
            <div class="card-body">
                <div class="card-name">{{ $e->namaProduk }}</div>
                <div class="card-desc">{{ $e->deskripsi }}</div>
                <div class="card-footer">
                    <div>
                        <span class="card-price"><b>Harga :</b> {{ number_format($e->harga, 0, ',', '.') }}</span>
                    </div>
                    <input type="hidden" name="produk_id" value="{{ $e->id }}">
                </div>
                @if ($e->stok == 0)
                <div class="">Stok Habis</div>
                @else
                <div class="qty-box">
                    <button type="button" class="qty-btn minus">-</button>

                    <input type="number" 
                        name="jumlah" 
                        class="qty-input"
                        min="1" 
                        value="1">

                    <button type="button" class="qty-btn plus">+</button>
                </div>
                @endif
            </div>
        </form>
        @endforeach
    </div>

    <!-- PAGINATION -->
    <div class="pagination">
        <button class="page-btn active">1</button>
        <button class="page-btn">2</button>
        <button class="page-btn">3</button>
        <button class="page-btn">›</button>
    </div>
</section>

<!-- FOOTER -->
<footer>
    <p><strong><em>ebat</em>kita.</strong> &nbsp;—&nbsp; Distribusi Obat Terpercaya &copy; 2026</p>
</footer>
@endsection
@push('scripts')
<script src="{{ asset('js/product.js') }}"></script>
@endpush