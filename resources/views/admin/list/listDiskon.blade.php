@extends('layouts.adminLayout')

@section('content')
<div class="main-content">
    <header class="header">
        <div class="header-left">
            <button class="menu-toggle">
                <i class="fas fa-bars"></i>
            </button>
            <h1 id="page-title">Daftar Diskon</h1>
        </div>
    </header>
    <section id="dashboard" class="content-section active">
        <div class="section-header">
            <h2>Daftar Diskon</h2>
            <a href="{{ route('viewBuatDiskon') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Diskon
            </a>
        </div>

        @if (session('success'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
        @endif

        @if($buatDiskon->isEmpty())
        <div class="table-container">
            <div style="padding: 3rem; text-align: center; color: #999;">
                <i class="fas fa-t" style="font-size: 3rem; margin-bottom: 1rem; display: block;"></i>
                <p>Belum ada program diskon kuantitas. <a href="{{ route('buatDiskon') }}">Tambah diskon sekarang</a></p>
            </div>
        </div>
        @else
        <div class="table-container">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th>Minimal Beli</th>
                        <th>Diskon (%)</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($buatDiskon as $diskon)
                    <tr>
                        <td>
                            <strong>{{ $diskon->produk ? $diskon->produk->namaProduk : 'Produk Tidak Ditemukan' }}</strong>
                        </td>
                        <td>
                            <span style="font-weight: 600; color: #4b5563;">{{ $diskon->minimalBeli }} unit</span>
                        </td>
                        <td>
                            <span style="font-weight: 700; color: #16a34a; background: #dcfce7; padding: 0.25rem 0.5rem; border-radius: 6px;">{{ $diskon->diskon }}%</span>
                        </td>
                        <td>
                            <a href="{{ route('editDiskon', $diskon->id) }}" class="action-btn" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('deleteDiskon', $diskon->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="action-btn" title="Hapus" onclick="return confirm('Apakah Anda yakin ingin menghapus diskon ini?')">
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