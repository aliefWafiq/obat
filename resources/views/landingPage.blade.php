@extends('layouts.mainLayout')
@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('style/style.css') }}" />
@endpush
@section('content')
<!-- Hero Section -->
<section class="hero" id="home">
    <div class="hero-slider">
        @foreach($BuatProgram as $e)
        <div class="slide active" data-slide="0">
            <div class="slide-bg" style="background-image: url('{{ asset('storage/' . $e->gambar) }}')"></div>
            <div class="hero-content">
                <span class="hero-tag">{{ $e->tagProgram }}</span>
                <h1>{{ $e->judul }}</h1>
                <p>{{ $e->deskripsi }}</p>
                <a href="#services" class="btn-primary">Jelajahi Layanan</a>
            </div>
        </div>
        @endforeach
    </div>

    <div class="slider-controls">
        <button class="slider-dot active" data-index="0"></button>
        <button class="slider-dot" data-index="1"></button>
        <button class="slider-dot" data-index="2"></button>
    </div>

    <div class="scroll-indicator">
        <div class="scroll-line"></div>
    </div>
</section>

<!-- Trust Badges -->
<section class="trust-badges">
    <div class="container">
        <div class="badge-item">
            <span class="badge-number">500K+</span>
            <span class="badge-label">Pelanggan Puas</span>
        </div>
        <div class="badge-divider"></div>
        <div class="badge-item">
            <span class="badge-number">10K+</span>
            <span class="badge-label">Produk Tersedia</span>
        </div>
        <div class="badge-divider"></div>
        <div class="badge-item">
            <span class="badge-number">24/7</span>
            <span class="badge-label">Layanan Aktif</span>
        </div>
        <div class="badge-divider"></div>
        <div class="badge-item">
            <span class="badge-number">100%</span>
            <span class="badge-label">Produk Original</span>
        </div>
    </div>
</section>

<!-- About Section -->
<section class="about" id="about">
    <div class="container">
        <div class="about-grid">
            <div class="about-image reveal-left">
                <img src="{{ asset('img/dokterai.png') }}" alt="Obatkita Team" />
                <div class="image-accent"></div>
            </div>

            <div class="about-content reveal-right">
                <span class="section-tag">Tentang Kami</span>
                <h2>Partner Kesehatan Terpercaya Sejak 2015</h2>
                <p class="lead">
                    Obatkita hadir sebagai solusi distribusi farmasi modern yang
                    mengedepankan kualitas, kecepatan, dan kepercayaan.
                </p>
                <p>
                    Dengan jaringan distribusi yang mencakup seluruh Indonesia,
                    kami memastikan setiap produk kesehatan sampai ke tangan Anda
                    dengan kondisi optimal dan harga yang kompetitif.
                </p>
                <div class="about-features">
                    <div class="feature">
                        <div class="feature-icon">✓</div>
                        <span>Distributor Resmi BPOM</span>
                    </div>
                    <div class="feature">
                        <div class="feature-icon">✓</div>
                        <span>Sistem Cold Chain Terintegrasi</span>
                    </div>
                    <div class="feature">
                        <div class="feature-icon">✓</div>
                        <span>Pengiriman Express Nationwide</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Services Section -->
