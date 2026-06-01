@extends('layouts.adminLayout')

@section('content')
<div class="main-content">
    <header class="header">
        <div class="header-left">
            <button class="menu-toggle">
                <i class="fas fa-bars"></i>
            </button>
            <div>
                <h1 id="page-title">Laporan Penjualan</h1>
            </div>
        </div>
        <div class="header-actions" style="display: flex; gap: 0.75rem; align-items: center;">
            <a href="{{ route('dashboard') }}" class="btn btn-secondary" style="display: inline-flex; align-items: center; gap: 0.5rem; text-decoration: none;">
                <i class="fas fa-arrow-left"></i> Dashboard
            </a>
            <a href="{{ route('listTransaksi') }}" class="btn btn-primary" style="display: inline-flex; align-items: center; gap: 0.5rem;">
                <i class="fas fa-exchange-alt"></i> Lihat Transaksi
            </a>
        </div>
    </header>

    <section class="content-section active" style="padding: 1.5rem 2rem 2rem;">
        <div class="section-header">
            <h2>Ringkasan Penjualan</h2>
        </div>

        <div class="stats-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 1rem; margin-top: 1rem;">
            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-coins"></i></div>
                <div class="stat-info">
                    <h3>Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</h3>
                    <p>Total Pendapatan</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-shopping-cart"></i></div>
                <div class="stat-info">
                    <h3>{{ $totalTransaksi }}</h3>
                    <p>Total Transaksi</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-box-open"></i></div>
                <div class="stat-info">
                    <h3>{{ $totalProdukTerjual }}</h3>
                    <p>Produk Terjual</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-user-check"></i></div>
                <div class="stat-info">
                    <h3>{{ $totalPelangganAktif }}</h3>
                    <p>Pelanggan Aktif</p>
                </div>
            </div>
        </div>

        <div class="table-container" style="margin-top: 1.5rem; background: #fff; border-radius: 24px; padding: 1.5rem; box-shadow: 0 18px 40px rgba(0,0,0,0.05);">
            <h3 style="margin-bottom: 1rem;">Detail Transaksi Terakhir</h3>
            <table class="data-table" style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Kode Pesanan</th>
                        <th>Pembeli</th>
                        <th>Klinik</th>
                        <th>Total Harga</th>
                        <th>Tipe</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pemesanan as $item)
                    <tr>
                        <td>{{ $item->created_at->format('d/m/Y') }}</td>
                        <td><strong>{{ $item->kodePemesanan }}</strong></td>
                        <td>{{ $item->user->username ?? '-' }}</td>
                        <td>{{ $item->user->klinik->namaKlinik ?? '-' }}</td>
                        <td>Rp {{ number_format($item->totalHarga, 0, ',', '.') }}</td>
                        <td>
                            @if(strtolower($item->tipePembayaran) === 'kredit')
                                <span style="font-weight: 600; padding: 0.25rem 0.5rem; border-radius: 4px; font-size: 0.8rem; background: #eff6ff; color: #1e40af; border: 1px solid rgba(30, 64, 175, 0.2); display: inline-flex; align-items: center; gap: 4px;"><i class="fas fa-calendar-alt"></i> Kredit</span>
                            @else
                                <span style="font-weight: 600; padding: 0.25rem 0.5rem; border-radius: 4px; font-size: 0.8rem; background: #f1f5f9; color: #475569; border: 1px solid #cbd5e1; display: inline-flex; align-items: center; gap: 4px;"><i class="fas fa-wallet"></i> Cash</span>
                            @endif
                        </td>
                        <td>{{ ucfirst($item->status) }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" style="text-align: center; padding: 2rem 0; color: #6b7280;">Belum ada transaksi.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
</div>
@endsection