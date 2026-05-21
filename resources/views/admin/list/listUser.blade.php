@extends('layouts.adminLayout')

@push('styles')
<style>
    .formal-page-wrapper {
        padding: 2rem;
        background: #f8fafc;
        min-height: calc(100vh - 80px);
        font-family: 'Inter', -apple-system, sans-serif;
    }

    .page-header {
        margin-bottom: 2rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px solid #e2e8f0;
        padding-bottom: 1rem;
    }

    .page-header h2 {
        font-size: 1.35rem;
        color: #0f172a;
        font-weight: 700;
        letter-spacing: -0.025em;
        margin: 0;
    }

    .page-header p {
        color: #64748b;
        font-size: 0.85rem;
        margin-top: 0.25rem;
    }

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
        padding: 0 1.5rem 1.5rem 4rem;
    }

    .expand-indicator {
        color: #94a3b8;
        font-size: 0.8rem;
        transition: transform 0.2s ease;
    }

    .main-row.expanded .expand-indicator {
        transform: rotate(90deg);
    }

    /* Page Header Overrides */
    .header {
        border-bottom: 1px solid #e2e8f0;
        box-shadow: none;
        background: #ffffff;
    }

    @media (max-width: 768px) {
        .formal-page-wrapper {
            padding: 1rem;
        }
        .page-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.75rem;
        }
        .sub-table-container {
            padding: 0 1rem 1rem 1rem;
        }
    }
</style>
@endpush

@section('content')
<div class="main-content">
    <header class="header">
        <div class="header-left">
            <button class="menu-toggle"><i class="fas fa-bars"></i></button>
            <h1 id="page-title" style="font-weight: 600; color: #1e293b;">Data Dokter</h1>
        </div>
        <div class="search-box">
            <i class="fas fa-search"></i>
            <input type="text" placeholder="Cari dokter..." id="searchInput">
        </div>
    </header>

    <div class="formal-page-wrapper">
        <div class="page-header">
            <div>
                <h2>Daftar Dokter</h2>
                <p>Kelola data dokter, kontak, dan penugasan klinik secara terpusat.</p>
            </div>
        </div>

        <div class="data-card">
            <table class="formal-table" id="doctorsTable">
                <thead>
                    <tr>
                        <th style="width: 40px;"></th>
                        <th>Profil Dokter</th>
                        <th>Kontak</th>
                        <th>Penugasan Klinik</th>
                        @if(auth()->user()->role === 'SuperAdmin')
                            <th>Aksi</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @php
                    $doctors = $users->where('role', 'User');
                    @endphp

                    @if($doctors->isEmpty())
<<<<<<< HEAD
                        <tr>
                            <td colspan="{{ auth()->user()->role === 'SuperAdmin' ? 5 : 4 }}" style="text-align: center; padding: 3rem; color: #64748b;">
                                <i class="fas fa-inbox" style="font-size: 2rem; margin-bottom: 1rem; color: #cbd5e1; display: block;"></i>
                                Belum ada data dokter terdaftar.
                            </td>
                        </tr>
=======
                    <tr>
                        <td colspan="5" style="text-align: center; padding: 3rem; color: #64748b;">
                            <i class="fas fa-inbox" style="font-size: 2rem; margin-bottom: 1rem; color: #cbd5e1; display: block;"></i>
                            Belum ada data dokter terdaftar.
                        </td>
                    </tr>
>>>>>>> 9ad5e9f3a9775168b73a0e7c9fe95cfc5a249371
                    @else
                    @foreach ($doctors as $item)
                    @if(auth()->user()->role === 'SuperAdmin' || auth()->user()->idKlinik === $item->idKlinik)
                    <tr class="main-row searchable-row" onclick="toggleSubRow('sub-{{ $item->id }}', this)">
                        <td style="text-align: center;">
                            <i class="fas fa-chevron-right expand-indicator"></i>
                        </td>
                        <td>
                            <div class="user-info-cell">
                                <div class="user-icon">
                                    <i class="fas fa-user-md"></i>
                                </div>