<section class="services" id="services">
    <div class="container">
        <div class="section-header">
            <span class="section-tag">Layanan</span>
            <h2>Solusi Lengkap untuk Kebutuhan Kesehatan</h2>
            <p>Layanan profesional yang dirancang untuk kemudahan Anda</p>
        </div>

        <div class="services-grid">
            <div class="service-card">
                <div class="service-number">01</div>
                <div class="service-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <path d="M8.5 14.5A2.5 2.5 0 0011 12c0-1.38-.5-2-1-3-1.072-2.143-.224-4.054 2-6 .5 2.5 2 4.9 4 6.5 2 1.6 3 3.5 3 5.5a7 7 0 11-14 0c0-1.153.433-2.294 1-3a2.5 2.5 0 002.5 2.5z" />
                    </svg>
                </div>
                <h3>Konsultasi Gratis</h3>
                <p>Tim apoteker berpengalaman siap memberikan rekomendasi obat yang tepat sesuai kebutuhan Anda.</p>
            </div>

            <div class="service-card">
                <div class="service-number">02</div>
                <div class="service-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <rect x="1" y="3" width="15" height="13" rx="2" />
                        <path d="M16 8h4l3 3v5a2 2 0 01-2 2h-1" />
                        <circle cx="5.5" cy="18.5" r="2.5" />
                        <circle cx="18.5" cy="18.5" r="2.5" />
                    </svg>
                </div>
                <h3>Pengiriman Express</h3>
                <p>Same-day delivery untuk area Jabodetabek dan pengiriman cepat ke seluruh Indonesia.</p>
            </div>

            <div class="service-card">
                <div class="service-number">03</div>
                <div class="service-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
                        <path d="M9 12l2 2 4-4" />
                    </svg>
                </div>
                <h3>Jaminan Original</h3>
                <p>Semua produk dijamin 100% asli dari produsen dan distributor resmi berlisensi.</p>
            </div>

            <div class="service-card">
                <div class="service-number">04</div>
                <div class="service-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <circle cx="12" cy="12" r="10" />
                        <path d="M12 6v6l4 2" />
                    </svg>
                </div>
                <h3>Layanan 24 Jam</h3>
                <p>Customer support aktif sepanjang waktu untuk membantu kebutuhan darurat kesehatan Anda.</p>
            </div>
        </div>
    </div>
</section>

<!-- Products Section -->
<section class="products" id="products">
    <div class="container">
        <div class="section-header">
            <span class="section-tag">Produk</span>
            <h2>Katalog Unggulan</h2>
            <p>Produk kesehatan terbaik dengan kualitas terjamin</p>
        </div>

        <div class="product-categories">
            <button class="category-btn active" data-cat="semua">Semua</button>
            @foreach ($categories as $e)
            <button class="category-btn" data-cat="{{ $e->id }}">{{ $e->namaCategory }}</button>
            @endforeach
        </div>

        <div class="products-grid">
            @foreach ($categories as $cat)
            @foreach ($cat->produk as $index => $e)
            <article class="product-card" data-id="{{ $e->idCategory }}">
                <div class="product-image">
                    <img src="{{ asset('storage/' . $e->gambar) }}" alt="{{ $e->namaProduk }}" />
                    <button class="quick-view">Quick View</button>
                </div>
                <div class="product-info">
                    <span class="product-category">{{ $cat->namaCategory }}</span>
                    <h3>{{ $e->namaproduk }}</h3>
                    <p class="product-desc">{{ $e->deskripsi }}</p>
                    <div class="product-footer">
                        <span class="product-price">{{ number_format($e->harga, 0, ',', '.') }}</span>
                        <button class="btn-cart">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z" />
                                <line x1="3" y1="6" x2="21" y2="6" />
                                <path d="M16 10a4 4 0 01-8 0" />
                            </svg>
                        </button>
                    </div>
                </div>
            </article>
            @endforeach
            @endforeach
        </div>

        <div class="products-cta">
            <a href="{{ route('login') }}" class="btn-secondary">Lihat Semua Produk →</a>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="cta-section">
    <div class="container">
        <div class="cta-content">
            <h2>Butuh Bantuan Memilih Produk?</h2>
            <p>Tim farmasi kami siap membantu Anda 24/7</p>
            <div class="cta-buttons">
                <a href="#contact" class="btn-primary">Hubungi Kami</a>
                <a href="[wa.me](https://wa.me/6281234567890)" class="btn-outline">
                    <svg viewBox="0 0 24 24" fill="currentColor" width="20" height="20">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
                    </svg>
                    WhatsApp
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Contact Section -->
<section class="contact" id="contact">
    <div class="container">
        <div class="contact-grid">
            <div class="contact-info">
                <span class="section-tag">Kontak</span>
                <h2>Mari Terhubung</h2>
                <p>Kami siap membantu kebutuhan kesehatan Anda</p>

                <div class="contact-details">
                    <div class="contact-item">
                        <div class="contact-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z" />
                                <circle cx="12" cy="10" r="3" />
                            </svg>
                        </div>
                        <div>
                            <h4>Alamat</h4>
                            <p>Jl. Kesehatan No. 123<br />Jakarta Selatan 12345</p>
                        </div>
                    </div>

                    <div class="contact-item">
                        <div class="contact-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                <path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07 19.5 19.5 0 01-6-6 19.79 19.79 0 01-3.07-8.67A2 2 0 014.11 2h3a2 2 0 012 1.72 12.84 12.84 0 00.7 2.81 2 2 0 01-.45 2.11L8.09 9.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45 12.84 12.84 0 002.81.7A2 2 0 0122 16.92z" />
                            </svg>
                        </div>
                        <div>
                            <h4>Telepon</h4>
                            <p>+62 812 3456 7890<br />+62 21 1234 5678</p>
                        </div>
                    </div>

                    <div class="contact-item">
                        <div class="contact-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" />
                                <polyline points="22,6 12,13 2,6" />
                            </svg>
                        </div>
                        <div>
                            <h4>Email</h4>
                            <p>info@obatkita.com<br />support@obatkita.com</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="contact-form-wrapper">
                <form class="contact-form">
                    <div class="form-group">
                        <input type="text" id="name" required />
                        <label for="name">Nama Lengkap</label>
                    </div>
                    <div class="form-group">
                        <input type="email" id="email" required />
                        <label for="email">Email</label>
                    </div>
                    <div class="form-group">
                        <input type="tel" id="phone" required />
                        <label for="phone">Nomor Telepon</label>
                    </div>
                    <div class="form-group">
                        <textarea id="message" rows="4" required></textarea>
                        <label for="message">Pesan</label>
                    </div>
                    <button type="submit" class="btn-primary full-width">Kirim Pesan</button>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- Footer -->
