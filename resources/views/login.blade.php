<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - ObatKita</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('style/login.css') }}">
</head>

<body>

    <!-- Main Auth Container -->
    <div class="auth-wrapper">
        <div class="auth-container">
            <!-- Left Side -->
            <div class="auth-left">
                <h2>Selamat Datang Kembali!</h2>
                <p>Akses akun Anda untuk melanjutkan berbelanja produk kesehatan terbaik dari ObatKita.</p>

                <div class="auth-left-features">
                    <div class="feature-item">
                        <i class="fas fa-check-circle"></i>
                        <div class="feature-item-text">
                            <strong>Produk Original</strong>
                            Jaminan 100% produk asli dari distributor resmi
                        </div>
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-truck"></i>
                        <div class="feature-item-text">
                            <strong>Pengiriman Cepat</strong>
                            Gratis ongkir untuk pembelian minimal tertentu
                        </div>
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-headset"></i>
                        <div class="feature-item-text">
                            <strong>Layanan 24/7</strong>
                            Tim customer service siap membantu kapan saja
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Side -->
            <div class="auth-right">
                <div class="auth-brand">
                    <a href="/">
                        <img src="{{ asset('img/obatkitalogo.png') }}" alt="ObatKita Logo" class="auth-logo-img">
                    </a>
                </div>
                <h3>Masuk ke Akun Anda</h3>
                <p class="auth-right-subtitle">Gunakan nomor HP dan password Anda</p>

                @if(session('success'))
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i>
                    <span>{{ session('success') }}</span>
                </div>
                @endif

                @if(session('error'))
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-triangle"></i>
                    <span>{{ session('error') }}</span>
                </div>
                @endif

                <form action="/login/action" method="POST" onsubmit="handleSubmit(this)">
                    @csrf

                    <div class="form-group">
                        <label for="phoneNumber">Nomor HP</label>
                        <input type="number" id="phoneNumber" name="phoneNumber" placeholder="Masukkan nomor HP Anda" required>
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" placeholder="Masukkan password Anda" required>
                    </div>

                    <button type="submit" class="auth-btn" id="submitBtn">
                        <i class="fas fa-sign-in-alt"></i> Masuk
                    </button>
                </form>

                <!-- <div class="auth-divider">
                    <span>atau</span>
                </div> -->

                <!-- <div class="social-login">
                    <button class="social-btn" type="button">
                        <i class="fab fa-google"></i> Google
                    </button>
                    <button class="social-btn" type="button">
                        <i class="fab fa-facebook"></i> Facebook
                    </button>
                </div> -->

                @if(setting('pendaftaranMandiriDokter', 'false') !== 'true' && setting('pendaftaranMandiriDokter', 'false') !== '1')
                <div class="auth-footer">
                    Belum punya akun? <a href="{{ route('register') }}">Daftar sekarang</a>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <div>
            <a href="#">Tentang Kami</a>
            <a href="#">Syarat & Ketentuan</a>
            <a href="#">Kebijakan Privasi</a>
            <a href="#">Hubungi Kami</a>
        </div>
        <p style="margin-top: 15px;">&copy; 2026 ObatKita. Semua hak dilindungi.</p>
    </footer>

    <script src="{{ asset('js/login.js') }}"></script>
</body>

</html>