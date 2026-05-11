@extends('layouts.adminLayout')

@section('content')
<div class="main-content">
    <header class="header">
        <div class="header-left">
            <button class="menu-toggle">
                <i class="fas fa-bars"></i>
            </button>
            <h1 id="page-title">Dashboard</h1>
        </div>
    </header>

    <section id="dashboard" class="content-section active">
        <div class="section-header">
            <h2>Dashboard</h2>
            <div>
                <button class="filter-btn">Ringkas</button>
                <button class="export-btn">Export</button>
            </div>
        </div>

        <div class="stats-grid">
            <div class="stat-card" data-detail="revenue">
                <div class="stat-icon">
                    <i class="fas fa-wallet"></i>
                </div>
                <div class="stat-info">
                    <h3>Rp {{ $totalPendapatan }}</h3>
                    <p>Total Pendapatan</p>
                </div>
            </div>
            <div class="stat-card" data-detail="transactions">
                <div class="stat-icon">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <div class="stat-info">
                    <h3>{{ $totalTransaksiHariIni }}</h3>
                    <p>Transaksi Hari Ini</p>
                </div>
            </div>
            <div class="stat-card" data-detail="products">
                <div class="stat-icon">
                    <i class="fas fa-box-open"></i>
                </div>
                <div class="stat-info">
                    <h3>{{ $totalProdukTerjual }}</h3>
                    <p>Produk Terjual</p>
                </div>
            </div>
        </div>

        <div class="detail-panel-container">
            <div class="detail-panel detail-revenue active" id="detail-revenue">
                <div class="detail-panel-header">
                    <div>
                        <h3>Detail Total Pendapatan</h3>
                        <p>Grafik pendapatan per hari, bulan, dan tahun.</p>
                    </div>
                    <div class="detail-tabs">
                        <button class="detail-tab active" data-period="daily">Harian</button>
                        <button class="detail-tab" data-period="monthly">Bulanan</button>
                        <button class="detail-tab" data-period="yearly">Tahunan</button>
                    </div>
                </div>
                <div class="detail-chart-card">
                    <canvas id="revenuePeriodChart"></canvas>
                </div>
                <div class="detail-summary-grid">
                    <div class="detail-summary-card">
                        <span>Total Minggu Ini</span>
                        <strong>Rp {{ number_format($pendapatanMingguan, 0, ',', '.') }}</strong>
                    </div>
                    <div class="detail-summary-card">
                        <span>Total Bulan Ini</span>
                        <strong>Rp {{ number_format($pendapatanBulanIni, 0, ',', '.') }}</strong>
                    </div>
                    <div class="detail-summary-card">
                        <span>Pertumbuhan</span>
                        <strong class="{{ $pertumbuhan >= 0 ? 'text-success' : 'text-danger' }}">{{ $pertumbuhan > 0 ? '+' : '' }}{{ $pertumbuhan }}%</strong>
                    </div>
                </div>
            </div>

            <div class="detail-panel detail-transactions" id="detail-transactions">
                <div class="detail-panel-header">
                    <div>
                        <h3>Detail Transaksi Hari Ini</h3>
                        <p>Item yang dibeli dan informasi pembeli.</p>
                    </div>
                </div>
                <div class="detail-list-grid">
                    <div class="detail-list-card">
                        <h4>Top Item</h4>
                        <ul>
                            @forelse($topItems as $item)
                            <li>{{ $item->produk->namaProduk ?? 'Produk Dihapus' }} <span>{{ $item->total_qty }}x</span></li>
                            @empty
                            <li>Belum ada data</li>
                            @endforelse
                        </ul>
                    </div>
                    <div class="detail-list-card">
                        <h4>Pembeli Teratas Hari Ini</h4>
                        <ul>
                            @forelse($topBuyers as $buyer)
                            <li>{{ $buyer->user->username ?? 'User Dihapus' }} <span>{{ $buyer->total_transaksi }} transaksi</span></li>
                            @empty
                            <li>Belum ada data</li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>

            <div class="detail-panel detail-products" id="detail-products">
                <div class="detail-panel-header">
                    <div>
                        <h3>Detail Produk Terjual</h3>
                        <p>Produk unggulan dan performa penjualan.</p>
                    </div>
                </div>
                <div class="detail-list-grid">
                    <div class="detail-list-card wide">
                        <h4>Produk Unggulan</h4>
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Produk</th>
                                    <th>Terjual</th>
                                    <th>Stok</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($produkUnggulan as $item)
                                <tr>
                                    <td>{{ $item->produk->namaProduk ?? 'Produk Dihapus' }}</td>
                                    <td>{{ $item->total_terjual }}</td>
                                    <td>{{ $item->produk->stok ?? 0 }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3">Belum ada data</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="detail-panel detail-average" id="detail-average">
                <div class="detail-panel-header">
                    <div>
                        <h3>Detail Rata-rata Transaksi</h3>
                        <p>Analisis nilai transaksi dan kontribusi kategori.</p>
                    </div>
                </div>
                <div class="detail-summary-grid">
                    <div class="detail-summary-card">
                        <span>Nilai Transaksi Rata-rata</span>
                        <strong>Rp {{ number_format($rataRataTransaksi, 0, ',', '.') }}</strong>
                    </div>
                    @foreach($kategoriKontribusi->take(2) as $kat)
                    <div class="detail-summary-card">
                        <span>Kontribusi {{ $kat->namaCategory }}</span>
                        <strong>{{ $totalPenjualanSemuaKategori > 0 ? round(($kat->total_penjualan / $totalPenjualanSemuaKategori) * 100) : 0 }}%</strong>
                    </div>
                    @endforeach
                </div>
                <div class="detail-chart-card small">
                    <canvas id="averageTrendChart"></canvas>
                </div>
            </div>
        </div>
    </section>

    <section id="penjualan" class="content-section">
        <div class="section-header">
            <h2>Laporan Penjualan</h2>
            <div>
                <input type="date" class="date-filter" />
                <input type="date" class="date-filter" />
                <button class="filter-btn">Filter</button>
                <button class="export-btn">Export</button>
            </div>
        </div>

        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-coins"></i>
                </div>
                <div class="stat-info">
                    <h3>Rp {{ number_format($pendapatanMingguan, 0, ',', '.') }}</h3>
                    <p>Pendapatan Mingguan</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-cart-plus"></i>
                </div>
                <div class="stat-info">
                    <h3>{{ number_format($totalPesanan, 0, ',', '.') }}</h3>
                    <p>Total Pesanan</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-chart-line"></i>
                </div>
                <div class="stat-info">
                    <h3 class="{{ $pertumbuhan >= 0 ? 'text-success' : 'text-danger' }}">{{ $pertumbuhan > 0 ? '+' : '' }}{{ $pertumbuhan }}%</h3>
                    <p>Pertumbuhan</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-user-check"></i>
                </div>
                <div class="stat-info">
                    <h3>{{ number_format($pelangganAktif, 0, ',', '.') }}</h3>
                    <p>Pelanggan Aktif</p>
                </div>
            </div>
        </div>

        <div class="charts-grid">
            <div class="chart-card">
                <div class="chart-header">
                    <h3>Penjualan Harian</h3>
                    <button class="print-btn">Print</button>
                </div>
                <canvas id="dailyChart"></canvas>
            </div>
            <div class="chart-card">
                <div class="chart-header">
                    <h3>Penjualan Bulanan</h3>
                </div>
                <canvas id="monthlyChart"></canvas>
            </div>
        </div>

        <div class="table-container" style="margin-top: 1.5rem;">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Transaksi</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>05 Mei 2026</td>
                        <td>#TRX-1023</td>
                        <td>Rp 2.400.000</td>
                        <td><span class="status completed">Selesai</span></td>
                        <td>
                            <button class="action-btn"><i class="fas fa-eye"></i></button>
                            <button class="action-btn"><i class="fas fa-print"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td>04 Mei 2026</td>
                        <td>#TRX-1018</td>
                        <td>Rp 1.850.000</td>
                        <td><span class="status completed">Selesai</span></td>
                        <td>
                            <button class="action-btn"><i class="fas fa-eye"></i></button>
                            <button class="action-btn"><i class="fas fa-print"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td>03 Mei 2026</td>
                        <td>#TRX-1009</td>
                        <td>Rp 3.200.000</td>
                        <td><span class="status active">Diproses</span></td>
                        <td>
                            <button class="action-btn"><i class="fas fa-eye"></i></button>
                            <button class="action-btn"><i class="fas fa-print"></i></button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>
</div>
<script>
    window.chartData = {
        dailyLabels: {!! json_encode($dailyLabels) !!},
        dailyData: {!! json_encode($dailyData) !!},
        monthlyLabels: {!! json_encode($monthlyLabels) !!},
        monthlyData: {!! json_encode($monthlyData) !!},
        yearlyLabels: {!! json_encode($yearlyLabels) !!},
        yearlyData: {!! json_encode($yearlyData) !!},
        kategoriLabels: {!! json_encode($kategoriKontribusi->pluck('namaCategory')) !!},
        kategoriData: {!! json_encode($kategoriKontribusi->pluck('total_penjualan')) !!}
    };
</script>
@endsection