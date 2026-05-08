<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ObatKita - Admin Dashboard</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="{{ asset('style/admin.css') }}">
</head>

<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-header">
            <h2><i class="fas fa-pills"></i> ObatKita Admin</h2>
        </div>
        <nav class="sidebar-nav">
            <a href="{{ route('dashboard') }}" class="nav-item" data-section="dashboard">
                <i class="fas fa-tachometer-alt"></i> Dashboard
            </a>
            <a href="{{ route('listTransaksi') }}" class="nav-item" data-section="transaksi">
                <i class="fas fa-exchange-alt"></i> Transaksi
            </a>
            <a href="#penjualan" class="nav-item" data-section="penjualan">
                <i class="fas fa-chart-line"></i> Laporan Penjualan
            </a>
            <a href="{{ route('listUser') }}" class="nav-item" data-section="admin">
                <i class="fas fa-users-cog"></i> Data Akun
            </a>
            <a href="{{ route('listProduk') }}" class="nav-item" data-section="obat">
                <i class="fas fa-capsules"></i> Data Obat
            </a>
            <a href="{{ route('listCategory') }}" class="nav-item" data-section="kategori">
                <i class="fas fa-tags"></i> Data Kategori
            </a>
            <a href="{{ route('listProgram') }}" class="nav-item" data-section="BuatProgram">
                <i class="fas fa-cog"></i> Buat Program
            </a>
        </nav>
        <div class="sidebar-footer">
            <div class="user-info">
                <img src="{{ asset('img/397057724_11539820.png') }}" alt="Admin" class="user-avatar">
                <div>
                    <p>{{ Auth::user()->username }}</p>
                    <small>{{ Auth::user()->phoneNumber }}</small>
                </div>
            </div>
            <a href="{{ route('logOut') }}">
                <button class="logout-btn">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </button>
            </a>
        </div>
    </div>

    <!-- Main Content -->

    @yield('content')
    <script src="{{ asset('js/admin.js') }}"></script>
</body>

</html>