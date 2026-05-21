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
                                        <th>Nama / Klinik</th>
                                        <th>Nomor HP</th>
                                        <th>Alamat</th>
                                        <th>Role</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- 1. DISPLAY SUPER ADMINS --}}
                                    @foreach ($users->where('role', 'SuperAdmin') as $item)
                                        <tr style="background: rgba(99, 102, 241, 0.03);">
                                            <td>
                                                <i class="fas fa-crown" style="color: #f59e0b; margin-right: 8px;"></i>
                                                <strong>{{ $item->username }}</strong>
                                            </td>
                                            <td>{{ $item->phoneNumber }}</td>
                                            <td>{{ $item->alamat ?: '-' }}</td>
                                            <td>
                                                <span class="role-badge role-superadmin">Super Admin</span>
                                            </td>
                                            <td>
                                                @if(auth()->user()->role === 'SuperAdmin')
                                                    <div class="action-links">
                                                        <a href="{{ route('viewEditUser', $item->id) }}" class="action-link">Edit</a>
                                                    </div>
                                                @else
                                                    -
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach

                                    {{-- 2. DISPLAY ADMINS WITH EXPANDABLE SUB-USERS --}}
                                    @foreach ($users->where('role', 'Admin') as $item)
                                        <tr class="admin-row" data-admin-id="{{ $item->id }}">
                                            <td>
                                                <i class="fas fa-chevron-right toggle-icon" style="margin-right: 8px; transition: transform 0.2s; color: #888;"></i>
                                                @if($item->klinik)
                                                    <span class="clinic-code-badge">[ {{ $item->klinik->kodeKlinik }} ]</span>
                                                @endif
                                                <strong class="clinic-title-text">{{ $item->username }}</strong>
                                                @php
                                                    $clinicDoctorsCount = $users->where('role', 'User')->where('idKlinik', $item->idKlinik)->count();
                                                @endphp
                                                <span class="badge-count">{{ $clinicDoctorsCount }} Dokter</span>
                                            </td>
                                            <td>{{ $item->phoneNumber }}</td>
                                            <td>{{ $item->alamat ?: '-' }}</td>
                                            <td>
                                                <span class="role-badge role-admin">Admin</span>
                                            </td>
                                            <td>
                                                @if(auth()->user()->role === 'SuperAdmin')
                                                    <div class="action-links">
                                                        <form action="{{ route('deleteUser', $item->id) }}" method="POST" onsubmit="return confirm('Menghapus Admin ini juga akan menghapus klinik terkait. Lanjutkan?');" style="display: inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="action-link delete">Hapus</button>
                                                        </form>
                                                        <span class="action-divider">|</span>
                                                        <a href="{{ route('viewEditUser', $item->id) }}" class="action-link">Edit</a>
                                                    </div>
                                                @else
                                                    -
                                                @endif
                                            </td>
                                        </tr>

                                        {{-- Expanded Doctors Row --}}
                                        <tr class="users-sub-row" id="users-of-{{ $item->id }}" style="display: none; background: #fafbfc;">
                                            <td colspan="5" style="padding: 20px 30px; border-left: 4px solid #6366f1;">
                                                <div class="sub-table-container">
                                                    <h4 class="sub-table-title">
                                                        <i class="fas fa-user-md" style="color: #6366f1;"></i>
                                                        Daftar Dokter Terdaftar di <span>{{ $item->username }}</span>
                                                    </h4>
                                                    @php
                                                        $clinicDoctors = $users->where('role', 'User')->where('idKlinik', $item->idKlinik);
                                                    @endphp

                                                    @if($clinicDoctors->isEmpty())
                                                        <div class="empty-sub-state">
                                                            <i class="fas fa-info-circle"></i> Belum ada dokter di klinik ini.
                                                        </div>
                                                    @else
                                                        <table class="data-table sub-table">
                                                            <thead>
                                                                <tr>
                                                                    <th>Nama Dokter</th>
                                                                    <th>Nomor HP</th>
                                                                    <th>Alamat</th>
                                                                    <th>Lokasi Klinik (Admin)</th>
                                                                    <th>Aksi</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach($clinicDoctors as $doc)
                                                                    <tr>
                                                                        <td>
                                                                            <i class="fas fa-user-md" style="color: #4b5563; margin-right: 6px;"></i>
                                                                            <strong>{{ $doc->username }}</strong>
                                                                        </td>
                                                                        <td>{{ $doc->phoneNumber }}</td>
                                                                        <td>{{ $doc->alamat ?: '-' }}</td>
                                                                        <td>
                                                                            @if(auth()->user()->role === 'SuperAdmin')
                                                                                <form action="{{ route('reassignUserClinic', $doc->id) }}" method="POST" class="quick-reassign-form">
                                                                                    @csrf
                                                                                    @method('PUT')
                                                                                    <select name="idKlinik" onchange="this.form.submit()" class="quick-select">
                                                                                        @foreach($clinics as $c)
                                                                                            <option value="{{ $c->id }}" {{ $doc->idKlinik == $c->id ? 'selected' : '' }}>
                                                                                                {{ $c->namaKlinik }}
                                                                                            </option>
                                                                                        @endforeach
                                                                                    </select>
                                                                                </form>
                                                                            @else
                                                                                <span>{{ $doc->klinik->namaKlinik ?? 'Belum Ditugaskan' }}</span>
                                                                            @endif
                                                                        </td>
                                                                        <td>
                                                                            @if(auth()->user()->role === 'SuperAdmin')
                                                                                <div class="action-links">
                                                                                    <form action="{{ route('deleteUser', $doc->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus dokter ini?');" style="display: inline;">
                                                                                        @csrf
                                                                                        @method('DELETE')
                                                                                        <button type="submit" class="action-link delete">Hapus</button>
                                                                                    </form>
                                                                                    <span class="action-divider">|</span>
                                                                                    <a href="{{ route('viewEditUser', $doc->id) }}" class="action-link">Edit</a>
                                                                                </div>
                                                                            @else
                                                                                -
                                                                            @endif
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach

                                    {{-- 3. DISPLAY UNASSIGNED DOCTORS (POOL) --}}
                                    @php
                                        $unassignedDoctors = $users->where('role', 'User')->whereNull('idKlinik');
                                    @endphp
                                    @if($unassignedDoctors->isNotEmpty())
                                        <tr class="admin-row" data-admin-id="unassigned" style="background: rgba(239, 68, 68, 0.02);">
                                            <td>
                                                <i class="fas fa-chevron-right toggle-icon" style="margin-right: 8px; transition: transform 0.2s; color: #888;"></i>
                                                <i class="fas fa-question-circle" style="color: #ef4444; margin-right: 6px;"></i>
                                                <strong class="clinic-title-text" style="color: #ef4444;">Dokter Tanpa Klinik (Pool)</strong>
                                                <span class="badge-count" style="background: rgba(239, 68, 68, 0.1); color: #ef4444;">{{ $unassignedDoctors->count() }} Dokter</span>
                                            </td>
                                            <td>-</td>
                                            <td>-</td>
                                            <td>
                                                <span class="role-badge role-unassigned">Pool</span>
                                            </td>
                                            <td>-</td>
                                        </tr>

                                        {{-- Expanded Pool Row --}}
                                        <tr class="users-sub-row" id="users-of-unassigned" style="display: none; background: #fafbfc;">
                                            <td colspan="5" style="padding: 20px 30px; border-left: 4px solid #ef4444;">
                                                <div class="sub-table-container">
                                                    <h4 class="sub-table-title" style="color: #ef4444;">
                                                        <i class="fas fa-exclamation-triangle"></i>
                                                        Daftar Dokter Belum Terdistribusi
                                                    </h4>
                                                    <table class="data-table sub-table">
                                                        <thead>
                                                            <tr>
                                                                <th>Nama Dokter</th>
                                                                <th>Nomor HP</th>
                                                                <th>Alamat</th>
                                                                <th>Tentukan Klinik (Admin)</th>
                                                                <th>Aksi</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($unassignedDoctors as $doc)
                                                                <tr>
                                                                    <td>
                                                                        <i class="fas fa-user-md" style="color: #ef4444; margin-right: 6px;"></i>
                                                                        <strong>{{ $doc->username }}</strong>
                                                                    </td>
                                                                    <td>{{ $doc->phoneNumber }}</td>
                                                                    <td>{{ $doc->alamat ?: '-' }}</td>
                                                                    <td>
                                                                        @if(auth()->user()->role === 'SuperAdmin')
                                                                            <form action="{{ route('reassignUserClinic', $doc->id) }}" method="POST" class="quick-reassign-form">
                                                                                @csrf
                                                                                @method('PUT')
                                                                                <select name="idKlinik" onchange="this.form.submit()" class="quick-select" style="border-color: rgba(239, 68, 68, 0.3);">
                                                                                    <option value="">Pilih Klinik...</option>
                                                                                    @foreach($clinics as $c)
                                                                                        <option value="{{ $c->id }}">
                                                                                            {{ $c->namaKlinik }}
                                                                                        </option>
                                                                                    @endforeach
                                                                                </select>
                                                                            </form>
                                                                        @else
                                                                            <span style="color: #ef4444; font-weight: 500;">Belum Ditugaskan</span>
                                                                        @endif
                                                                    </td>
                                                                    <td>
                                                                        @if(auth()->user()->role === 'SuperAdmin')
                                                                            <div class="action-links">
                                                                                <form action="{{ route('deleteUser', $doc->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus dokter ini?');" style="display: inline;">
                                                                                    @csrf
                                                                                    @method('DELETE')
                                                                                    <button type="submit" class="action-link delete">Hapus</button>
                                                                                </form>
                                                                                <span class="action-divider">|</span>
                                                                                <a href="{{ route('viewEditUser', $doc->id) }}" class="action-link">Edit</a>
                                                                            </div>
                                                                        @else
                                                                            -
                                                                        @endif
                                                                    </td>
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

    {{-- Dropdown Action Menu Script --}}
    <script>
        function toggleActionDropdown(event, button) {
            event.stopPropagation();
            
            // Close all other open action dropdowns first
            document.querySelectorAll('.action-dropdown-menu').forEach(menu => {
                if (menu !== button.nextElementSibling) {
                    menu.style.display = 'none';
                }
            });
            
            // Toggle the current dropdown
            const menu = button.nextElementSibling;
            if (menu.style.display === 'none' || menu.style.display === '') {
                menu.style.display = 'block';
            } else {
                menu.style.display = 'none';
            }
        }

        // Close dropdowns if clicked anywhere else on the document
        document.addEventListener('click', function() {
            document.querySelectorAll('.action-dropdown-menu').forEach(menu => {
                menu.style.display = 'none';
            });
        });
    </script>

    {{-- Toggle Expand/Collapse Sub-Table Script --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const adminRows = document.querySelectorAll('.admin-row');
            
            adminRows.forEach(row => {
                row.addEventListener('click', function(e) {
                    // Prevent toggle when clicking actions, buttons, select, forms, or triggers
                    if (e.target.closest('.action-dropdown-container') || e.target.closest('.quick-select') || e.target.closest('form')) {
                        return;
                    }
                    
                    const adminId = this.dataset.adminId;
                    const subRow = document.getElementById('users-of-' + adminId);
                    const chevron = this.querySelector('.toggle-icon');
                    
                    if (subRow) {
                        if (subRow.style.display === 'none') {
                            subRow.style.display = 'table-row';
                            chevron.style.transform = 'rotate(90deg)';
                            this.classList.add('active-expanded');
                        } else {
                            subRow.style.display = 'none';
                            chevron.style.transform = 'rotate(0deg)';
                            this.classList.remove('active-expanded');
                        }
                    }
                });
            });

            // Quick live filter search box
            const searchInput = document.getElementById('searchInput');
            if (searchInput) {
                searchInput.addEventListener('keyup', function() {
                    const value = this.value.toLowerCase();
                    const adminRows = document.querySelectorAll('.admin-row');
                    
                    adminRows.forEach(row => {
                        const titleText = row.querySelector('.clinic-title-text').innerText.toLowerCase();
                        const adminId = row.dataset.adminId;
                        const subRow = document.getElementById('users-of-' + adminId);
                        
                        if (titleText.indexOf(value) > -1) {
                            row.style.display = "";
                        } else {
                            row.style.display = "none";
                            if (subRow) subRow.style.display = "none";
                        }
                    });
                });
            }
        });
    </script>

    {{-- Styling for expandable sub-tables & action dropdowns --}}
    <style>
        .admin-row {
            cursor: pointer;
            transition: background 0.2s ease;
        }
        
        .admin-row:hover {
            background: #f8fafc !important;
        }

        .admin-row.active-expanded {
            background: #f8fafc !important;
            border-bottom-color: transparent;
        }

        .clinic-code-badge {
            background: rgba(99, 102, 241, 0.08);
            color: #6366f1;
            font-weight: 700;
            padding: 3px 8px;
            border-radius: 8px;
            margin-right: 6px;
            font-size: 12px;
            border: 1px solid rgba(99, 102, 241, 0.15);
            font-family: monospace;
            display: inline-block;
        }

        .badge-count {
            background: rgba(99, 102, 241, 0.08);
            color: #4f46e5;
            padding: 4px 8px;
            font-size: 11px;
            font-weight: 700;
            border-radius: 99px;
            margin-left: 8px;
            vertical-align: middle;
        }

        .sub-table-container {
            padding: 10px 0;
        }

        .sub-table-title {
            font-size: 15px;
            font-weight: 700;
            color: #374151;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .sub-table-title span {
            color: #6366f1;
        }

        .empty-sub-state {
            padding: 20px;
            text-align: center;
            color: #6b7280;
            font-size: 13px;
            background: #fff;
            border: 1px dashed #e5e7eb;
            border-radius: 12px;
        }

        .sub-table {
            width: 100%;
            background: #fff !important;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03) !important;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            overflow: hidden;
        }

        .sub-table th {
            background: #f9fafb !important;
            padding: 12px 16px !important;
            font-size: 12px !important;
            font-weight: 600 !important;
            color: #4b5563 !important;
            border-bottom: 1px solid #e5e7eb !important;
        }

        .sub-table td {
            padding: 12px 16px !important;
            font-size: 13px !important;
            border-bottom: 1px solid #f3f4f6 !important;
        }

        .sub-table tr:hover {
            background: #fafbfc !important;
        }

        .quick-select {
            padding: 6px 12px;
            border: 1px solid #cbd5e1;
            background: #fff;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 500;
            color: #374151;
            outline: none;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .quick-select:focus {
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.15);
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

        /* Action Dropdown Styles */
        .action-dropdown-container {
            position: relative;
            display: inline-block;
        }

        .action-dropdown-trigger {
            background: none;
            border: none;
            font-size: 20px;
            font-weight: bold;
            color: #4b5563;
            padding: 4px 12px;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            line-height: 1;
        }

        .action-dropdown-trigger:hover {
            background: #f1f5f9;
            color: #111827;
        }

        .action-dropdown-menu {
            position: absolute;
            right: 0;
            top: 100%;
            margin-top: 6px;
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
            z-index: 100;
            min-width: 140px;
            overflow: hidden;
            animation: dropdownFadeIn 0.15s ease-out;
        }

        .dropdown-item {
            display: flex;
            align-items: center;
            gap: 8px;
            width: 100%;
            padding: 10px 16px;
            font-size: 13px;
            font-weight: 500;
            color: #374151;
            text-decoration: none;
            border: none;
            background: none;
            text-align: left;
            cursor: pointer;
            transition: background 0.15s ease;
        }

        .dropdown-item:hover {
            background: #f8fafc;
            color: #111827;
        }

        .dropdown-item.delete-item {
            color: #ef4444;
        }

        .dropdown-item.delete-item:hover {
            background: rgba(239, 68, 68, 0.05);
            color: #ef4444;
        }

        @keyframes dropdownFadeIn {
            from { opacity: 0; transform: translateY(-5px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
@endsection
