<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Obatkita - Solusi Kesehatan Terpercaya</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    @stack('styles')
</head>

<body>
    <nav class="navbar" id="navbar">
        <a href="{{ Auth::check() ? route('home') : route('landingPage') }}" class="logo">
            <img src="{{ asset('img/obatkitalogo.png') }}" alt="">
        </a>

        @yield('nav')

        <ul class="nav-links">
            <li><a href="https://wa.me/629623479137">Kontak</a></li>
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