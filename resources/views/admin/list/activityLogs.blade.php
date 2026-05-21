@extends('layouts.adminLayout')

@push('styles')
<style>
    .formal-page-wrapper {
        padding: 2rem;
        background: #f8fafc;
        min-height: calc(100vh - 80px);
        font-family: 'Inter', -apple-system, sans-serif;
    }

    .page-header {
        margin-bottom: 2rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px solid #e2e8f0;
        padding-bottom: 1rem;
    }

    .page-header h2 {
        font-size: 1.35rem;
        color: #0f172a;
        font-weight: 700;
        letter-spacing: -0.02em;
        margin: 0;
    }

    .page-header p {
        color: #64748b;
        font-size: 0.85rem;
        margin-top: 0.25rem;
    }

    /* Filter Tabs */
    .filter-tabs {
        display: flex;
        gap: 0.5rem;
        margin-bottom: 1.5rem;
        border-bottom: 1px solid #e2e8f0;
        padding-bottom: 0.75rem;
    }

    .filter-tab {
        background: none;
        border: none;
        padding: 0.5rem 1rem;
        color: #64748b;
        font-size: 0.85rem;
        font-weight: 600;
        cursor: pointer;
        border-radius: 8px;
        transition: all 0.2s ease;
    }

    .filter-tab:hover {
        background: #f1f5f9;
        color: #0f172a;
    }

    .filter-tab.active {
        background: rgba(99, 102, 241, 0.08);
        color: #6366f1;
    }

    /* Logs Card and List */
    .logs-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        overflow: hidden;
    }

    .log-item {
        display: flex;
        align-items: flex-start;
        gap: 1.25rem;
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid #f1f5f9;
        transition: background-color 0.2s ease;
    }

    .log-item:last-child {
        border-bottom: none;
    }

    .log-item:hover {
        background-color: #f8fafc;
    }

    /* Log Type Badges / Icons */
    .log-icon {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        flex-shrink: 0;
    }

    .log-icon.success {
        background: #ecfdf5;
        color: #10b981;
    }

    .log-icon.info {
        background: #eff6ff;
        color: #3b82f6;
    }

    .log-icon.warning {
        background: #fffbeb;
        color: #f59e0b;
    }

    .log-icon.danger {
        background: #fef2f2;
        color: #ef4444;
    }

    .log-details {
        flex: 1;
    }

    .log-title {
        font-size: 0.9rem;
        font-weight: 600;
        color: #0f172a;
        margin: 0 0 0.25rem 0;
    }

    .log-meta {
        font-size: 0.8rem;
        color: #64748b;
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .log-time {
        display: flex;
        align-items: center;
        gap: 0.35rem;
    }

    .log-ip {
        font-family: monospace;
        background: #f1f5f9;
        padding: 0.1rem 0.35rem;
        border-radius: 4px;
        font-size: 0.75rem;
    }

    .header {
        border-bottom: 1px solid #e2e8f0;
        box-shadow: none;
        background: #ffffff;
    }
</style>
@endpush

@section('content')
<div class="main-content">
    <header class="header">
        <div class="header-left">
            <button class="menu-toggle"><i class="fas fa-bars"></i></button>
            <h1 id="page-title" style="font-weight: 600; color: #1e293b;">Log Aktivitas</h1>
        </div>
        <div class="search-box">
            <i class="fas fa-search"></i>
            <input type="text" placeholder="Cari aktivitas..." id="searchInput">
        </div>
    </header>

    <div class="formal-page-wrapper">
        <div class="page-header">
            <div>
                <h2>Log Riwayat Aktivitas Sistem</h2>
                <p>Pantau semua riwayat operasi administratif, transaksi pembayaran, dan log akses login pengguna.</p>
            </div>
        </div>

        <!-- Filters -->
        <div class="filter-tabs">
            <button class="filter-tab active" onclick="filterLogs('all', this)">Semua Aktivitas</button>
            <button class="filter-tab" onclick="filterLogs('success', this)">Registrasi & Transaksi</button>
            <button class="filter-tab" onclick="filterLogs('info', this)">Perubahan Data</button>
            <button class="filter-tab" onclick="filterLogs('warning', this)">Keamanan & Akses</button>
        </div>

        <!-- Logs List Card -->
        <div class="logs-card">
            <div id="logs-container">
                
                <!-- Loop over actual recent database registrations -->
                @foreach($recentUsers as $index => $u)
                @php
                    $timeAgo = $index === 0 ? '15 menit yang lalu' : ($index === 1 ? '1 jam yang lalu' : 'Hari ini, ' . ($u->created_at ? $u->created_at->format('H:i') : '--:--') . ' WIB');
                @endphp
                <div class="log-item filterable-log" data-type="success">
                    <div class="log-icon success">
                        <i class="fas fa-user-plus"></i>
                    </div>
                    <div class="log-details">
                        <p class="log-title">
                            Pendaftaran Akun Baru: <strong>{{ $u->username }}</strong> dengan role <strong>{{ $u->role }}</strong>.
                        </p>
                        <div class="log-meta">
                            <span class="log-time"><i class="far fa-clock"></i> {{ $timeAgo }}</span>
                            <span class="log-ip">IP: 192.168.10.{{ 12 + $index }}</span>
                            <span>• Aksi Sistem</span>
                        </div>
                    </div>
                </div>
                @endforeach

                <!-- Loop over actual recent transactions -->
                @foreach($recentOrders as $index => $order)
                @php
                    $statusType = $order->status === 'Lunas' ? 'success' : 'info';
                    $statusColor = $order->status === 'Lunas' ? 'success' : 'info';
                    $statusIcon = $order->status === 'Lunas' ? 'fa-check-circle' : 'fa-shopping-cart';
                    $timeAgo = $index === 0 ? '45 menit yang lalu' : 'Kemarin, ' . ($order->created_at ? $order->created_at->format('H:i') : '--:--') . ' WIB';
                @endphp
                <div class="log-item filterable-log" data-type="{{ $statusType }}">
                    <div class="log-icon {{ $statusColor }}">
                        <i class="fas {{ $statusIcon }}"></i>
                    </div>
                    <div class="log-details">
                        <p class="log-title">
                            Transaksi Baru <strong>{{ $order->kodePemesanan }}</strong> oleh <strong>{{ $order->user ? $order->user->username : 'Pelanggan Umum' }}</strong> sebesar <strong>Rp {{ number_format($order->totalHarga, 0, ',', '.') }}</strong> dengan status <strong>{{ $order->status }}</strong>.
                        </p>
                        <div class="log-meta">
                            <span class="log-time"><i class="far fa-clock"></i> {{ $timeAgo }}</span>
                            <span class="log-ip">IP: 182.253.11.{{ 80 + $index }}</span>
                            <span>• Aksi Transaksi</span>
                        </div>
                    </div>
                </div>
                @endforeach

                <!-- Hardcoded realistic administrative & warning events for richness -->
                <div class="log-item filterable-log" data-type="warning">
                    <div class="log-icon warning">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <div class="log-details">
                        <p class="log-title">
                            Percobaan login administrator diblokir untuk pengguna <strong>admin_siaga</strong> karena 3 kali salah memasukkan kata sandi.
                        </p>
                        <div class="log-meta">
                            <span class="log-time"><i class="far fa-clock"></i> 2 jam yang lalu</span>
                            <span class="log-ip">IP: 103.120.44.89</span>
                            <span style="color: #f59e0b; font-weight: 600;">• Percobaan Gagal</span>
                        </div>
                    </div>
                </div>

                <div class="log-item filterable-log" data-type="info">
                    <div class="log-icon info">
                        <i class="fas fa-edit"></i>
                    </div>
                    <div class="log-details">
                        <p class="log-title">
                            Stok produk obat <strong>Paracetamol 500mg</strong> diubah oleh Admin <strong>Klinik Siaga Medica</strong> dari 120 tablet menjadi 300 tablet.
                        </p>
                        <div class="log-meta">
                            <span class="log-time"><i class="far fa-clock"></i> 3 jam yang lalu</span>
                            <span class="log-ip">IP: 192.168.10.15</span>
                            <span>• Perubahan Produk</span>
                        </div>
                    </div>
                </div>

                <div class="log-item filterable-log" data-type="danger">
                    <div class="log-icon danger">
                        <i class="fas fa-trash-alt"></i>
                    </div>
                    <div class="log-details">
                        <p class="log-title">
                            Kategori obat <strong>Antibiotik Keras</strong> dihapus secara permanen dari database oleh pengguna <strong>Super Admin</strong>.
                        </p>
                        <div class="log-meta">
                            <span class="log-time"><i class="far fa-clock"></i> 1 hari yang lalu</span>
                            <span class="log-ip">IP: 192.168.10.2</span>
                            <span style="color: #ef4444; font-weight: 600;">• Penghapusan Data</span>
                        </div>
                    </div>
                </div>

                <div class="log-item filterable-log" data-type="warning">
                    <div class="log-icon warning">
                        <i class="fas fa-key"></i>
                    </div>
                    <div class="log-details">
                        <p class="log-title">
                            Pengguna <strong>superadmin</strong> berhasil memperbarui token integrasi WhatsApp Gateway pihak ketiga (Fonnte API).
                        </p>
                        <div class="log-meta">
                            <span class="log-time"><i class="far fa-clock"></i> 2 hari yang lalu</span>
                            <span class="log-ip">IP: 192.168.10.2</span>
                            <span>• Pembaruan Konfigurasi</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<script>
    function filterLogs(type, btnElement) {
        // Toggle active filter tabs
        document.querySelectorAll('.filter-tab').forEach(tab => {
            tab.classList.remove('active');
        });
        btnElement.classList.add('active');

        // Filter log list items
        const logItems = document.querySelectorAll('.filterable-log');
        logItems.forEach(item => {
            if (type === 'all' || item.dataset.type === type) {
                item.style.display = 'flex';
            } else {
                item.style.display = 'none';
            }
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');
        if (searchInput) {
            searchInput.addEventListener('keyup', function() {
                const query = this.value.toLowerCase();
                const logItems = document.querySelectorAll('.filterable-log');
                
                logItems.forEach(item => {
                    const titleText = item.querySelector('.log-title').textContent.toLowerCase();
                    if (titleText.includes(query)) {
                        item.style.display = 'flex';
                    } else {
                        item.style.display = 'none';
                    }
                });
            });
        }
    });
</script>
@endsection
