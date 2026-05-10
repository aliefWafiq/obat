@extends('layouts.adminLayout')

@section('content')
<div class="main-content">
    <header class="header">
        <div class="header-left">
            <button class="menu-toggle">
                <i class="fas fa-bars"></i>
            </button>
            <div>
                <h1 id="page-title">Tambah Program Baru</h1>
                <p style="margin: 0.3rem 0 0; color: #6b7280;">Buat program promosi baru untuk menampilkan diskon, promo paket, atau event khusus.</p>
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

            <form action="/program/create" method="POST" enctype="multipart/form-data" class="admin-form">
                @csrf

                <div class="form-group">
                    <label for="gambar">
                        <i class="fas fa-image"></i> Gambar Program
                    </label>
                    <input type="file" id="gambar" name="gambar" accept="image/*">
                </div>

                <div class="form-group">
                    <label for="tagProgram">
                        <i class="fas fa-tags"></i> Tag Program
                    </label>
                    <input type="text" id="tagProgram" name="tagProgram" placeholder="Contoh: Diskon, Flash Sale, Paket Hemat" value="{{ old('tagProgram') }}">
                </div>

                <div class="form-group">
                    <label for="judul">
                        <i class="fas fa-heading"></i> Judul Program
                    </label>
                    <input type="text" id="judul" name="judul" placeholder="Masukkan judul program" value="{{ old('judul') }}">
                </div>

                <div class="form-group">
                    <label for="deskripsi">
                        <i class="fas fa-align-left"></i> Deskripsi Program
                    </label>
                    <textarea id="deskripsi" name="deskripsi" placeholder="Jelaskan detail program, syarat, dan manfaatnya" style="min-height: 150px;">{{ old('deskripsi') }}</textarea>
                </div>

                <div class="form-actions" style="margin-top: 1.8rem; display: flex; gap: 1rem; flex-wrap: wrap; justify-content: flex-end;">
                    <a href="{{ route('listProgram') }}" class="btn btn-secondary" style="padding: 0.95rem 1.4rem; display: inline-flex; align-items: center; gap: 0.5rem; text-decoration: none;">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                    <button type="submit" class="btn btn-primary" style="padding: 0.95rem 1.6rem; display: inline-flex; align-items: center; gap: 0.6rem;">
                        <i class="fas fa-save"></i> Simpan Program
                    </button>
                </div>
            </form>
        </div>
    </section>
</div>
@endsection