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
        letter-spacing: -0.02em;
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
        margin-bottom: 2rem;
        overflow: hidden;
    }

    .section-title {
        background: #f8fafc;
        padding: 1rem 1.5rem;
        font-weight: 600;
        color: #475569;
        border-bottom: 1px solid #e2e8f0;
        font-size: 0.9rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .formal-table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
    }

    .formal-table th {
        background-color: #ffffff;
        color: #64748b;
        font-weight: 600;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        padding: 1rem 1.5rem;
        border-bottom: 1px solid #e2e8f0;
    }

    .formal-table td {
        padding: 1rem 1.5rem;
        border-bottom: 1px solid #f1f5f9;
        color: #334155;
        font-size: 0.875rem;
        vertical-align: middle;
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

    .clinic-info-cell {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .clinic-icon {
        width: 40px;
        height: 40px;
        background: #eff6ff;
        color: #2563eb;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
    }

    .clinic-details h4 {
        margin: 0;
        color: #0f172a;
        font-weight: 600;
        font-size: 0.95rem;
    }

    .clinic-details span {
        font-size: 0.8rem;
        color: #64748b;
    }

    .doctor-count {
        background: #eff6ff;
        padding: 0.25rem 0.6rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        color: #1e40af;
        font-weight: 600;
        display: inline-block;
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

    /* Sub-table for doctors */
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

    /* Header Overrides */
    .header {
        border-bottom: 1px solid #e2e8f0;
        box-shadow: none;
        background: #ffffff;
    }
</style>
@endpush

@section('content')
<div class="main-content">
    <header class="header">
        <div class="header-left">
            <button class="menu-toggle"><i class="fas fa-bars"></i></button>
            <h1 id="page-title" style="font-weight: 600; color: #1e293b;">Data Klinik</h1>
        </div>
        <div class="search-box">
            <i class="fas fa-search"></i>
            <input type="text" placeholder="Cari klinik..." id="searchInput">
        </div>
    </header>

    <div class="formal-page-wrapper">
        <div class="page-header">
            <div>
                <h2>Daftar Klinik</h2>
                <p>Kelola data fasilitas klinik dan penugasan dokter.</p>
            </div>
        </div>

        <div class="data-card">
            <div class="section-title">
                Klinik Terdaftar
            </div>
            <table class="formal-table">
                <thead>
                    <tr>
                        <th style="width: 40px;"></th>
                        <th>Informasi Klinik</th>
                        <th>Kontak & Lokasi</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $clinicsOnly = $users->where('role', 'Admin');
                    @endphp

                    @if($clinicsOnly->isEmpty())
                        <tr>
                            <td colspan="5" style="text-align: center; padding: 3rem; color: #64748b;">
                                Belum ada data klinik terdaftar.
                            </td>
                        </tr>
                    @else
                        @foreach ($clinicsOnly as $item)
                        @php
                            $doctorsInClinic = $users->where('role', 'User')->where('idKlinik', $item->idKlinik);
                        @endphp
                        <tr class="main-row searchable-row" onclick="toggleSubRow('sub-{{ $item->id }}', this)">
                            <td style="text-align: center;">
                                <i class="fas fa-chevron-right expand-indicator"></i>
                            </td>
                            <td>
                                <div class="clinic-info-cell">
                                    <div class="clinic-icon">
                                        <i class="fas fa-hospital"></i>
                                    </div>
                                    <div class="clinic-details">
                                        <h4 class="searchable-name">{{ $item->username }}</h4>
                                        <span>Kode: {{ $item->klinik ? $item->klinik->kodeKlinik : '-' }}</span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div style="margin-bottom: 0.25rem;">{{ $item->phoneNumber }}</div>
                                <div style="font-size: 0.85rem; color: #64748b;">{{ $item->alamat ?: 'Alamat tidak tersedia' }}</div>
                            </td>
                            <td>
                                <span class="doctor-count">{{ $doctorsInClinic->count() }} Dokter</span>
                            </td>
                            <td onclick="event.stopPropagation()">
                                <div class="action-links">
                                    <a href="{{ route('viewEditUser', $item->id) }}" class="action-link">Edit</a>
                                    <span style="color: #cbd5e1;">|</span>
                                    <form action="{{ route('deleteUser', $item->id) }}" method="POST" onsubmit="return confirm('Menghapus Admin ini juga akan menghapus klinik terkait. Lanjutkan?');" style="margin: 0;">
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
                                    <div style="margin-bottom: 1.5rem; background: #ffffff; border: 1px solid #e2e8f0; border-radius: 6px; padding: 1.25rem;">
                                        <h5 style="margin: 0 0 1rem 0; color: #1e293b; font-size: 0.95rem; border-bottom: 1px solid #f1f5f9; padding-bottom: 0.5rem;">Detail Informasi Klinik</h5>
                                        <table style="width: 100%; border-collapse: collapse; font-size: 0.85rem;">
                                            <tr>
                                                <td style="width: 180px; color: #64748b; padding: 0.6rem 0; border-bottom: 1px solid #f8fafc;">Nama Klinik (Akun Admin)</td>
                                                <td style="color: #0f172a; padding: 0.6rem 0; font-weight: 500; border-bottom: 1px solid #f8fafc;">{{ $item->username }}</td>
                                            </tr>
                                            <tr>
                                                <td style="color: #64748b; padding: 0.6rem 0; border-bottom: 1px solid #f8fafc;">Kode Klinik</td>
                                                <td style="color: #0f172a; padding: 0.6rem 0; font-weight: 500; border-bottom: 1px solid #f8fafc;">{{ $item->klinik ? $item->klinik->kodeKlinik : '-' }}</td>
                                            </tr>
                                            <tr>
                                                <td style="color: #64748b; padding: 0.6rem 0; border-bottom: 1px solid #f8fafc;">Kontak (No. HP)</td>
                                                <td style="color: #0f172a; padding: 0.6rem 0; font-weight: 500; border-bottom: 1px solid #f8fafc;">{{ $item->phoneNumber }}</td>
                                            </tr>
                                            <tr>
                                                <td style="color: #64748b; padding: 0.6rem 0;">Alamat Lengkap</td>
                                                <td style="color: #0f172a; padding: 0.6rem 0; font-weight: 500;">{{ $item->alamat ?: '-' }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                    
                                    <h5 style="margin: 0 0 0.75rem 0; color: #1e293b; font-size: 0.95rem;">Daftar Dokter Bertugas</h5>
                                    @if($doctorsInClinic->isEmpty())
                                        <div style="padding: 1rem; color: #64748b; font-size: 0.9rem; border: 1px dashed #e2e8f0; border-radius: 4px; text-align: center;">
                                            Tidak ada dokter ditugaskan di klinik ini.
                                        </div>
                                    @else
                                        <table class="sub-table">
                                            <thead>
                                                <tr>
                                                    <th>Nama Dokter</th>
                                                    <th>Kontak</th>
                                                    <th>Pindah Penugasan</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($doctorsInClinic as $doc)
                                                <tr>
                                                    <td>
                                                        <div style="display: flex; align-items: center; gap: 0.5rem;">
                                                            <i class="fas fa-user-md" style="color: #94a3b8;"></i>
                                                            {{ $doc->username }}
                                                        </div>
                                                    </td>
                                                    <td>{{ $doc->phoneNumber }}</td>
                                                    <td>
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
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>

        <!-- Unassigned Doctors Pool -->
        @php
            $unassignedDoctors = $users->where('role', 'User')->whereNull('idKlinik');
        @endphp
        @if($unassignedDoctors->isNotEmpty())
        <div class="data-card" style="border-color: #fca5a5;">
            <div class="section-title" style="background: #fef2f2; color: #991b1b; border-bottom-color: #fca5a5;">
                <div style="display: flex; align-items: center; gap: 0.5rem;">
                    <i class="fas fa-exclamation-circle"></i> Dokter Belum Ditugaskan
                </div>
                <span class="doctor-count" style="background: #fecaca; color: #991b1b;">{{ $unassignedDoctors->count() }} Orang</span>
            </div>
            <table class="formal-table">
                <thead>
                    <tr>
                        <th>Nama Dokter</th>
                        <th>Kontak</th>
                        <th>Tentukan Penugasan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($unassignedDoctors as $doc)
                    <tr>
                        <td>
                            <div style="display: flex; align-items: center; gap: 0.5rem;">
                                <i class="fas fa-user-md" style="color: #f87171;"></i>
                                {{ $doc->username }}
                            </div>
                        </td>
                        <td>{{ $doc->phoneNumber }}</td>
                        <td>
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
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif

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
                if(subRow) {
                    subRow.classList.remove('active');
                    row.classList.remove('expanded');
                }
            }
        });
    });
</script>
@endsection