<<<<<<< HEAD
                            </td>
                            <td>
                                <div style="color: #334155;"><i class="fas fa-phone-alt" style="color: #94a3b8; width: 20px;"></i> {{ $item->phoneNumber }}</div>
                            </td>
                            <td>
                                @if($item->klinik)
                                    <span class="clinic-badge">{{ $item->klinik->namaKlinik ?? 'Klinik Terkait' }} ({{ $item->klinik->kodeKlinik }})</span>
                                @else
                                    <span class="clinic-badge unassigned-badge">Belum Ditugaskan</span>
                                @endif
                            </td>
                            @if(auth()->user()->role === 'SuperAdmin')
                                <td onclick="event.stopPropagation()">
                                    <div class="action-links">
                                        <a href="{{ route('viewEditUser', $item->id) }}" class="action-link">Edit</a>
                                        <span style="color: #cbd5e1;">|</span>
                                        <form action="{{ route('deleteUser', $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus dokter ini?');" style="margin: 0;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="action-link delete">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            @endif
                        </tr>
                        <tr class="sub-row" id="sub-{{ $item->id }}">
                            <td colspan="{{ auth()->user()->role === 'SuperAdmin' ? 5 : 4 }}" style="padding: 0;">
                                <div class="sub-table-container">
                                    <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 6px; padding: 1.25rem;">
                                        <h5 style="margin: 0 0 1rem 0; color: #1e293b; font-size: 0.95rem; border-bottom: 1px solid #f1f5f9; padding-bottom: 0.5rem;">Detail Informasi Dokter</h5>
                                        <table style="width: 100%; border-collapse: collapse; font-size: 0.85rem;">
                                            <tr>
                                                <td style="width: 180px; color: #64748b; padding: 0.6rem 0; border-bottom: 1px solid #f8fafc;">Nama Lengkap</td>
                                                <td style="color: #0f172a; padding: 0.6rem 0; font-weight: 500; border-bottom: 1px solid #f8fafc;">{{ $item->username }}</td>
                                            </tr>
                                            <tr>
                                                <td style="color: #64748b; padding: 0.6rem 0; border-bottom: 1px solid #f8fafc;">ID Dokter</td>
                                                <td style="color: #0f172a; padding: 0.6rem 0; font-weight: 500; border-bottom: 1px solid #f8fafc;">#{{ str_pad($item->id, 4, '0', STR_PAD_LEFT) }}</td>
                                            </tr>
                                            <tr>
                                                <td style="color: #64748b; padding: 0.6rem 0; border-bottom: 1px solid #f8fafc;">Nomor Handphone</td>
                                                <td style="color: #0f172a; padding: 0.6rem 0; font-weight: 500; border-bottom: 1px solid #f8fafc;">{{ $item->phoneNumber }}</td>
                                            </tr>
                                            <tr>
                                                <td style="color: #64748b; padding: 0.6rem 0; border-bottom: 1px solid #f8fafc;">Alamat Tinggal</td>
                                                <td style="color: #0f172a; padding: 0.6rem 0; font-weight: 500; border-bottom: 1px solid #f8fafc;">{{ $item->alamat ?: '-' }}</td>
                                            </tr>
                                            <tr>
                                                <td style="color: #64748b; padding: 0.6rem 0;">Status Penugasan</td>
                                                <td style="color: #0f172a; padding: 0.6rem 0; font-weight: 500;">
                                                    @if($item->klinik)
                                                        Ditugaskan di <strong style="color: #0d9488;">{{ $item->klinik->namaKlinik }}</strong>
                                                    @else
                                                        <span style="color: #ef4444;">Belum ditugaskan (Pool)</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
