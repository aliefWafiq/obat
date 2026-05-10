@extends('layouts.adminLayout')

@section('content')
<div class="main-content">
    <header class="header">
        <div class="header-left">
            <button class="menu-toggle">
                <i class="fas fa-bars"></i>
            </button>
            <h1 id="page-title">Edit Akun Pengguna</h1>
        </div>
    </header>

    <section class="content-section active" style="display: flex; justify-content: center; padding: 2rem 1rem;">
        <div style="width: min(700px, 100%); background: #ffffff; border-radius: 24px; padding: 2rem; box-shadow: 0 18px 40px rgba(0,0,0,0.08);">
            @if (session('success'))
            <div class="alert alert-success" style="margin-bottom: 1.5rem;">
                {{ session('success') }}
            </div>
            @endif

            @if ($errors->any())
            <div class="alert alert-danger" style="margin-bottom: 1.5rem;">
                <ul style="margin: 0; padding-left: 1.2rem;">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <div style="display: flex; justify-content: space-between; align-items: center; gap: 1rem; flex-wrap: wrap; margin-bottom: 1.5rem;">
                <div>
                    <h2 style="margin: 0; font-size: 1.75rem;">Detail Akun</h2>
                    <p style="margin: 0.5rem 0 0; color: #6b7280;">Perbarui informasi pengguna dengan cepat dan aman.</p>
                </div>
                <a href="{{ route('listUser') }}" class="btn btn-secondary" style="padding: 0.9rem 1.4rem; font-size: 0.95rem; display: inline-flex; align-items: center; gap: 0.6rem;">
                    <i class="fas fa-arrow-left"></i> Kembali ke daftar
                </a>
            </div>

            <form action="{{ route('updateUser', $users->id) }}" method="POST" class="admin-form">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="username">
                        <i class="fas fa-user"></i> Username <span style="color: #ff4757;">*</span>
                    </label>
                    <input type="text" id="username" name="username" required placeholder="Masukkan username" value="{{ old('username', $users->username) }}">
                </div>

                <div class="form-group">
                    <label for="phoneNumber">
                        <i class="fas fa-phone"></i> Nomor HP <span style="color: #ff4757;">*</span>
                    </label>
                    <input type="text" id="phoneNumber" name="phoneNumber" required placeholder="08xxxxxxxxxx" value="{{ old('phoneNumber', $users->phoneNumber) }}">
                </div>

                <div class="form-group">
                    <label for="alamat">
                        <i class="fas fa-map-marker-alt"></i> Alamat Lengkap <span style="color: #ff4757;">*</span>
                    </label>
                    <textarea id="alamat" name="alamat" placeholder="Masukkan alamat lengkap" style="min-height: 130px;">{{ old('alamat', $users->alamat) }}</textarea>
                </div>

                <div class="form-group">
                    <label for="role">
                        <i class="fas fa-user-tag"></i> Role <span style="color: #ff4757;">*</span>
                    </label>
                    <select id="role" name="role" required>
                        <option value="user" {{ old('role', $users->role) === 'user' ? 'selected' : '' }}>User</option>
                        <option value="admin" {{ old('role', $users->role) === 'admin' ? 'selected' : '' }}>Admin</option>
                    </select>
                </div>

                <div class="form-actions" style="margin-top: 1.8rem; display: flex; gap: 1rem; flex-wrap: wrap; justify-content: flex-end;">
                    <a href="{{ route('listUser') }}" class="btn btn-secondary" style="padding: 0.95rem 1.4rem; display: inline-flex; align-items: center; gap: 0.5rem;">
                        <i class="fas fa-times"></i> Batal
                    </a>
                    <button type="submit" class="btn btn-primary" style="padding: 0.95rem 1.6rem; display: inline-flex; align-items: center; gap: 0.6rem;">
                        <i class="fas fa-check"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </section>
</div>
@endsection