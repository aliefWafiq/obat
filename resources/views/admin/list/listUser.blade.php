@extends('layouts.adminLayout')

@section('content')
<div class="main-content">
    <header class="header">
        <div class="header-left">
            <button class="menu-toggle">
                <i class="fas fa-bars"></i>
            </button>
            <h1 id="page-title">Daftar Akun</h1>
        </div>
        <div class="search-box">
            <i class="fas fa-search"></i>
            <input type="text" placeholder="Cari pengguna..." id="searchInput">
        </div>
    </header>

    <section class="content-section active">
        @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif

        <div class="section-header">
            <h2>Daftar Akun</h2>
            <div>
                <span class="filter-btn">Total: {{ $users->count() }}</span>
            </div>
        </div>

        <div class="account-management-grid">
            <div class="account-main-panel">
                <div class="account-summary-grid">
                    <div class="account-summary-card primary">
                        <div>
                            <h3>{{ $users->count() }}</h3>
                            <p>Total Akun Terdaftar</p>
                        </div>
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="account-summary-card secondary">
                        <div>
                            <h3>{{ $users->where('role', 'Admin')->count() }}</h3>
                            <p>Akun Admin</p>
                        </div>
                        <i class="fas fa-user-shield"></i>
                    </div>
                    <div class="account-summary-card accent">
                        <div>
                            <h3>{{ $users->where('role', 'User')->count() }}</h3>
                            <p>Akun Pengguna</p>
                        </div>
                        <i class="fas fa-user-friends"></i>
                    </div>
                </div>

                @if($users->isEmpty())
                <div class="table-container">
                    <div class="admin-form">
                        <p>Belum ada akun pengguna.</p>
                    </div>
                </div>
                @else
                <div class="table-container">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Username</th>
                                <th>Nomor HP</th>
                                <th>Alamat</th>
                                <th>Role</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $item)
                            <tr>
                                <td>{{ $item->username }}</td>
                                <td>{{ $item->phoneNumber }}</td>
                                <td>{{ $item->alamat ?: '-' }}</td>
                                <td>
                                    <div class="role-edit-inline">
                                        <span class="role-badge {{ $item->role == 'admin' ? 'role-admin' : 'role-user' }}">{{ ucfirst($item->role) }}</span>
                                    </div>
                                </td>
                                <td>
                                    <a href="{{ route('viewEditUser', $item->id) }}" class="action-btn" title="Edit User">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('deleteUser', $item->id) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="action-btn" title="Hapus User">
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
            </div>

            <aside class="account-sidebar">
                <div class="admin-add-card">
                    <div class="card-header">
                        <h3>Tambah Admin Baru</h3>
                    </div>
                    <form class="admin-form" action="{{ route('registerKlinik') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label>Nama Klinik</label>
                            @error('username')
                            <span class="error">{{ $message }}</span>
                            @enderror
                            <input type="text" placeholder="Masukkan nama" name="username" />
                        </div>
                        <div class="form-group">
                            <label>Nomor HP</label>
                            @error('phoneNumber')
                            <span class="error">{{ $message }}</span>
                            @enderror
                            <input type="text" placeholder="Masukkan nomor HP" name="phoneNumber" />
                        </div>
                        <div class="form-group">
                            <label for="alamat">Alamat Lengkap</label>
                            @error('alamat')
                            <span class="error">{{ $message }}</span>
                            @enderror
                            <textarea id="alamat" name="alamat" placeholder="Jln. Contoh No. 123, Kota, Provinsi, Kode Pos">{{ old('alamat') }}</textarea>
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            @error('password')
                            <span class="error">{{ $message }}</span>
                            @enderror
                            <input type="password" placeholder="Password" name="password" />
                        </div>
                        <div class="form-group">
                            <label>Role</label>
                            <select name="role">
                                <option value="Admin">Admin</option>
                                <option value="SuperAdmin">Super Admin</option>
                            </select>
                        </div>
                        <button type="submit" class="export-btn" style="width:100%;">Buat Admin</button>
                    </form>
                </div>
            </aside>
        </div>
    </section>
</div>
@endsection