<footer class="footer">
    <div class="container">
        <div class="footer-grid">
            <div class="footer-brand">
                <span class="footer-logo">OBATKITA</span>
                <p>Solusi kesehatan terpercaya untuk keluarga Indonesia.</p>
                <div class="social-links">
                    <a href="#" aria-label="Instagram">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <rect x="2" y="2" width="20" height="20" rx="5" />
                            <circle cx="12" cy="12" r="4" />
                            <circle cx="18" cy="6" r="1.5" fill="currentColor" />
                        </svg>
                    </a>
                    <a href="#" aria-label="Facebook">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z" />
                        </svg>
                    </a>
                    <a href="#" aria-label="Twitter">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M23 3a10.9 10.9 0 01-3.14 1.53 4.48 4.48 0 00-7.86 3v1A10.66 10.66 0 013 4s-4 9 5 13a11.64 11.64 0 01-7 2c9 5 20 0 20-11.5a4.5 4.5 0 00-.08-.83A7.72 7.72 0 0023 3z" />
                        </svg>
                    </a>
                </div>
            </div>

            <div class="footer-links">
                <h4>Perusahaan</h4>
                <ul>
                    <li><a href="#">Tentang Kami</a></li>
                    <li><a href="#">Karir</a></li>
                    <li><a href="#">Blog</a></li>
                    <li><a href="#">Mitra</a></li>
                </ul>
            </div>

            <div class="footer-links">
                <h4>Layanan</h4>
                <ul>
                    <li><a href="#">Konsultasi</a></li>
                    <li><a href="#">Pengiriman</a></li>
                    <li><a href="#">Langganan</a></li>
                    <li><a href="#">B2B</a></li>
                </ul>
            </div>

            <div class="footer-links">
                <h4>Bantuan</h4>
                <ul>
                    <li><a href="#">FAQ</a></li>
                    <li><a href="#">Kebijakan Privasi</a></li>
                    <li><a href="#">Syarat & Ketentuan</a></li>
                    <li><a href="#">Pengembalian</a></li>
                </ul>
            </div>
        </div>

        <div class="footer-bottom">
            <p>© 2026 Obatkita. All rights reserved.</p>
            <div class="payment-methods">
                <span>Pembayaran:</span>
                <img src="payment-visa.svg" alt="Visa" />
                <img src="payment-mastercard.svg" alt="Mastercard" />
                <img src="payment-gopay.svg" alt="GoPay" />
                <img src="payment-ovo.svg" alt="OVO" />
            </div>
        </div>
    </div>
</footer>
@endsection
@push('scripts')
<script src="{{ asset('js/app.js') }}"></script>
@endpush