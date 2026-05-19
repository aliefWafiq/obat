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
<!-- PROGRAM SLIDER -->
@if(isset($BuatProgram) && $BuatProgram->count() > 0)
<section class="program-slider-section">
    <div class="slider-container">
        <div class="slider-wrapper">
            @foreach($BuatProgram as $index => $program)
            <div class="program-slide {{ $index === 0 ? 'active' : '' }}">
                <div class="slide-content">
                    <span class="program-badge"><i class="fas fa-ticket"></i> {{ $program->tagProgram }}</span>
                    <h2 class="program-title">{{ $program->judul }}</h2>
                    <p class="program-desc">{{ $program->deskripsi }}</p>
                    <a href="#catalog-title" class="btn-program">Belanja Sekarang</a>
                </div>
                <div class="slide-image" style="background-image: url('{{ asset('storage/' . $program->gambar) }}')"></div>
            </div>
            @endforeach
        </div>
        
        @if($BuatProgram->count() > 1)
        <!-- Controls -->
        <button class="slider-nav prev-btn" aria-label="Previous Slide"><i class="fas fa-chevron-left"></i></button>
        <button class="slider-nav next-btn" aria-label="Next Slide"><i class="fas fa-chevron-right"></i></button>
        
        <!-- Dots -->
        <div class="slider-dots">
            @foreach($BuatProgram as $index => $program)
            <span class="dot {{ $index === 0 ? 'active' : '' }}" data-index="{{ $index }}"></span>
            @endforeach
        </div>
        @endif
    </div>
</section>
@endif

<!-- CATALOG -->
<section class="catalog">
    <div class="catalog-header">
        <div>
            <span class="eyebrow">Obat Kita</span>
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
        <div class="product-card" data-id="{{ $e->idCategory }}">
            <div class="card-img-wrap">
                <div class="card-img-placeholder">
                    <img src="{{ asset('storage/' . $e->gambar) }}" alt="{{ $e->namaProduk }}" class="card-img">
                </div>
                @if ($e->stok == 0)
                <div class="card-overlay">Habis</div>
                @else
                <button type="button" class="card-overlay open-drawer-btn" style="cursor: pointer;"
                    data-id="{{ $e->id }}"
                    data-name="{{ $e->namaProduk }}"
                    data-desc="{{ $e->deskripsi }}"
                    data-harga="Rp {{ number_format($e->harga, 0, ',', '.') }}"
                    data-raw-harga="{{ $e->harga }}"
                    data-stok="{{ $e->stok }}"
                    data-gambar="{{ asset('storage/' . $e->gambar) }}">
                    Tambah ke Keranjang
                </button>
                @endif
            </div>
            <div class="card-body">
                <span class="card-category-label">{{ $e->category->namaCategory ?? 'Obat & Kesehatan' }}</span>
                <div class="card-name" title="{{ $e->namaProduk }}">{{ $e->namaProduk }}</div>
                <div class="card-desc">{{ $e->deskripsi }}</div>
                <div class="card-footer">
                    <div>
                        <span class="card-price">Rp {{ number_format($e->harga, 0, ',', '.') }}</span>
                    </div>
                    @if ($e->stok > 0)
                    <span class="card-stock-info">Stok: <b>{{ $e->stok }}</b></span>
                    @else
                    <span class="stok-habis-label">Habis</span>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- PAGINATION -->
    <div class="pagination">
        <button class="page-btn active">1</button>
        <button class="page-btn">2</button>
        <button class="page-btn">3</button>
        <button class="page-btn">›</button>
    </div>

    <!-- Shopee-style Slide-up Add to Cart Drawer -->
    <div id="cart-drawer-overlay" class="cart-drawer-overlay">
        <div id="cart-drawer" class="cart-drawer">
            <!-- Close Button -->
            <button type="button" class="drawer-close-btn">&times;</button>
            
            <form id="drawer-form" action="{{ route('masukKeranjang') }}" method="POST">
                @csrf
                <input type="hidden" name="produk_id" id="drawer-product-id">
                
                <!-- Product Information -->
                <div class="drawer-product-info">
                    <div class="drawer-img-wrap">
                        <img id="drawer-product-img" src="" alt="">
                    </div>
                    <div class="drawer-details">
                        <h3 id="drawer-product-name">Nama Produk</h3>
                        <p id="drawer-product-desc">Deskripsi singkat produk</p>
                        <div class="drawer-price-stock">
                            <span id="drawer-product-price" class="drawer-price">Rp 0</span>
                            <span id="drawer-product-stock" class="drawer-stock">Stok: 0</span>
                        </div>
                    </div>
                </div>
                
                <!-- Quantity Selector Row -->
                <div class="drawer-qty-row">
                    <span class="qty-label">Jumlah</span>
                    <div class="qty-box">
                        <button type="button" class="qty-btn minus">-</button>
                        <input type="number" name="jumlah" class="qty-input" id="drawer-qty-input" min="1" value="1" readonly>
                        <button type="button" class="qty-btn plus">+</button>
                    </div>
                </div>
                
                <!-- Action Buttons -->
                <div class="drawer-actions">
                    <button type="submit" class="drawer-btn submit-btn">Masukkan Keranjang</button>
                </div>
            </form>
        </div>
    </div>
</section>

<!-- FOOTER -->
<footer>
    <p><strong><em>obat</em>kita.</strong> &nbsp;—&nbsp; Distribusi Obat Terpercaya &copy; 2026</p>
</footer>
@endsection
@push('scripts')
<script src="{{ asset('js/product.js') }}"></script>
@endpush