@extends('layouts.adminLayout')
@section('content')
<div class="main-content">
    <header class="header">
        <div class="header-left">
            <button class="menu-toggle">
                <i class="fas fa-bars"></i>
            </button>
            <h1 id="page-title">Daftar Produk</h1>
        </div>
    </header>
    <section id="dashboard" class="content-section active">
        <div class="section-header">
            <h2>Daftar Produk</h2>
            <a href="{{ route('viewCreateProduk') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Produk
            </a>
        </div>

        @if (session('success'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
        @endif

        @if($produk->isEmpty())
        <div class="table-container">
            <div style="padding: 3rem; text-align: center; color: #999;">
                <i class="fas fa-inbox" style="font-size: 3rem; margin-bottom: 1rem; display: block;"></i>
                <p>Belum ada produk. <a href="{{ route('viewCreateProduk') }}">Tambah produk sekarang</a></p>
            </div>
        </div>
        @else
        <div class="table-container">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Gambar</th>
                        <th>Nama Produk</th>
                        <th>Kategori</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($produk as $item)
                    <tr>
                        <td>
                            @if($item->gambar)
                            <img src="{{ asset('storage/' . $item->gambar) }}" alt="{{ $item->namaProduk }}" style="width: 50px; height: 50px; object-fit: cover; border-radius: 8px;">
                            @else
                            <div style="width: 50px; height: 50px; background: #f0f0f0; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #999;">
                                <i class="fas fa-image"></i>
                            </div>
                            @endif
                        </td>
                        <td>
                            <strong>{{ $item->namaProduk }}</strong>
                            <br>
                            <small style="color: #999;">{{ Str::limit($item->deskripsi, 50) }}</small>
                        </td>
                        <td>{{ $item->category->namaCategory ?? 'N/A' }}</td>
                        <td>
                            <strong>Rp {{ number_format($item->harga, 0, ',', '.') }}</strong>
                        </td>
                        <td>
                            <span class="status {{ $item->stok > 0 ? 'active' : 'completed' }}">
                                {{ $item->stok }} unit
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('viewEditProduk', $item->id) }}" class="action-btn" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('deleteProduk', $item->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="action-btn" title="Hapus">
                                    <i class="fas fa-trash"></i>
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
@endsection