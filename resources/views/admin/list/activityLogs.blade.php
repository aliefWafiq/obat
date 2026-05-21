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

    /* Pagination Styling */
    .pagination-wrapper {
        margin-top: 1.5rem;
        display: flex;
        justify-content: center;
        padding-bottom: 1.5rem;
    }
    .pagination {
        display: flex;
        list-style: none;
        padding: 0;
        margin: 0;
        gap: 0.35rem;
    }
    .page-item {
        display: inline-block;
    }
    .page-link {
        display: flex;
        align-items: center;
        justify-content: center;
        min-width: 36px;
        height: 36px;
        padding: 0 0.75rem;
        font-size: 0.85rem;
        font-weight: 600;
        color: #64748b;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        text-decoration: none;
        transition: all 0.2s ease;
        cursor: pointer;
    }
    .page-link:hover {
        background: #f1f5f9;
        color: #0f172a;
        border-color: #cbd5e1;
    }
    .page-item.active .page-link {
        background: rgba(99, 102, 241, 0.08);
        color: #6366f1;
        border-color: rgba(99, 102, 241, 0.2);
    }
    .page-item.disabled .page-link {
        color: #cbd5e1;
        pointer-events: none;
        background: #f8fafc;
        border-color: #e2e8f0;
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
                @forelse($logs as $log)
                    @php
                        $dataType = 'info';
                        $iconClass = 'fa-info-circle';
                        $iconColor = 'info';

                        if ($log->activity === 'auth') {
                            if (str_contains(strtolower($log->description), 'registrasi')) {
                                $dataType = 'success';
                                $iconClass = 'fa-user-plus';
                                $iconColor = 'success';
                            } else {
                                $dataType = 'warning';
                                $iconClass = str_contains(strtolower($log->description), 'login') ? 'fa-sign-in-alt' : 'fa-sign-out-alt';
                                $iconColor = 'warning';
                            }
                        } elseif ($log->activity === 'transaction') {
                            if (str_contains(strtolower($log->description), 'lunas')) {
                                $dataType = 'success';
                                $iconColor = 'success';
                                $iconClass = 'fa-check-circle';
                            } else {
                                $dataType = 'success';
                                $iconColor = 'info';
                                $iconClass = 'fa-shopping-cart';
                            }
                        } elseif ($log->activity === 'product') {
                            $dataType = 'info';
                            $iconColor = 'info';
                            if (str_contains(strtolower($log->description), 'menambahkan')) {
                                $iconClass = 'fa-plus-circle';
                            } elseif (str_contains(strtolower($log->description), 'menghapus')) {
                                $iconClass = 'fa-trash-alt';
                                $iconColor = 'danger';
                            } else {
                                $iconClass = 'fa-edit';
                            }
                        } elseif ($log->activity === 'stock') {
                            $dataType = 'info';
                            $iconColor = 'info';
                            $iconClass = 'fa-boxes';
                        } elseif ($log->activity === 'setting') {
                            $dataType = 'info';
                            $iconColor = 'warning';
                            $iconClass = 'fa-cog';
                        }

                        $timeAgo = $log->created_at ? $log->created_at->diffForHumans() : 'Baru saja';
                        $username = $log->user ? $log->user->username : 'System';
                        $role = $log->user ? $log->user->role : 'Sistem';
                    @endphp
                    <div class="log-item filterable-log" data-type="{{ $dataType }}">
                        <div class="log-icon {{ $iconColor }}">
                            <i class="fas {{ $iconClass }}"></i>
                        </div>
                        <div class="log-details">
                            <p class="log-title">
                                {!! e($log->description) !!}
                                @if($log->user)
                                    <span style="color: #64748b; font-size: 0.8rem;">(oleh <strong>{{ $username }}</strong> [{{ $role }}])</span>
                                @endif
                            </p>
                            <div class="log-meta">
                                <span class="log-time"><i class="far fa-clock"></i> {{ $timeAgo }}</span>
                                <span class="log-ip">IP: {{ $log->ip_address ?? '127.0.0.1' }}</span>
                                <span>• {{ ucfirst($log->activity) }}</span>
                            </div>
                        </div>
                    </div>
                @empty
                    <div style="padding: 3rem; text-align: center; color: #64748b;">
                        <i class="fas fa-history" style="font-size: 2.5rem; margin-bottom: 1rem; color: #cbd5e1;"></i>
                        <p style="font-size: 0.95rem; font-weight: 500;">Belum ada log aktivitas yang tercatat.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <div class="pagination-wrapper">
            {{ $logs->links('pagination::bootstrap-4') }}
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
