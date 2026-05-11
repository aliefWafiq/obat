<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Obatkita - Solusi Kesehatan Terpercaya</title>
    @stack('styles')
</head>

<body>
    <nav class="navbar" id="navbar">
        <a href="{{ route('login') }}" class="logo">
            <img src="{{ asset('img/obatkitalogo.png') }}" alt="">
        </a>

        @yield('nav')

        <ul class="nav-links">
            <li><a href="{{ route('login') }}">Produk</a></li>
            <li><a href="#contact">Kontak</a></li>
            @if (Auth::check())
            <li><a href="{{ route('keranjang') }}">Keranjang</a></li>
            <li><a href="{{ route('pemesanan') }}">Pemesanan</a></li>
            <li><a href="{{ route('logOut') }}">Keluar</a></li>
            @else
            <li><a href="#services">Layanan</a></li>
            <li><a href="{{ route('login') }}" class="btn-login">Masuk</a></li>
            @endif
        </ul>

        <button class="mobile-toggle" id="mobileToggle">
            <span></span>
            <span></span>
            <span></span>
        </button>
    </nav>
    @yield('content')
    @stack('scripts')
    
</body>

</html>