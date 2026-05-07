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
                    <h3>Rp 124.560.000</h3>
                    <p>Total Pendapatan</p>
                    <small>Klik untuk grafik harian/bulanan/tahunan</small>
                </div>
            </div>
            <div class="stat-card" data-detail="transactions">
                <div class="stat-icon">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <div class="stat-info">
                    <h3>1.256</h3>
                    <p>Transaksi Hari Ini</p>
                    <small>Klik untuk melihat item dan pembeli</small>
                </div>
            </div>
            <div class="stat-card" data-detail="products">
                <div class="stat-icon">
                    <i class="fas fa-box-open"></i>
                </div>
                <div class="stat-info">
                    <h3>348</h3>
                    <p>Produk Terjual</p>
                    <small>Klik untuk detail produk unggulan</small>
                </div>
            </div>
            <div class="stat-card" data-detail="average">
                <div class="stat-icon">
                    <i class="fas fa-chart-pie"></i>
                </div>
                <div class="stat-info">
                    <h3>Rp 99.000</h3>
                    <p>Rata-rata Transaksi</p>
                    <small>Klik untuk analisis tren nilai transaksi</small>
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
                        <strong>Rp 19.800.000</strong>
                    </div>
                    <div class="detail-summary-card">
                        <span>Total Bulan Ini</span>
                        <strong>Rp 76.200.000</strong>
                    </div>
                    <div class="detail-summary-card">
                        <span>Pertumbuhan</span>
                        <strong>+18%</strong>
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
                            <li>Vitamin C 1000mg <span>56x</span></li>
                            <li>Paracetamol <span>48x</span></li>
                            <li>Suplemen Omega <span>32x</span></li>
                        </ul>
                    </div>
                    <div class="detail-list-card">
                        <h4>Pembeli Teratas</h4>
                        <ul>
                            <li>Ani Nur <span>3 transaksi</span></li>
                            <li>Budi Santoso <span>2 transaksi</span></li>
                            <li>Citra Lestari <span>2 transaksi</span></li>
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
                                <tr>
                                    <td>Vitamin C 1000mg</td>
                                    <td>56</td>
                                    <td>24</td>
                                </tr>
                                <tr>
                                    <td>Paracetamol</td>
                                    <td>48</td>
                                    <td>14</td>
                                </tr>
                                <tr>
                                    <td>Suplemen Omega</td>
                                    <td>32</td>
                                    <td>18</td>
                                </tr>
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
                        <strong>Rp 99.000</strong>
                    </div>
                    <div class="detail-summary-card">
                        <span>Kontribusi Obat</span>
                        <strong>63%</strong>
                    </div>
                    <div class="detail-summary-card">
                        <span>Kontribusi Suplemen</span>
                        <strong>27%</strong>
                    </div>
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
                    <h3>Rp 76.200.000</h3>
                    <p>Pendapatan Mingguan</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-cart-plus"></i>
                </div>
                <div class="stat-info">
                    <h3>893</h3>
                    <p>Total Pesanan</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-chart-line"></i>
                </div>
                <div class="stat-info">
                    <h3>22%</h3>
                    <p>Pertumbuhan</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-user-check"></i>
                </div>
                <div class="stat-info">
                    <h3>1.120</h3>
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
@endsection