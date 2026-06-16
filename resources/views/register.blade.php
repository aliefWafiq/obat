<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - ObatKita</title>
    <link rel="icon" type="image/png" href="{{ asset('img/obatkitalogo.png') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('style/register.css') }}">
</head>

<body>
    <div class="auth-wrapper">
        <div class="auth-container">
            <div class="auth-left">
                <h2>Bergabunglah dengan Kami!</h2>
                <p>Daftarkan akun baru dan nikmati pengalaman berbelanja yang lebih baik dengan berbagai keuntungan eksklusif.</p>
                <div class="auth-left-features">
                    <div class="feature-item"><i class="fas fa-star"></i>
                        <div class="feature-item-text"><strong>Member Eksklusif</strong>Dapatkan diskon dan penawaran khusus untuk member baru</div>
                    </div>
                    <div class="feature-item"><i class="fas fa-gift"></i>
                        <div class="feature-item-text"><strong>Bonus Poin Reward</strong>Kumpulkan poin dari setiap pembelian</div>
                    </div>
                    <div class="feature-item"><i class="fas fa-lock"></i>
                        <div class="feature-item-text"><strong>Data Aman Terjamin</strong>Privasi dan keamanan data Anda adalah prioritas kami</div>
                    </div>
                </div>
            </div>
            <div class="auth-right">
                <div class="auth-brand"><a href="/"><img src="{{ asset('img/obatkitalogo.png') }}" alt="ObatKita Logo" class="auth-logo-img"></a></div>
                <h3>Buat Akun Baru</h3>
                <p class="auth-right-subtitle">Isi data diri Anda dengan lengkap dan benar</p>
                @if(session('error'))
                <div class="alert alert-danger"><i class="fas fa-exclamation-triangle"></i><span>{{ session('error') }}</span></div>
                @endif
                @if(session('otp_sent'))
    <div class="alert alert-success"><i class="fas fa-check-circle"></i><span>{{ session('success') }}</span></div>
    <form action="{{ route('verifyOTP') }}" method="POST">
        @csrf
        <input type="hidden" name="userId" value="{{ session('userId') }}">
        <div class="form-group">
            <label for="otp">Kode OTP</label>
            <input type="text" id="otp" name="otp" placeholder="Masukkan kode OTP" required>
            @error('otp')<span class="error">{{ $message }}</span>@enderror
        </div>
        <button type="submit" class="auth-btn" id="submitBtn"><i class="fas fa-check"></i> Verifikasi OTP</button>
    </form>
@else
    <form action="/register/action" method="POST" onsubmit="handleSubmit(this)">
        @csrf
                    <div class="form-group">
                        <label for="username">Nama Lengkap</label>
                        <input type="text" id="username" name="username" placeholder="Masukkan nama Anda" value="{{ old('username') }}" required>
                        @error('username')<span class="error">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label for="phoneNumber">Nomor HP</label>
                        <input type="number" id="phoneNumber" name="phoneNumber" placeholder="08xxxxxxxxxx" value="{{ old('phoneNumber') }}" required>
                        @error('phoneNumber')<span class="error">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label for="alamat">Alamat Lengkap</label>
                        <textarea id="alamat" name="alamat" placeholder="Jln. Contoh No. 123, Kota, Provinsi, Kode Pos" required>{{ old('alamat') }}</textarea>
                        @error('alamat')<span class="error">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" placeholder="Minimal 8 karakter" required>
                        @error('password')<span class="error">{{ $message }}</span>@enderror
                    </div>
                    <button type="submit" class="auth-btn" id="submitBtn"><i class="fas fa-user-plus"></i> Buat Akun</button>
                </form>
                @endif
                
                <div class="auth-footer">Sudah punya akun? <a href="{{ route('login') }}">Masuk sekarang</a></div>
            </div>
        </div>
    </div>
    <footer>
        <div>
            <a href="#">Tentang Kami</a>
            <a href="#">Syarat &amp; Ketentuan</a>
            <a href="#">Kebijakan Privasi</a>
            <a href="#">Hubungi Kami</a>
        </div>
        <p style="margin-top:15px;">&copy; 2026 ObatKita. Semua hak dilindungi.</p>
    </footer>
    <script src="{{ asset('js/register.js') }}"></script>
</body>

</html>