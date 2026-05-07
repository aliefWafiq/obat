@extends('layouts.adminLayout')
@section('content')
<div class="main-content">
    <header class="header">
        <div class="header-left">
            <button class="menu-toggle">
                <i class="fas fa-bars"></i>
            </button>
            <h1 id="page-title">Daftar Kategori</h1>
        </div>
    </header>
    <section id="dashboard" class="content-section active">
        <div class="section-header">
            <h2>Daftar Kategori</h2>
            <a href="{{ route('viewCreateCategory') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Kategori
            </a>
        </div>

        @if (session('success'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
        @endif

        @if($categories->isEmpty())
        <div class="table-container">
            <div style="padding: 3rem; text-align: center; color: #999;">
                <i class="fas fa-inbox" style="font-size: 3rem; margin-bottom: 1rem; display: block;"></i>
                <p>Belum ada kategori. <a href="{{ route('viewCreateCategory') }}">Tambah kategori sekarang</a></p>
            </div>
        </div>
        @else
        <div class="table-container">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Nama Kategori</th>
                        <th>Jumlah Produk</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categories as $item)
                    <tr>
                        <td>
                            <strong>{{ $item->namaCategory }}</strong>
                        </td>
                        <td>
                            <span class="status active">
                                {{ $item->produk->count() }} produk
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('viewEditCategory', $item->id) }}" class="action-btn" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('deleteCategory', $item->id) }}" method="POST" style="display: inline;">
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
</style>
@endsection