<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{setting('namaAplikasi')}}</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="{{ asset('style/admin.css') }}">
    @stack('styles')
</head>

<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-header" style="flex-direction: column; align-items: flex-start; gap: 4px; padding: 1.5rem 1.75rem;">
            <div style="height: 45px; width: 100%; display: flex; align-items: center; justify-content: flex-start; overflow: hidden;">
                <img src="{{ asset('img/obatkitaputih.png') }}" alt="ObatKita" style="height: 280px; object-fit: contain; margin-left: -50px; margin-right: -50px;">
            </div>
            <div style="font-size: 0.85rem; color: #818cf8; font-weight: 600; text-transform: uppercase; letter-spacing: 1px; margin-top: 5px; margin-left: 2px;">
                {{ auth()->user()->role === 'SuperAdmin' ? 'Super Admin' : 'Admin' }}
            </div>
        </div>
        <nav class="sidebar-nav">
            <!-- CORE MENU -->
            <div class="nav-section-title">Core / Utama</div>
            <a href="{{ route('dashboard') }}" class="nav-item" data-section="dashboard">
                <i class="fas fa-tachometer-alt"></i> Dashboard
            </a>

            <!-- SALES & TRANSACTIONS -->
            <div class="nav-section-title">Transaksi & Penjualan</div>
            <a href="{{ route('listTransaksi') }}" class="nav-item" data-section="transaksi">
                <i class="fas fa-exchange-alt"></i> Transaksi
            </a>
            <a href="{{ route('listPenjualan') }}" class="nav-item" data-section="penjualan">
                <i class="fas fa-chart-line"></i> Laporan Penjualan
            </a>
            <a href="{{ route('listInvoice') }}" class="nav-item" data-section="invoices">
                <i class="fas fa-file-invoice-dollar"></i> Invoice & Tagihan
            </a>

            <!-- INVENTORY & MEDICINES -->
            <div class="nav-section-title">Inventaris & Produk</div>
            <a href="{{ route('listProduk') }}" class="nav-item" data-section="obat">
                <i class="fas fa-capsules"></i> Data Obat
            </a>
            @if(auth()->user()->role === 'SuperAdmin')
            <a href="{{ route('listCategory') }}" class="nav-item" data-section="kategori">
                <i class="fas fa-tags"></i> Kategori Obat
            </a>
            @endif
            <a href="#" class="nav-item" data-section="supplier" onclick="alert('coming soon ya geng :>')">
                <i class="fas fa-truck-loading"></i> Data Supplier
            </a>

            <!-- USER & CLINIC MANAGEMENT -->
            <div class="nav-section-title">Manajemen Klinik & User</div>
            <a href="{{ route('listAkun') }}" class="nav-item" data-section="akun">
                <i class="fas fa-users-cog"></i> Data Akun
            </a>
            <a href="{{ route('listUser') }}" class="nav-item" data-section="user" style="padding-left: 2rem; font-size: 0.85rem;">
                <i class="fas fa-user-md"></i> Daftar Dokter
            </a>
            @if(auth()->user()->role === 'SuperAdmin' || auth()->user()->role === 'Admin')
            <a href="{{ route('listKlinik') }}" class="nav-item" data-section="klinik" style="padding-left: 2rem; font-size: 0.85rem;">
                <i class="fas fa-clinic-medical"></i> Daftar Klinik
            </a>
            @endif

            <!-- PROMOTIONS & MARKETING -->
            @if(auth()->user()->role === 'SuperAdmin')
            <div class="nav-section-title">Promosi & Program</div>
            <a href="{{ route('listProgram') }}" class="nav-item" data-section="BuatProgram">
                <i class="fas fa-gift"></i> Buat Program
            </a>
            <a href="{{ route('listDiskon') }}" class="nav-item" data-section="BuatDiskon">
                <i class="fas fa-percentage"></i> List Diskon
            </a>
            @endif

            <!-- SYSTEM & SUPPORT -->
            @if(auth()->user()->role === 'SuperAdmin')
            <div class="nav-section-title">Sistem & Bantuan</div>
            <a href="{{ route('viewSettings') }}" class="nav-item" data-section="settings">
                <i class="fas fa-sliders-h"></i> Pengaturan
            </a>
            <a href="{{ route('viewActivityLogs') }}" class="nav-item" data-section="activity-logs">
                <i class="fas fa-history"></i> Log Aktivitas
            </a>
            @endif
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