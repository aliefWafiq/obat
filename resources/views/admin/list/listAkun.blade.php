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
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
        @endif

        <div class="section-header">
            <h2>Daftar Akun</h2>
            <div>
                <span class="filter-btn">Total: {{ $users->count() }} Akun</span>
            </div>
        </div>

            <div class="account-management-grid{{ auth()->user()->role !== 'SuperAdmin' ? ' full-width' : '' }}">
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
                                <p>Akun Admin (Klinik)</p>
                            </div>
                            <i class="fas fa-user-shield"></i>
                        </div>
                        <div class="account-summary-card accent">
                            <div>
                                <h3>{{ $users->where('role', 'User')->count() }}</h3>
                                <p>Akun Pengguna (Dokter)</p>
                            </div>
                            <i class="fas fa-user-friends"></i>
                        </div>
                    </div>

                    {{-- Tabs Navigation --}}
                    <div class="tabs-container" style="margin-top: 1.5rem; margin-bottom: 0.5rem; display: flex; gap: 8px; border-bottom: 2px solid #e2e8f0;">
                        <button class="tab-btn active" onclick="switchTab(event, 'akun-tab')" style="background: none; border: none; padding: 10px 16px; font-weight: 600; font-size: 0.9rem; color: #6366f1; border-bottom: 2px solid #6366f1; cursor: pointer; transition: all 0.2s; margin-bottom: -2px;">
                            <i class="fas fa-users-cog" style="margin-right: 6px;"></i> Daftar Akun
                        </button>
                        <button class="tab-btn" onclick="switchTab(event, 'klinik-tab')" style="background: none; border: none; padding: 10px 16px; font-weight: 600; font-size: 0.9rem; color: #64748b; cursor: pointer; transition: all 0.2s; margin-bottom: -2px;">
                            <i class="fas fa-clinic-medical" style="margin-right: 6px;"></i> Data Klinik
                        </button>
                    </div>

                    <div id="akun-tab" class="tab-pane">
                        @if($users->isEmpty())
                        <div class="data-card" style="margin-top: 1.5rem; padding: 3rem; text-align: center; color: #64748b;">
                            <i class="fas fa-inbox" style="font-size: 2rem; margin-bottom: 1rem; color: #cbd5e1; display: block;"></i>
                            Belum ada akun pengguna.
                        </div>
                        @else
                        <div class="data-card" style="margin-top: 1rem;">
                            <table class="formal-table" id="accountsTable">
                                <thead>
                                    <tr>
                                        <th style="width: 40px;"></th>
                                        <th>Profil Akun / Klinik</th>
                                        <th>Kontak & Lokasi</th>
                                        <th>Status / Peran</th>
                                        @if(auth()->user()->role === 'SuperAdmin')
                                        <th>Aksi</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- 1. DISPLAY SUPER ADMINS --}}
                                    @if(auth()->user()->role === 'SuperAdmin')
                                    @foreach ($users->where('role', 'SuperAdmin') as $item)
                                    <tr class="main-row searchable-row" style="background: rgba(99, 102, 241, 0.02);">
                                        <td style="text-align: center;">
                                            <i class="fas fa-lock" style="color: #cbd5e1; font-size: 0.8rem;"></i>
                                        </td>
                                        <td>
                                            <div class="user-info-cell">
                                                <div class="user-icon" style="background: rgba(99, 102, 241, 0.1); color: #6366f1;">
                                                    <i class="fas fa-crown"></i>
                                                </div>
                                                <div class="user-details">
                                                    <h4 class="searchable-name">{{ $item->username }}</h4>
                                                    <span>ID: #{{ str_pad($item->id, 4, '0', STR_PAD_LEFT) }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td data-label="Kontak">
                                            <div style="color: #334155;"><i class="fas fa-phone-alt" style="color: #94a3b8; width: 20px;"></i> {{ $item->phoneNumber }}</div>
                                        </td>
                                        <td data-label="Peran">
                                            <span class="role-badge role-superadmin">Super Admin</span>
                                        </td>
                                        <td data-label="Aksi">
                                            <div class="action-links">
                                                <a href="{{ route('viewEditUser', $item->id) }}" class="action-link">Edit</a>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @endif

                                    {{-- 2. DISPLAY ADMINS WITH EXPANDABLE SUB-USERS --}}
                                    @foreach ($users->where('role', 'Admin') as $item)
                                    @if (auth()->user()->role === 'SuperAdmin' || auth()->user()->idKlinik === $item->idKlinik)
                                    @php
                                    $clinicDoctors = $users->where('role', 'User')->where('idKlinik', $item->idKlinik);
                                    @endphp
                                    <tr class="main-row searchable-row" data-admin-id="{{ $item->id }}" onclick="toggleSubRow('users-of-{{ $item->id }}', this)">
                                        <td style="text-align: center;">
                                            <i class="fas fa-chevron-right expand-indicator"></i>
                                        </td>
                                        <td>
                                            <div class="user-info-cell">
                                                <div class="user-icon" style="background: rgba(59, 130, 246, 0.1); color: #3b82f6; border-radius: 8px;">
                                                    <i class="fas fa-hospital"></i>
                                                </div>
                                                <div class="user-details">
                                                    <h4 class="searchable-name">{{ $item->username }}</h4>
                                                    <span>Kode: {{ $item->klinik ? $item->klinik->kodeKlinik : '-' }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td data-label="Kontak">
                                            <div style="color: #334155; margin-bottom: 2px;"><i class="fas fa-phone-alt" style="color: #94a3b8; width: 20px;"></i> {{ $item->phoneNumber }}</div>
                                            <div style="font-size: 0.8rem; color: #64748b; padding-left: 20px;">{{ $item->alamat ?: '-' }}</div>
                                        </td>
                                        <td data-label="Status">
                                            <span class="role-badge role-admin" style="margin-right: 5px;">Admin</span>
                                            <span class="clinic-badge">{{ $clinicDoctors->count() }} Dokter</span>
                                        </td>
                                        @if(auth()->user()->role === 'SuperAdmin')
                                        <td onclick="event.stopPropagation()" data-label="Aksi">
                                            <div class="action-links">
                                                <a href="{{ route('viewEditUser', $item->id) }}" class="action-link">Edit</a>
                                                <span style="color: #cbd5e1;">|</span>
                                                <form action="{{ route('deleteUser', $item->id) }}" method="POST" onsubmit="return confirm('Menghapus Admin ini juga akan menghapus klinik terkait. Lanjutkan?');" style="margin: 0; display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="action-link delete">Hapus</button>
                                                </form>
                                            </div>
                                        </td>
                                        @endif
                                    </tr>

                                    {{-- Expanded Doctors Row --}}
                                    <tr class="sub-row" id="users-of-{{ $item->id }}">
                                        <td colspan="{{ auth()->user()->role === 'SuperAdmin' ? 5 : 4 }}" style="padding: 0;">
                                            <div class="sub-table-container">
                                                <h5 style="margin: 0 0 0.75rem 0; color: #1e293b; font-size: 0.9rem;">
                                                    <i class="fas fa-user-md" style="color: #6366f1; margin-right: 6px;"></i>
                                                    Daftar Dokter Bertugas di {{ $item->username }}
                                                </h5>

                                                @if($clinicDoctors->isEmpty())
                                                <div class="empty-sub-state" style="padding: 1.5rem; text-align: center; color: #64748b; border: 1px dashed #e2e8f0; border-radius: 8px;">
                                                    Tidak ada dokter ditugaskan di klinik ini.
                                                </div>
                                                @else
                                                <table class="sub-table">
                                                    <thead>
                                                        <tr>
                                                            <th>Nama Dokter</th>
                                                            <th>Kontak</th>
                                                            <th>Alamat</th>
                                                            @if(auth()->user()->role === 'SuperAdmin')
                                                            <th>Pindah Penugasan</th>
                                                            <th>Aksi</th>
                                                            @endif
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($clinicDoctors as $doc)
                                                        <tr>
                                                            <td>
                                                                <div style="display: flex; align-items: center; gap: 0.5rem; font-weight: 600; color: #0f172a;">
                                                                    <i class="fas fa-user-md" style="color: #94a3b8;"></i>
                                                                    {{ $doc->username }}
                                                                </div>
                                                            </td>
                                                            <td data-label="Kontak">{{ $doc->phoneNumber }}</td>
                                                            <td data-label="Alamat">{{ $doc->alamat ?: '-' }}</td>
                                                            @if(auth()->user()->role === 'SuperAdmin')
                                                            <td data-label="Penugasan">
                                                                <form action="{{ route('reassignUserClinic', $doc->id) }}" method="POST" style="margin: 0;">
                                                                    @csrf
                                                                    @method('PUT')
                                                                    <select name="idKlinik" class="formal-select" onchange="this.form.submit()">
                                                                        <option value="">-- Pindah Klinik --</option>
                                                                        @foreach($clinics as $c)
                                                                        <option value="{{ $c->id }}" {{ $doc->idKlinik == $c->id ? 'selected' : '' }}>
                                                                            {{ $c->namaKlinik }}
                                                                        </option>
                                                                        @endforeach
                                                                    </select>
                                                                </form>
                                                            </td>
                                                            <td data-label="Aksi">
                                                                <div class="action-links">
                                                                    <a href="{{ route('viewEditUser', $doc->id) }}" class="action-link">Edit</a>
                                                                    <span style="color: #cbd5e1;">|</span>
                                                                    <form action="{{ route('deleteUser', $doc->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus dokter ini?');" style="margin: 0; display: inline;">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit" class="action-link delete">Hapus</button>
                                                                    </form>
                                                                </div>
                                                            </td>
                                                            @endif
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    @endif
                                    @endforeach

                                    {{-- 3. DISPLAY UNASSIGNED DOCTORS (POOL) --}}
                                    @php
                                    $unassignedDoctors = $users->where('role', 'User')->whereNull('idKlinik');
                                    @endphp
                                    @if($unassignedDoctors->isNotEmpty())
                                    <tr class="main-row searchable-row" data-admin-id="unassigned" onclick="toggleSubRow('users-of-unassigned', this)" style="background: rgba(239, 68, 68, 0.01);">
                                        <td style="text-align: center;">
                                            <i class="fas fa-chevron-right expand-indicator" style="color: #ef4444;"></i>
                                        </td>
                                        <td>
                                            <div class="user-info-cell">
                                                <div class="user-icon" style="background: #fff1f2; color: #ef4444; border-radius: 8px;">
                                                    <i class="fas fa-exclamation-triangle"></i>
                                                </div>
                                                <div class="user-details">
                                                    <h4 class="searchable-name" style="color: #b91c1c;">Dokter Tanpa Klinik (Pool)</h4>
                                                    <span style="color: #ef4444;">Status: Belum Terdistribusi</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td data-label="Kontak">-</td>
                                        <td data-label="Status">
                                            <span class="role-badge role-unassigned" style="margin-right: 5px;">Pool</span>
                                            <span class="clinic-badge unassigned-badge">{{ $unassignedDoctors->count() }} Dokter</span>
                                        </td>
                                        @if(auth()->user()->role === 'SuperAdmin')
                                        <td data-label="Aksi">-</td>
                                        @endif
                                    </tr>

                                    {{-- Expanded Pool Row --}}
                                    <tr class="sub-row" id="users-of-unassigned">
                                        <td colspan="{{ auth()->user()->role === 'SuperAdmin' ? 5 : 4 }}" style="padding: 0;">
                                            <div class="sub-table-container">
                                                <h5 style="margin: 0 0 0.75rem 0; color: #b91c1c; font-size: 0.9rem;">
                                                    <i class="fas fa-exclamation-circle" style="color: #ef4444; margin-right: 6px;"></i>
                                                    Daftar Dokter Belum Ditugaskan
                                                </h5>
                                                <table class="sub-table">
                                                    <thead>
                                                        <tr>
                                                            <th>Nama Dokter</th>
                                                            <th>Kontak</th>
                                                            <th>Alamat</th>
                                                            @if(auth()->user()->role === 'SuperAdmin')
                                                            <th>Tentukan Penugasan</th>
                                                            <th>Aksi</th>
                                                            @endif
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($unassignedDoctors as $doc)
                                                        <tr>
                                                            <td>
                                                                <div style="display: flex; align-items: center; gap: 0.5rem; font-weight: 600; color: #0f172a;">
                                                                    <i class="fas fa-user-md" style="color: #f87171;"></i>
                                                                    {{ $doc->username }}
                                                                </div>
                                                            </td>
                                                            <td data-label="Kontak">{{ $doc->phoneNumber }}</td>
                                                            <td data-label="Alamat">{{ $doc->alamat ?: '-' }}</td>
                                                            @if(auth()->user()->role === 'SuperAdmin')
                                                            <td data-label="Penugasan">
                                                                <form action="{{ route('reassignUserClinic', $doc->id) }}" method="POST" style="margin: 0;">
                                                                    @csrf
                                                                    @method('PUT')
                                                                    <select name="idKlinik" class="formal-select" onchange="this.form.submit()">
                                                                        <option value="">Pilih Klinik...</option>
                                                                        @foreach($clinics as $c)
                                                                        <option value="{{ $c->id }}">
                                                                            {{ $c->namaKlinik }}
                                                                        </option>
                                                                        @endforeach
                                                                    </select>
                                                                </form>
                                                            </td>
                                                            <td data-label="Aksi">
                                                                <div class="action-links">
                                                                    <a href="{{ route('viewEditUser', $doc->id) }}" class="action-link">Edit</a>
                                                                    <span style="color: #cbd5e1;">|</span>
                                                                    <form action="{{ route('deleteUser', $doc->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus dokter ini?');" style="margin: 0; display: inline;">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit" class="action-link delete">Hapus</button>
                                                                    </form>
                                                                </div>
                                                            </td>
                                                            @endif
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        @endif
                    </div>

                    <div id="klinik-tab" class="tab-pane" style="display: none;">
                        <div class="data-card" style="margin-top: 1rem;">
                            <table class="formal-table" id="clinicsTable">
                                <thead>
                                    <tr>
                                        <th style="width: 40px;"></th>
                                        <th>Informasi Klinik</th>
                                        <th>Kontak & Lokasi</th>
                                        <th>Status</th>
                                        @if(auth()->user()->role === 'SuperAdmin')
                                        <th>Aksi</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $clinicsOnly = $users->where('role', 'Admin');
                                    @endphp

                                    @if($clinicsOnly->isEmpty())
                                    <tr>
                                        <td colspan="{{ auth()->user()->role === 'SuperAdmin' ? 5 : 4 }}" style="text-align: center; padding: 3rem; color: #64748b;">
                                            <i class="fas fa-inbox" style="font-size: 2rem; margin-bottom: 1rem; color: #cbd5e1; display: block;"></i>
                                            Belum ada data klinik terdaftar.
                                        </td>
                                    </tr>
                                    @else
                                    @foreach ($clinicsOnly as $item)
                                    @if (auth()->user()->role === 'SuperAdmin' || auth()->user()->idKlinik === $item->idKlinik)
                                    @php
                                    $doctorsInClinic = $users->where('role', 'User')->where('idKlinik', $item->idKlinik);
                                    @endphp
                                    <tr class="main-row searchable-row" onclick="toggleSubRow('clinic-detail-{{ $item->id }}', this)">
                                        <td style="text-align: center;">
                                            <i class="fas fa-chevron-right expand-indicator"></i>
                                        </td>
                                        <td>
                                            <div class="user-info-cell">
                                                <div class="user-icon" style="background: rgba(59, 130, 246, 0.1); color: #3b82f6; border-radius: 8px;">
                                                    <i class="fas fa-hospital"></i>
                                                </div>
                                                <div class="user-details">
                                                    <h4 class="searchable-name">{{ $item->username }}</h4>
                                                    <span>Kode: {{ $item->klinik ? $item->klinik->kodeKlinik : '-' }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td data-label="Kontak">
                                            <div style="color: #334155; margin-bottom: 2px;"><i class="fas fa-phone-alt" style="color: #94a3b8; width: 20px;"></i> {{ $item->phoneNumber }}</div>
                                            <div style="font-size: 0.8rem; color: #64748b; padding-left: 20px;">{{ $item->alamat ?: '-' }}</div>
                                        </td>
                                        <td data-label="Status">
                                            <span class="clinic-badge">{{ $doctorsInClinic->count() }} Dokter Bertugas</span>
                                        </td>
                                        @if(auth()->user()->role === 'SuperAdmin')
                                        <td onclick="event.stopPropagation()" data-label="Aksi">
                                            <div class="action-links">
                                                <a href="{{ route('viewEditUser', $item->id) }}" class="action-link">Edit</a>
                                                <span style="color: #cbd5e1;">|</span>
                                                <form action="{{ route('deleteUser', $item->id) }}" method="POST" onsubmit="return confirm('Menghapus Admin ini juga akan menghapus klinik terkait. Lanjutkan?');" style="margin: 0; display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="action-link delete">Hapus</button>
                                                </form>
                                            </div>
                                        </td>
                                        @endif
                                    </tr>
                                    <tr class="sub-row" id="clinic-detail-{{ $item->id }}">
                                        <td colspan="{{ auth()->user()->role === 'SuperAdmin' ? 5 : 4 }}" style="padding: 0;">
                                            <div class="sub-table-container">
                                                <div style="margin-bottom: 1.5rem; background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 1.5rem; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
                                                    <h5 style="margin: 0 0 1rem 0; color: #1e293b; font-size: 0.95rem; border-bottom: 1px solid #f1f5f9; padding-bottom: 0.5rem; font-weight: 700;">Detail Informasi Klinik</h5>
                                                    <table style="width: 100%; border-collapse: collapse; font-size: 0.85rem;">
                                                        <tr>
                                                            <td style="width: 180px; color: #64748b; padding: 0.6rem 0; border-bottom: 1px solid #f8fafc;">Nama Klinik (Akun Admin)</td>
                                                            <td style="color: #0f172a; padding: 0.6rem 0; font-weight: 600; border-bottom: 1px solid #f8fafc;">{{ $item->username }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td style="color: #64748b; padding: 0.6rem 0; border-bottom: 1px solid #f8fafc;">Kode Klinik</td>
                                                            <td style="color: #0f172a; padding: 0.6rem 0; font-weight: 600; border-bottom: 1px solid #f8fafc;">{{ $item->klinik ? $item->klinik->kodeKlinik : '-' }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td style="color: #64748b; padding: 0.6rem 0; border-bottom: 1px solid #f8fafc;">Kontak (No. HP)</td>
                                                            <td style="color: #0f172a; padding: 0.6rem 0; font-weight: 600; border-bottom: 1px solid #f8fafc;">{{ $item->phoneNumber }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td style="color: #64748b; padding: 0.6rem 0;">Alamat Lengkap</td>
                                                            <td style="color: #0f172a; padding: 0.6rem 0; font-weight: 600;">{{ $item->alamat ?: '-' }}</td>
                                                        </tr>
                                                    </table>
                                                </div>

                                                <h5 style="margin: 0 0 0.75rem 0; color: #1e293b; font-size: 0.95rem; font-weight: 700;">Daftar Dokter Bertugas</h5>
                                                @if($doctorsInClinic->isEmpty())
                                                <div style="padding: 1.5rem; color: #64748b; font-size: 0.9rem; border: 1px dashed #e2e8f0; border-radius: 8px; text-align: center; background: #fff;">
                                                    Tidak ada dokter ditugaskan di klinik ini.
                                                </div>
                                                @else
                                                <table class="sub-table">
                                                    <thead>
                                                        <tr>
                                                            <th>Nama Dokter</th>
                                                            <th>Kontak</th>
                                                            @if(auth()->user()->role === 'SuperAdmin')
                                                            <th>Pindah Penugasan</th>
                                                            @endif
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($doctorsInClinic as $doc)
                                                        <tr>
                                                            <td data-label="Nama Dokter">
                                                                <div style="display: flex; align-items: center; gap: 0.5rem; font-weight: 600; color: #0f172a;">
                                                                    <i class="fas fa-user-md" style="color: #94a3b8;"></i>
                                                                    {{ $doc->username }}
                                                                </div>
                                                            </td>
                                                            <td data-label="Kontak">{{ $doc->phoneNumber }}</td>
                                                            @if(auth()->user()->role === 'SuperAdmin')
                                                            <td data-label="Penugasan">
                                                                <form action="{{ route('reassignUserClinic', $doc->id) }}" method="POST" style="margin: 0;">
                                                                    @csrf
                                                                    @method('PUT')
                                                                    <select name="idKlinik" class="formal-select" onchange="this.form.submit()">
                                                                        <option value="">-- Pindah Klinik --</option>
                                                                        @foreach($clinics as $c)
                                                                        <option value="{{ $c->id }}" {{ $doc->idKlinik == $c->id ? 'selected' : '' }}>
                                                                            {{ $c->namaKlinik }}
                                                                        </option>
                                                                        @endforeach
                                                                    </select>
                                                                </form>
                                                            </td>
                                                            @endif
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    @endif
                                    @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
            </div>

            @if(auth()->user()->role === 'SuperAdmin')
            <aside class="account-sidebar">
                <div class="admin-add-card">
                    <div class="card-header">
                        <h3>Tambah Admin / Klinik Baru</h3>
                    </div>
                    <form class="admin-form" action="{{ route('registerKlinik') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label>Nama Klinik</label>
                            @error('username')
                            <span class="error">{{ $message }}</span>
                            @enderror
                            <input type="text" placeholder="Masukkan nama klinik" name="username" />
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
                            <textarea id="alamat" name="alamat"
                                placeholder="Jln. Contoh No. 123, Kota, Provinsi, Kode Pos">{{ old('alamat') }}</textarea>
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
            @endif
        </div>
    </section>
</div>

{{-- Toggle Expand/Collapse Sub-Table Script --}}
<script>
    function switchTab(event, tabId) {
        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.classList.remove('active');
            btn.style.color = '#64748b';
            btn.style.borderBottom = 'none';
        });
        event.currentTarget.classList.add('active');
        event.currentTarget.style.color = '#6366f1';
        event.currentTarget.style.borderBottom = '2px solid #6366f1';

        document.querySelectorAll('.tab-pane').forEach(pane => {
            pane.style.display = 'none';
        });
        document.getElementById(tabId).style.display = 'block';
    }

    function toggleSubRow(id, rowElement) {
        const subRow = document.getElementById(id);
        if (subRow) {
            if (subRow.classList.contains('active')) {
                subRow.classList.remove('active');
                rowElement.classList.remove('expanded');
            } else {
                subRow.classList.add('active');
                rowElement.classList.add('expanded');
            }
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Quick live filter search box
        const searchInput = document.getElementById('searchInput');
        if (searchInput) {
            searchInput.addEventListener('keyup', function() {
                const query = this.value.toLowerCase();
                const rows = document.querySelectorAll('.searchable-row');

                rows.forEach(row => {
                    const name = row.querySelector('.searchable-name').textContent.toLowerCase();
                    const onclickAttr = row.getAttribute('onclick');
                    const match = onclickAttr ? onclickAttr.match(/'([^']+)'/) : null;
                    const subRowId = match ? match[1] : null;
                    const subRow = subRowId ? document.getElementById(subRowId) : null;

                    if (name.includes(query)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                        if (subRow) {
                            subRow.classList.remove('active');
                            row.classList.remove('expanded');
                        }
                    }
                });
            });
        }
    });
</script>

{{-- Styling for expandable sub-tables & formal layout --}}
<style>
    .data-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.05);
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    .formal-table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
    }

    .formal-table th {
        background-color: #f8fafc;
        color: #475569;
        font-weight: 600;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        padding: 1rem 1.5rem;
        border-bottom: 1px solid #e2e8f0;
    }

    .formal-table td {
        padding: 1rem 1.5rem;
        border-bottom: 1px solid #e2e8f0;
        color: #334155;
        font-size: 0.875rem;
        vertical-align: middle;
    }

    .formal-table tr:last-child td {
        border-bottom: none;
    }

    .formal-table tr:hover {
        background-color: #f8fafc;
    }

    .user-info-cell {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .user-icon {
        width: 40px;
        height: 40px;
        background: #eff6ff;
        color: #2563eb;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
    }

    .user-details h4 {
        margin: 0;
        color: #0f172a;
        font-weight: 600;
        font-size: 0.95rem;
    }

    .user-details span {
        font-size: 0.8rem;
        color: #64748b;
    }

    .clinic-badge {
        display: inline-block;
        padding: 0.25rem 0.6rem;
        background: #eff6ff;
        color: #1e40af;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 600;
        border: 1px solid #dbeafe;
    }

    .unassigned-badge {
        background: #fff1f2;
        color: #991b1b;
        border-color: #fecdd3;
    }

    .action-links {
        display: flex;
        gap: 0.75rem;
    }

    .action-link {
        color: #64748b;
        text-decoration: none;
        font-size: 0.85rem;
        font-weight: 600;
        transition: all 0.2s ease;
        background: none;
        border: none;
        padding: 0;
        cursor: pointer;
    }

    .action-link:hover {
        color: #3b82f6;
    }

    .action-link.delete:hover {
        color: #ef4444;
    }

    .main-row {
        cursor: pointer;
        transition: background-color 0.2s ease;
    }

    .main-row:hover {
        background-color: #f8fafc;
    }

    .main-row.expanded {
        background-color: #f8fafc;
        border-bottom: none;
    }

    .main-row.expanded td {
        border-bottom: none;
    }

    .sub-row {
        display: none;
        background-color: #f8fafc;
    }

    .sub-row.active {
        display: table-row;
    }

    .sub-table-container {
        padding: 1.5rem 1.5rem 1.5rem 4rem;
    }

    .expand-indicator {
        color: #94a3b8;
        font-size: 0.8rem;
        transition: transform 0.2s ease;
    }

    .main-row.expanded .expand-indicator {
        transform: rotate(90deg);
    }

    .formal-select {
        padding: 0.4rem 0.65rem;
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        font-size: 0.8rem;
        color: #334155;
        background-color: #fff;
        outline: none;
        transition: all 0.2s ease;
    }

    .formal-select:focus {
        border-color: #6366f1;
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.15);
    }

    .sub-table {
        width: 100%;
        border-collapse: collapse;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        overflow: hidden;
    }

    .sub-table th {
        background-color: #f8fafc;
        padding: 0.75rem 1rem;
        font-size: 0.75rem;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        border-bottom: 1px solid #e2e8f0;
    }

    .sub-table td {
        padding: 0.75rem 1rem;
        font-size: 0.85rem;
        border-bottom: 1px solid #f1f5f9;
        color: #334155;
    }

    .sub-table tr:last-child td {
        border-bottom: none;
    }

    .role-badge {
        padding: 0.3rem 0.75rem;
        border-radius: 99px;
        font-size: 0.8rem;
        font-weight: 600;
        display: inline-block;
    }

    .role-superadmin {
        background: rgba(99, 102, 241, 0.1);
        color: #6366f1;
    }

    .role-admin {
        background: rgba(59, 130, 246, 0.1);
        color: #3b82f6;
    }

    .role-user {
        background: rgba(107, 114, 128, 0.1);
        color: #6b7280;
    }

    .role-unassigned {
        background: rgba(239, 68, 68, 0.1);
        color: #ef4444;
    }

    @media (max-width: 768px) {
        .section-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.75rem;
        }

        .tabs-container {
            overflow-x: auto;
            white-space: nowrap;
            -webkit-overflow-scrolling: touch;
            gap: 4px !important;
            padding-bottom: 4px;
        }
        .tab-btn {
            flex-shrink: 0;
            padding: 8px 12px !important;
            font-size: 0.85rem !important;
        }

        .data-card {
            background: transparent !important;
            border: none !important;
            box-shadow: none !important;
            padding: 0 !important;
        }

        .formal-table, .formal-table tbody, .formal-table tr, .formal-table td {
            display: block !important;
            width: 100% !important;
        }
        .formal-table thead {
            display: none !important;
        }
        .formal-table tr {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 1.25rem 1rem 1rem 1rem;
            margin-bottom: 1rem;
            position: relative;
            box-shadow: 0 1px 3px rgba(0,0,0,0.02);
            transition: all 0.2s ease;
        }
        .formal-table tr.expanded {
            border-bottom-left-radius: 0 !important;
            border-bottom-right-radius: 0 !important;
            margin-bottom: 0 !important;
            border-bottom: 1px dashed #e2e8f0 !important;
        }
        .formal-table tr.main-row td:first-child {
            position: absolute;
            right: 1rem;
            top: 1rem;
            width: auto !important;
            padding: 0 !important;
            border: none !important;
            background: none !important;
        }
        .formal-table td {
            border-bottom: none !important;
            padding: 0.4rem 0 !important;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            gap: 0.25rem;
        }
        .formal-table td[data-label]::before {
            content: attr(data-label);
            font-weight: 700;
            font-size: 0.75rem;
            text-transform: uppercase;
            color: #64748b;
            letter-spacing: 0.05em;
            display: block;
            margin-bottom: 0.1rem;
        }
        
        .formal-table tr.sub-row {
            display: none !important;
            width: 100% !important;
        }
        .formal-table tr.sub-row.active {
            display: block !important;
            background: #f8fafc;
            border: 1px solid #e2e8f0 !important;
            border-top: none !important;
            border-radius: 0 0 12px 12px !important;
            margin-bottom: 1rem !important;
            padding: 0 !important;
        }

        /* Sub table inside expandable row */
        .sub-table-container {
            padding: 1rem !important;
            background: transparent;
        }
        .sub-table, .sub-table tbody, .sub-table tr, .sub-table td {
            display: block !important;
            width: 100% !important;
        }
        .sub-table thead {
            display: none !important;
        }
        .sub-table tr {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 0.75rem;
            margin-bottom: 0.75rem;
            box-shadow: 0 1px 2px rgba(0,0,0,0.01);
        }
        .sub-table td {
            border-bottom: none !important;
            padding: 0.35rem 0 !important;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            gap: 0.2rem;
        }
        .sub-table td[data-label]::before {
            content: attr(data-label);
            font-weight: 700;
            font-size: 0.7rem;
            text-transform: uppercase;
            color: #94a3b8;
            letter-spacing: 0.05em;
            display: block;
        }
        
        /* Clinics tab detail info custom display */
        .sub-table-container div table,
        .sub-table-container div tbody,
        .sub-table-container div tr,
        .sub-table-container div td {
            display: block !important;
            width: 100% !important;
        }
        .sub-table-container div td {
            padding: 0.35rem 0 !important;
            border-bottom: none !important;
        }
        .sub-table-container div tr {
            border-bottom: 1px solid #f1f5f9;
            padding: 0.4rem 0;
        }
        .sub-table-container div tr:last-child {
            border-bottom: none;
        }
        .sub-table-container div td:first-child {
            font-weight: 700;
            color: #64748b;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.03em;
        }
        .sub-table-container div td:last-child {
            color: #0f172a;
            font-weight: 600;
        }

        /* Minimalist Clinics Table styling for mobile */
        #clinicsTable tr.main-row .user-info-cell {
            padding-right: 5.5rem !important;
        }
        #clinicsTable tr.main-row td[data-label="Kontak"] {
            border: none !important;
            padding: 0.1rem 0 !important;
            font-size: 0.8rem !important;
            color: #64748b !important;
        }
        #clinicsTable tr.main-row td[data-label="Kontak"]::before {
            display: none !important;
        }
        #clinicsTable tr.main-row td[data-label="Status"] {
            position: absolute;
            right: 2.75rem;
            top: 1.25rem;
            width: auto !important;
            padding: 0 !important;
            z-index: 10;
        }
        #clinicsTable tr.main-row td[data-label="Status"]::before {
            display: none !important;
        }
        #clinicsTable tr.main-row td[data-label="Aksi"] {
            border-top: 1px solid #f1f5f9 !important;
            margin-top: 0.5rem;
            padding-top: 0.5rem !important;
            flex-direction: row !important;
            justify-content: flex-end;
            width: 100% !important;
        }
        #clinicsTable tr.main-row td[data-label="Aksi"]::before {
            display: none !important;
        }

        /* Minimalist Accounts Table styling for mobile */
        #accountsTable tr.main-row .user-info-cell {
            padding-right: 5.5rem !important;
        }
        #accountsTable tr.main-row td[data-label="Kontak"] {
            border: none !important;
            padding: 0.1rem 0 !important;
            font-size: 0.8rem !important;
            color: #64748b !important;
        }
        #accountsTable tr.main-row td[data-label="Kontak"] div {
            color: #64748b !important;
        }
        #accountsTable tr.main-row td[data-label="Kontak"]::before {
            display: none !important;
        }
        #accountsTable tr.main-row td[data-label="Peran"] {
            position: absolute;
            right: 2.75rem;
            top: 1.25rem;
            width: auto !important;
            padding: 0 !important;
            z-index: 10;
        }
        #accountsTable tr.main-row td[data-label="Peran"]::before {
            display: none !important;
        }
        #accountsTable tr.main-row td[data-label="Aksi"] {
            border-top: 1px solid #f1f5f9 !important;
            margin-top: 0.5rem;
            padding-top: 0.5rem !important;
            flex-direction: row !important;
            justify-content: flex-end;
            width: 100% !important;
        }
        #accountsTable tr.main-row td[data-label="Aksi"]::before {
            display: none !important;
        }
    }
</style>
@endsection