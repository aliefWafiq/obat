@extends('layouts.adminLayout')

@section('content')
<div class="main-content">
    <header class="header">
        <div class="header-left">
            <button class="menu-toggle">
                <i class="fas fa-bars"></i>
            </button>
            <div>
                <h1 id="page-title">Program ObatKita</h1>
                <p style="margin: 0.3rem 0 0; color: #6b7280;">Kelola program promosi, diskon, dan penawaran khusus untuk ObatKita.com.</p>
            </div>
        </div>
        <a href="{{ route('viewBuatProgram') }}" class="btn btn-primary" style="padding: 0.9rem 1.4rem; display: inline-flex; align-items: center; gap: 0.6rem;">
            <i class="fas fa-plus"></i> Tambah Program
        </a>
    </header>

    <section class="content-section active" style="padding: 1rem 2rem 2rem;">
        @if (session('success'))
        <div class="alert alert-success" style="margin-bottom: 1.5rem;">
            {{ session('success') }}
        </div>
        @endif

        @if (session('error'))
        <div class="alert alert-danger" style="margin-bottom: 1.5rem;">
            {{ session('error') }}
        </div>
        @endif

        @if($buatProgram->isEmpty())
        <div class="empty-state" style="background: #ffffff; border-radius: 24px; padding: 3rem; text-align: center; box-shadow: 0 18px 40px rgba(0,0,0,0.06);">
            <i class="fas fa-bullhorn" style="font-size: 2.5rem; color: #0ea5e9;"></i>
            <h2 style="margin-top: 1rem;">Belum ada program</h2>
            <p style="color: #6b7280; max-width: 520px; margin: 0.75rem auto 1.5rem;">Tambahkan program promosi seperti diskon, cashback, atau penawaran khusus agar pengguna tahu aktivitas terbaru ObatKita.</p>
            <a href="{{ route('viewBuatProgram') }}" class="btn btn-primary" style="padding: 0.95rem 1.6rem;">
                <i class="fas fa-plus"></i> Buat Program Baru
            </a>
        </div>
        @else
        <div class="program-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1.5rem;">
            @foreach ($buatProgram as $program)
            <article class="program-card" style="background: #ffffff; border-radius: 24px; overflow: hidden; box-shadow: 0 18px 40px rgba(0,0,0,0.05); display: flex; flex-direction: column;">
                <div style="position: relative; min-height: 180px; overflow: hidden;">
                    <div style="width: 100%; height: 200px;">
                        <img src="{{ asset('storage/' . $program->gambar) }}" alt="{{ $program->judul }}" style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                    <span style="position: absolute; top: 1rem; left: 1rem; background: rgba(15, 23, 42, 0.85); color: #fff; padding: 0.45rem 0.85rem; border-radius: 999px; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.02em;">{{ $program->tagProgram }}</span>
                </div>
                <div style="padding: 1.5rem; display: flex; flex-direction: column; gap: 1rem; flex: 1;">
                    <div>
                        <h3 style="margin: 0 0 0.55rem; font-size: 1.25rem; line-height: 1.3;">{{ $program->judul }}</h3>
                        <p style="margin: 0; color: #4b5563; line-height: 1.7;">{{ $program->deskripsi }}</p>
                    </div>

                    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 0.75rem; margin-top: auto;">
                        
                        <div style="display: flex; gap: 0.75rem; flex-wrap: wrap;">
                            <a href="{{ route('viewEditProgram', $program->id) }}" class="btn btn-secondary" style="padding: 0.7rem 1rem; display: inline-flex; align-items: center; gap: 0.4rem; text-decoration: none;">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <form action="{{ route('deleteProgram', $program->id) }}" method="POST" onsubmit="return confirm('Hapus program ini?');" style="display: inline-flex;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" style="padding: 0.7rem 1rem; display: inline-flex; align-items: center; gap: 0.4rem; border: none; cursor: pointer;">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </article>
            @endforeach
        </div>
        @endif
    </section>
</div>
@endsection