=======
                                <div class="user-details">
                                    <h4 class="searchable-name">{{ $item->username }}</h4>
                                    <span>ID: #{{ str_pad($item->id, 4, '0', STR_PAD_LEFT) }}</span>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div style="color: #334155;"><i class="fas fa-phone-alt" style="color: #94a3b8; width: 20px;"></i> {{ $item->phoneNumber }}</div>
                        </td>
                        <td>
                            @if($item->klinik)
                            <span class="clinic-badge">{{ $item->klinik->namaKlinik ?? 'Klinik Terkait' }} ({{ $item->klinik->kodeKlinik }})</span>
                            @else
                            <span class="clinic-badge unassigned-badge">Belum Ditugaskan</span>
                            @endif
                        </td>
                        <td onclick="event.stopPropagation()">
                            <div class="action-links">
                                <a href="{{ route('viewEditUser', $item->id) }}" class="action-link">Edit</a>
                                <span style="color: #cbd5e1;">|</span>
                                <form action="{{ route('deleteUser', $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus dokter ini?');" style="margin: 0;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="action-link delete">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    <tr class="sub-row" id="sub-{{ $item->id }}">
                        <td colspan="5" style="padding: 0;">
                            <div class="sub-table-container">
                                <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 6px; padding: 1.25rem;">
                                    <h5 style="margin: 0 0 1rem 0; color: #1e293b; font-size: 0.95rem; border-bottom: 1px solid #f1f5f9; padding-bottom: 0.5rem;">Detail Informasi Dokter</h5>
                                    <table style="width: 100%; border-collapse: collapse; font-size: 0.85rem;">
                                        <tr>
                                            <td style="width: 180px; color: #64748b; padding: 0.6rem 0; border-bottom: 1px solid #f8fafc;">Nama Lengkap</td>
                                            <td style="color: #0f172a; padding: 0.6rem 0; font-weight: 500; border-bottom: 1px solid #f8fafc;">{{ $item->username }}</td>
                                        </tr>
                                        <tr>
                                            <td style="color: #64748b; padding: 0.6rem 0; border-bottom: 1px solid #f8fafc;">ID Dokter</td>
                                            <td style="color: #0f172a; padding: 0.6rem 0; font-weight: 500; border-bottom: 1px solid #f8fafc;">#{{ str_pad($item->id, 4, '0', STR_PAD_LEFT) }}</td>
                                        </tr>
                                        <tr>
                                            <td style="color: #64748b; padding: 0.6rem 0; border-bottom: 1px solid #f8fafc;">Nomor Handphone</td>
                                            <td style="color: #0f172a; padding: 0.6rem 0; font-weight: 500; border-bottom: 1px solid #f8fafc;">{{ $item->phoneNumber }}</td>
                                        </tr>
                                        <tr>
                                            <td style="color: #64748b; padding: 0.6rem 0; border-bottom: 1px solid #f8fafc;">Alamat Tinggal</td>
                                            <td style="color: #0f172a; padding: 0.6rem 0; font-weight: 500; border-bottom: 1px solid #f8fafc;">{{ $item->alamat ?: '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td style="color: #64748b; padding: 0.6rem 0;">Status Penugasan</td>
                                            <td style="color: #0f172a; padding: 0.6rem 0; font-weight: 500;">
                                                @if($item->klinik)
                                                Ditugaskan di <strong style="color: #0d9488;">{{ $item->klinik->namaKlinik }}</strong>
                                                @else
                                                <span style="color: #ef4444;">Belum ditugaskan (Pool)</span>
                                                @endif
                                            </td>
                                        </tr>
                                    </table>
>>>>>>> 9ad5e9f3a9775168b73a0e7c9fe95cfc5a249371
                                </div>
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

<script>
    function toggleSubRow(id, rowElement) {
        const subRow = document.getElementById(id);
        if (subRow.classList.contains('active')) {
            subRow.classList.remove('active');
            rowElement.classList.remove('expanded');
        } else {
            subRow.classList.add('active');
            rowElement.classList.add('expanded');
        }
    }

    document.getElementById('searchInput').addEventListener('keyup', function() {
        const query = this.value.toLowerCase();
        const rows = document.querySelectorAll('.searchable-row');

        rows.forEach(row => {
            const name = row.querySelector('.searchable-name').textContent.toLowerCase();
            const subRowId = 'sub-' + row.getAttribute('onclick').match(/'([^']+)'/)[1];
            const subRow = document.getElementById(subRowId);

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
</script>
@endsection