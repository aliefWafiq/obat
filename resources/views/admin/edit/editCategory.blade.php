@extends('layouts.adminLayout')
@section('content')
<div class="main-content">
    <header class="header">
        <div class="header-left">
            <button class="menu-toggle">
                <i class="fas fa-bars"></i>
            </button>
            <h1 id="page-title">Edit Kategori</h1>
        </div>
    </header>
    <section id="dashboard" class="content-section active">
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div style="max-width: 600px; background: #fff; border-radius: 16px; padding: 2rem; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);">
            <form action="/category/update/{{ $category->id }}" method="POST" enctype="multipart/form-data" class="admin-form">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="namaCategory">
                        <i class="fas fa-tag"></i> Nama Kategori <span style="color: #ff4757;">*</span>
                    </label>
                    <input type="text" id="namaCategory" name="namaCategory" required placeholder="Masukkan nama kategori" value="{{ $category->namaCategory }}">
                </div>

                <div class="form-actions" style="margin-top: 2rem;">
                    <a href="{{ route('listCategory') }}" class="btn btn-secondary" style="background: #f8f9fa; color: #666; border: 2px solid #e9ecef; text-decoration: none;">
                        <i class="fas fa-arrow-left"></i> Batal
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-check"></i> Update Kategori
                    </button>
                </div>
            </form>
        </div>
    </section>
</div>

<style>
    .alert {
        padding: 1rem;
        border-radius: 8px;
        margin-bottom: 2rem;
    }

    .alert-danger {
        background: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }

    .alert ul {
        margin: 0;
        padding-left: 1.5rem;
    }

    .btn-secondary {
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-primary {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }
</style>
@endsection