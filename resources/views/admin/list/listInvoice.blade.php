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

    /* Summary cards layout */
    .summary-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .summary-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 1.5rem;
        display: flex;
        align-items: center;
        gap: 1.25rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
    }

    .summary-icon {
        width: 48px;
        height: 48px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.35rem;
    }

    .summary-details h4 {
        margin: 0;
        font-size: 0.8rem;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        font-weight: 600;
    }

    .summary-details span {
        font-size: 1.5rem;
        font-weight: 700;
        color: #0f172a;
        display: block;
        margin-top: 0.25rem;
    }

    .data-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.05);
        margin-bottom: 2rem;
        overflow-x: auto;
    }

    .section-title {
        background: #f8fafc;
        padding: 1rem 1.5rem;
        font-weight: 600;
        color: #475569;
        border-bottom: 1px solid #e2e8f0;
        font-size: 0.9rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .formal-table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
    }

    .formal-table th {
        background-color: #ffffff;
        color: #64748b;
        font-weight: 600;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        padding: 1rem 1.5rem;
        border-bottom: 1px solid #e2e8f0;
    }

    .formal-table td {
        padding: 1rem 1.5rem;
        border-bottom: 1px solid #f1f5f9;
        color: #334155;
        font-size: 0.875rem;
        vertical-align: middle;
    }
    
    .main-row {
        cursor: pointer;
        transition: background-color 0.2s ease;
    }

    .main-row:hover {
        background-color: #f8fafc;
    }
    
    .main-row.expanded {
        background-color: #f8fafc;
        border-bottom: none;
    }

    .main-row.expanded td {
        border-bottom: none;
    }

    .sub-row {
        display: none;
        background-color: #f8fafc;
    }

    .sub-row.active {
        display: table-row;
    }

    .sub-table-container {
        padding: 0 1.5rem 1.5rem 4rem;
    }

    .sub-table {
        width: 100%;
        border-collapse: collapse;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        overflow: hidden;
    }

    .sub-table th {
        background-color: #f8fafc;
        padding: 0.75rem 1rem;
        font-size: 0.75rem;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        border-bottom: 1px solid #e2e8f0;
    }

    .sub-table td {
        padding: 0.75rem 1rem;
        font-size: 0.85rem;
        border-bottom: 1px solid #f1f5f9;
        color: #334155;
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        padding: 0.25rem 0.6rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .status-lunas {
        background: #ecfdf5;
        color: #065f46;
        border: 1px solid #a7f3d0;
    }

    .status-pending {
        background: #fffbeb;
        color: #92400e;
        border: 1px solid #fde68a;
    }

    .status-batal {
        background: #fef2f2;
        color: #991b1b;
        border: 1px solid #fecaca;
    }

    .action-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        background: #ffffff;
        border: 1px solid #cbd5e1;
        padding: 0.4rem 0.75rem;
        border-radius: 8px;
        color: #334155;
        font-size: 0.8rem;
        font-weight: 500;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .action-btn:hover {
        background: #f8fafc;
        border-color: #94a3b8;
        color: #0f172a;
    }

    .expand-indicator {
        color: #94a3b8;
        font-size: 0.8rem;
        transition: transform 0.2s ease;
    }
    
    .main-row.expanded .expand-indicator {
        transform: rotate(90deg);
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
            <h1 id="page-title" style="font-weight: 600; color: #1e293b;">Invoice & Tagihan</h1>
        </div>
        <div class="search-box">
            <i class="fas fa-search"></i>
            <input type="text" placeholder="Cari invoice atau pelanggan..." id="searchInput">
        </div>
    </header>

    <div class="formal-page-wrapper">
        <div class="page-header">
            <div>
                <h2>
                    @if(auth()->user()->role === 'SuperAdmin')
                        Kelola Invoice & Tagihan
                    @else
                        Tagihan Klinik: {{ auth()->user()->username }}
                    @endif
                </h2>
                <p>Data laporan penagihan, kwitansi, dan transaksi klinik terdaftar.</p>
            </div>
        </div>

        @php
            $lunas = $pemesanan->where('status', 'Lunas');
            $pending = $pemesanan->where('status', '!=', 'Lunas');
            $totalNominal = $lunas->sum('totalHarga');
        @endphp

        <!-- Metrics cards -->
        <div class="summary-grid">
            <div class="summary-card">
                <div class="summary-icon" style="background: rgba(16, 185, 129, 0.1); color: #10b981;">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="summary-details">
                    <h4>Tagihan Terbayar (Lunas)</h4>
                    <span>{{ $lunas->count() }} Invoice</span>
                </div>
            </div>
            <div class="summary-card">
                <div class="summary-icon" style="background: rgba(245, 158, 11, 0.1); color: #f59e0b;">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="summary-details">
                    <h4>Tagihan Tertunda (Pending)</h4>
                    <span>{{ $pending->count() }} Invoice</span>
                </div>
            </div>
            <div class="summary-card">
                <div class="summary-icon" style="background: rgba(99, 102, 241, 0.1); color: #6366f1;">
                    <i class="fas fa-wallet"></i>
                </div>
                <div class="summary-details">
                    <h4>Total Pendapatan Terbayar</h4>
                    <span>Rp {{ number_format($totalNominal, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        @if(auth()->user()->role === 'SuperAdmin')
            <!-- SUPER ADMIN VIEW: Group by Clinics -->
            <div class="data-card">
                <div class="section-title">
                    Daftar Invoice Berdasarkan Klinik
                </div>
                <table class="formal-table">
                    <thead>
                        <tr>
                            <th style="width: 40px;"></th>
                            <th>Klinik</th>
                            <th>Kode Klinik</th>
                            <th>Total Transaksi</th>
                            <th>Jumlah Terbayar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($clinics->isEmpty())
                            <tr>
                                <td colspan="5" style="text-align: center; padding: 3rem; color: #64748b;">
                                    Belum ada data klinik terdaftar.
                                </td>
                            </tr>
                        @else
                            @foreach($clinics as $c)
                            @php
                                $clinicOrders = $pemesanan->filter(function($order) use ($c) {
                                    return $order->user && $order->user->idKlinik == $c->id;
                                });
                                $clinicPaidTotal = $clinicOrders->where('status', 'Lunas')->sum('totalHarga');
                            @endphp
                            <tr class="main-row searchable-row" onclick="toggleSubRow('invoice-clinic-{{ $c->id }}', this)">
                                <td style="text-align: center;">
                                    <i class="fas fa-chevron-right expand-indicator"></i>
                                </td>
                                <td>
                                    <div style="display: flex; align-items: center; gap: 0.75rem; font-weight: 600; color: #0f172a;">
                                        <i class="fas fa-hospital" style="color: #6366f1;"></i>
                                        <span class="searchable-name">{{ $c->namaKlinik }}</span>
                                    </div>
                                </td>
                                <td><span style="font-family: monospace; background: #f1f5f9; padding: 0.2rem 0.5rem; border-radius: 4px;">{{ $c->kodeKlinik }}</span></td>
                                <td>{{ $clinicOrders->count() }} Transaksi</td>
                                <td>
                                    <span style="font-weight: 600; color: #10b981;">Rp {{ number_format($clinicPaidTotal, 0, ',', '.') }}</span>
                                </td>
                            </tr>
                            <tr class="sub-row" id="invoice-clinic-{{ $c->id }}">
                                <td colspan="5" style="padding: 0;">
                                    <div class="sub-table-container">
                                        <h5 style="margin: 1rem 0 0.75rem 0; color: #1e293b; font-size: 0.95rem; font-weight: 700;">
                                            Daftar Invoice: {{ $c->namaKlinik }}
                                        </h5>
                                        @if($clinicOrders->isEmpty())
                                            <div style="padding: 1.5rem; color: #64748b; font-size: 0.9rem; border: 1px dashed #e2e8f0; border-radius: 8px; text-align: center; background: #fff;">
                                                Belum ada invoice/transaksi untuk klinik ini.
                                            </div>
                                        @else
                                            <table class="sub-table">
                                                <thead>
                                                    <tr>
                                                        <th>Kode Invoice</th>
                                                        <th>Tanggal Pemesanan</th>
                                                        <th>Pelanggan</th>
                                                        <th>Total Nominal</th>
                                                        <th>Tipe</th>
                                                        <th>Status</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($clinicOrders as $order)
                                                    <tr>
                                                        <td style="font-weight: 600; font-family: monospace; color: #6366f1;">{{ $order->kodePemesanan }}</td>
                                                        <td>{{ $order->created_at ? $order->created_at->format('d M Y, H:i') : '-' }}</td>
                                                        <td>
                                                            <div style="font-weight: 500;">{{ $order->user ? $order->user->username : '-' }}</div>
                                                            <small style="color: #64748b;">{{ $order->user ? $order->user->phoneNumber : '-' }}</small>
                                                        </td>
                                                        <td style="font-weight: 600;">Rp {{ number_format($order->totalHarga, 0, ',', '.') }}</td>
                                                        <td>
                                                            @if(strtolower($order->tipePembayaran) === 'kredit')
                                                                <span class="status-badge" style="background: #eff6ff; color: #1e40af; border: 1px solid rgba(30, 64, 175, 0.2);"><i class="fas fa-calendar-alt"></i> Kredit</span>
                                                            @else
                                                                <span class="status-badge" style="background: #f1f5f9; color: #475569; border: 1px solid #cbd5e1;"><i class="fas fa-wallet"></i> Cash</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if($order->status === 'Lunas')
                                                                <span class="status-badge status-lunas"><i class="fas fa-check"></i> Lunas</span>
                                                            @elseif($order->status === 'Batal')
                                                                <span class="status-badge status-batal"><i class="fas fa-times"></i> Batal</span>
                                                            @else
                                                                <span class="status-badge status-pending"><i class="fas fa-clock"></i> Pending</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if($order->status === 'Lunas')
                                                            <a href="{{ route('cetakStruk', $order->id) }}" target="_blank" class="action-btn">
                                                                <i class="fas fa-print"></i> Cetak Kwitansi
                                                            </a>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        @else
            <!-- CLINIC ADMIN VIEW: Show only their own clinic invoices -->
            <div class="data-card">
                <div class="section-title">
                    Invoice & Riwayat Tagihan Masuk
                </div>
                <table class="formal-table">
                    <thead>
                        <tr>
                            <th>Kode Invoice</th>
                            <th>Tanggal Pemesanan</th>
                            <th>Nama Pelanggan</th>
                            <th>Total Tagihan</th>
                            <th>Tipe Pembayaran</th>
                            <th>Status Pembayaran</th>
                            <th>Kwitansi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($pemesanan->isEmpty())
                            <tr>
                                <td colspan="7" style="text-align: center; padding: 3rem; color: #64748b;">
                                    Belum ada transaksi atau invoice terbit untuk klinik Anda.
                                </td>
                            </tr>
                        @else
                            @foreach($pemesanan as $order)
                            <tr class="searchable-row">
                                <td style="font-weight: 600; font-family: monospace; color: #6366f1;" class="searchable-name">
                                    {{ $order->kodePemesanan }}
                                </td>
                                <td>{{ $order->created_at ? $order->created_at->format('d M Y, H:i') : '-' }}</td>
                                <td>
                                    <div style="font-weight: 600;" class="searchable-name">{{ $order->user ? $order->user->username : '-' }}</div>
                                    <small style="color: #64748b;">{{ $order->user ? $order->user->phoneNumber : '-' }}</small>
                                </td>
                                <td style="font-weight: 600; color: #0f172a;">Rp {{ number_format($order->totalHarga, 0, ',', '.') }}</td>
                                <td>
                                    @if(strtolower($order->tipePembayaran) === 'kredit')
                                        <span class="status-badge" style="background: #eff6ff; color: #1e40af; border: 1px solid rgba(30, 64, 175, 0.2);"><i class="fas fa-calendar-alt"></i> Kredit 21 Hari</span>
                                    @else
                                        <span class="status-badge" style="background: #f1f5f9; color: #475569; border: 1px solid #cbd5e1;"><i class="fas fa-wallet"></i> Cash</span>
                                    @endif
                                </td>
                                <td>
                                    @if($order->status === 'Lunas')
                                        <span class="status-badge status-lunas"><i class="fas fa-check"></i> Lunas</span>
                                    @elseif($order->status === 'Batal')
                                        <span class="status-badge status-batal"><i class="fas fa-times"></i> Batal</span>
                                    @else
                                        <span class="status-badge status-pending"><i class="fas fa-clock"></i> Pending</span>
                                    @endif
                                </td>
                                <td>
                                    @if($order->status === 'Lunas')
                                    <a href="{{ route('cetakStruk', $order->id) }}" target="_blank" class="action-btn">
                                        <i class="fas fa-print"></i> Cetak Struk
                                    </a>
                                    @else
                                    <span class="status-badge status-pending"><i class="fas fa-clock"></i>Belum Lunas</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>

<script>
    function toggleSubRow(id, rowElement) {
        const subRow = document.getElementById(id);
        if (subRow) {
            if (subRow.classList.contains('active')) {
                subRow.classList.remove('active');
                rowElement.classList.remove('expanded');
            } else {
                subRow.classList.add('active');
                rowElement.classList.add('expanded');
            }
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');
        if (searchInput) {
            searchInput.addEventListener('keyup', function() {
                const query = this.value.toLowerCase();
                const rows = document.querySelectorAll('.searchable-row');
                
                rows.forEach(row => {
                    const nameElements = row.querySelectorAll('.searchable-name');
                    let match = false;
                    nameElements.forEach(el => {
                        if (el.textContent.toLowerCase().includes(query)) {
                            match = true;
                        }
                    });
                    
                    const onclickAttr = row.getAttribute('onclick');
                    const clickMatch = onclickAttr ? onclickAttr.match(/'([^']+)'/) : null;
                    const subRowId = clickMatch ? clickMatch[1] : null;
                    const subRow = subRowId ? document.getElementById(subRowId) : null;
                    
                    if (match) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                        if (subRow) {
                            subRow.classList.remove('active');
                            row.classList.remove('expanded');
                        }
                    }
                });
            });
        }
    });
</script>
@endsection
