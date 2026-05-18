@extends('layouts.adminLayout')

@section('content')
<div class="main-content">
    <header class="header">
        <div class="header-left">
            <button class="menu-toggle">
                <i class="fas fa-bars"></i>
            </button>
            <div>
                <h1 id="page-title">Tambah Diskon Baru</h1>
            </div>
        </div>
    </header>

    <section class="content-section active" style="display: flex; justify-content: center; padding: 2rem 1rem;">
        <div style="width: min(720px, 100%); background: #ffffff; border-radius: 24px; padding: 2rem; box-shadow: 0 18px 40px rgba(0,0,0,0.08);">
            @if ($errors->any())
            <div class="alert alert-danger" style="margin-bottom: 1.5rem;">
                <ul style="margin: 0; padding-left: 1.2rem;">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form action="{{ route('buatDiskon') }}" method="POST" enctype="multipart/form-data" class="admin-form">
                @csrf

                <p>Pilih Produk</p>
                <select name="produk_id" id="produk_id" style="width: 100%; padding: 0.85rem 1rem; border-radius: 12px; border: 1px solid #d1d5db; margin-bottom: 1.2rem; font-family: inherit;">
                    <option value="">Pilih Produk</option>
                    @foreach ($produk as $p)
                        <option value="{{ $p->id }}">{{ $p->namaProduk }}</option>
                    @endforeach
                </select>
                
                <p>Minimal Beli</p>
                <input type="number" name="minimalBeli" id="minimalBeli" placeholder="Contoh: 10" style="width: 100%; padding: 0.85rem 1rem; border-radius: 12px; border: 1px solid #d1d5db; margin-bottom: 1.2rem; font-family: inherit; box-sizing: border-box;">
                
                <p>Persentase Diskon (%)</p>
                <input type="number" name="diskon" id="diskon" placeholder="Contoh: 25" step="0.1" min="0" max="100" style="width: 100%; padding: 0.85rem 1rem; border-radius: 12px; border: 1px solid #d1d5db; margin-bottom: 1.2rem; font-family: inherit; box-sizing: border-box;">

                <div class="form-actions" style="margin-top: 1.8rem; display: flex; gap: 1rem; flex-wrap: wrap; justify-content: flex-end;">
                    <a href="{{ route('listDiskon') }}" class="btn btn-secondary" style="padding: 0.95rem 1.4rem; display: inline-flex; align-items: center; gap: 0.5rem; text-decoration: none;">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                    <button type="submit" class="btn btn-primary" style="padding: 0.95rem 1.6rem; display: inline-flex; align-items: center; gap: 0.6rem;">
                        <i class="fas fa-save"></i> Simpan Diskon
                    </button>
                </div>
            </form>
        </div>
    </section>
</div>
@endsection