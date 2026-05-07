@extends('layouts.adminLayout')

@section('content')
<div class="main-content">
    <header class="header">
        <div class="header-left">
            <button class="menu-toggle">
                <i class="fas fa-bars"></i>
            </button>
            <h1 id="page-title">Data Transaksi</h1>
        </div>
        <div class="search-box">
            <i class="fas fa-search"></i>
            <input type="text" placeholder="Cari transaksi..." id="searchInput">
        </div>
    </header>

    <section class="content-section active">
        @if (session('success'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
        @endif

        <div class="section-header">
            <h2>Daftar Transaksi</h2>
            <div>
                <span class="filter-btn">Total: {{ $pemesanan->count() }}</span>
            </div>
        </div>

        @if($pemesanan->isEmpty())
        <div class="table-container">
            <div style="padding: 3rem; text-align: center; color: #999;">
                <i class="fas fa-inbox" style="font-size: 3rem; margin-bottom: 1rem; display: block;"></i>
                <p>Belum ada transaksi</p>
            </div>
        </div>
        @else
        <div class="table-container">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Kode Pesanan</th>
                        <th>Nama Pembeli</th>
                        <th>Nomor HP</th>
                        <th>Total Harga</th>
                        <th>Status</th>
                        <th>Tanggal Pesanan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pemesanan as $item)
                    <tr>
                        <td>
                            <strong>{{ $item->kodePemesanan }}</strong>
                        </td>
                        <td>{{ $item->user->username ?? '-' }}</td>
                        <td>{{ $item->user->phoneNumber ?? '-' }}</td>
                        <td>Rp {{ number_format($item->totalHarga, 0, ',', '.') }}</td>
                        <td>
                            <span class="status {{ strtolower($item->status) }}">
                                {{ ucfirst($item->status) }}
                            </span>
                        </td>
                        <td>{{ $item->created_at->format('d/m/Y H:i') }}</td>
                        <td>
                            <!-- <button type="button" class="action-btn" onclick="viewDetail({{ $item->id }})" title="Lihat Detail">
                                <i class="fas fa-eye"></i>
                            </button> -->
                            <form action="{{ route('updatePemesanan', $item->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="status" value="{{ $item->status === 'pending' ? 'completed' : 'pending' }}">
                                <button type="submit" class="action-btn" title="Ubah Status">
                                    <i class="fas fa-sync-alt"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </section>
</div>

<!-- Modal Detail -->
<div id="detailModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Detail Transaksi</h3>
            <button type="button" class="close-modal" onclick="closeModal()">×</button>
        </div>
        <div class="admin-form" id="detailContent">
            <!-- Isi detail akan dimuat melalui AJAX -->
        </div>
    </div>
</div>

<style>
    .alert {
        padding: 1rem;
        border-radius: 8px;
        margin-bottom: 2rem;
    }

    .alert-success {
        background: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }

    .status.pending {
        background: #fff3cd;
        color: #856404;
    }

    .status.completed {
        background: #d4edda;
        color: #155724;
    }

    .status.cancelled {
        background: #f8d7da;
        color: #721c24;
    }
</style>

<script>
    function viewDetail(id) {
        fetch(`/pemesanan/${id}/detail`)
            .then(response => response.json())
            .then(data => {
                let html = `
                    <div style="margin-bottom: 1.5rem;">
                        <h4>Informasi Pesanan</h4>
                        <p><strong>Kode Pesanan:</strong> ${data.kodePemesanan}</p>
                        <p><strong>Nama Pembeli:</strong> ${data.user.username}</p>
                        <p><strong>Nomor HP:</strong> ${data.user.phoneNumber}</p>
                        <p><strong>Alamat:</strong> ${data.user.alamat || '-'}</p>
                        <p><strong>Total Harga:</strong> Rp ${new Intl.NumberFormat('id-ID').format(data.totalHarga)}</p>
                        <p><strong>Status:</strong> ${data.status}</p>
                        <p><strong>Tanggal Pesanan:</strong> ${new Date(data.created_at).toLocaleDateString('id-ID')}</p>
                    </div>
                    <div>
                        <h4>Detail Produk</h4>
                        <table class="data-table" style="font-size: 0.9rem;">
                            <thead>
                                <tr>
                                    <th>Nama Produk</th>
                                    <th>Jumlah</th>
                                    <th>Harga</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                ${data.details.map(detail => `
                                    <tr>
                                        <td>${detail.produk.namaProduk}</td>
                                        <td>${detail.jumlahBeli}</td>
                                        <td>Rp ${new Intl.NumberFormat('id-ID').format(detail.harga)}</td>
                                        <td>Rp ${new Intl.NumberFormat('id-ID').format(detail.harga * detail.jumlahBeli)}</td>
                                    </tr>
                                `).join('')}
                            </tbody>
                        </table>
                    </div>
                `;
                document.getElementById('detailContent').innerHTML = html;
                document.getElementById('detailModal').style.display = 'flex';
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Gagal memuat detail transaksi');
            });
    }

    function closeModal() {
        document.getElementById('detailModal').style.display = 'none';
    }

    window.onclick = function(event) {
        const modal = document.getElementById('detailModal');
        if (event.target == modal) {
            modal.style.display = 'none';
        }
    }
</script>

@endsection