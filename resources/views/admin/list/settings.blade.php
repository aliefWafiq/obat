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

    .settings-grid {
        display: grid;
        grid-template-columns: 280px 1fr;
        gap: 2rem;
    }

    @media (max-width: 992px) {
        .settings-grid {
            grid-template-columns: 1fr;
        }
    }

    /* Sidebar Navigation inside settings */
    .settings-menu {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 0.75rem;
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
        align-self: start;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
    }

    .settings-menu-item {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.75rem 1rem;
        color: #64748b;
        text-decoration: none;
        font-size: 0.9rem;
        font-weight: 500;
        border-radius: 8px;
        transition: all 0.2s ease;
        border: none;
        background: none;
        width: 100%;
        text-align: left;
        cursor: pointer;
    }

    .settings-menu-item:hover {
        background: #f1f5f9;
        color: #0f172a;
    }

    .settings-menu-item.active {
        background: rgba(99, 102, 241, 0.08);
        color: #6366f1;
        font-weight: 600;
    }

    /* Main Settings Card */
    .settings-content-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        padding: 2rem;
    }

    .settings-section-title {
        font-size: 1.1rem;
        color: #0f172a;
        font-weight: 700;
        margin: 0 0 0.5rem 0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .settings-section-subtitle {
        font-size: 0.85rem;
        color: #64748b;
        margin: 0 0 2rem 0;
    }

    /* Form Styles inside settings */
    .settings-form-group {
        margin-bottom: 1.5rem;
    }

    .settings-form-group label {
        display: block;
        font-size: 0.85rem;
        font-weight: 600;
        color: #334155;
        margin-bottom: 0.5rem;
    }

    .settings-form-control {
        width: 100%;
        padding: 0.65rem 0.85rem;
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        font-size: 0.9rem;
        color: #0f172a;
        background-color: #ffffff;
        outline: none;
        transition: all 0.2s ease;
        box-sizing: border-box;
    }

    .settings-form-control:focus {
        border-color: #6366f1;
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.15);
    }

    /* Toggle Switches */
    .toggle-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem 0;
        border-bottom: 1px solid #f1f5f9;
    }

    .toggle-container:last-child {
        border-bottom: none;
    }

    .toggle-label {
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
    }

    .toggle-title {
        font-size: 0.9rem;
        font-weight: 600;
        color: #1e293b;
    }

    .toggle-desc {
        font-size: 0.8rem;
        color: #64748b;
    }

    /* Switch styling */
    .switch {
        position: relative;
        display: inline-block;
        width: 48px;
        height: 24px;
    }

    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #cbd5e1;
        transition: .3s;
        border-radius: 24px;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 18px;
        width: 18px;
        left: 3px;
        bottom: 3px;
        background-color: white;
        transition: .3s;
        border-radius: 50%;
    }

    input:checked + .slider {
        background-color: #6366f1;
    }

    input:checked + .slider:before {
        transform: translateX(24px);
    }

    .save-btn {
        background: #6366f1;
        color: #ffffff;
        border: none;
        padding: 0.65rem 1.5rem;
        border-radius: 8px;
        font-size: 0.9rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .save-btn:hover {
        background: #4f46e5;
    }

    .btn-secondary {
        background: #ffffff;
        color: #334155;
        border: 1px solid #cbd5e1;
        padding: 0.65rem 1.5rem;
        border-radius: 8px;
        font-size: 0.9rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
        text-decoration: none;
    }

    .btn-secondary:hover {
        background: #f8fafc;
        border-color: #94a3b8;
    }

    .header {
        border-bottom: 1px solid #e2e8f0;
        box-shadow: none;
        background: #ffffff;
    }

    .alert-settings {
        background: #eff6ff;
        border: 1px solid #bfdbfe;
        color: #1e3a8a;
        padding: 1rem;
        border-radius: 8px;
        margin-bottom: 1.5rem;
        font-size: 0.85rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
</style>
@endpush

@section('content')
<div class="main-content">
    <header class="header">
        <div class="header-left">
            <button class="menu-toggle"><i class="fas fa-bars"></i></button>
            <h1 id="page-title" style="font-weight: 600; color: #1e293b;">Pengaturan</h1>
        </div>
    </header>

    <div class="formal-page-wrapper">
        <div class="page-header">
            <h2>Pengaturan Sistem</h2>
            <p>Konfigurasi parameter aplikasi, sistem notifikasi, dan manajemen keamanan.</p>
        </div>

        <div class="settings-grid">
            <!-- Sidebar navigasi setting -->
            <div class="settings-menu">
                <button class="settings-menu-item active" onclick="switchSection('profile', this)">
                    <i class="fas fa-desktop"></i> Sistem & Aplikasi
                </button>
                <button class="settings-menu-item" onclick="switchSection('notifications', this)">
                    <i class="fas fa-bell"></i> Notifikasi & WA Gateway
                </button>
                <button class="settings-menu-item" onclick="switchSection('security', this)">
                    <i class="fas fa-shield-alt"></i> Keamanan & Backup
                </button>
            </div>

            <!-- Content Area -->
            <div class="settings-content-card">
                
                <!-- Section 1: Sistem & Aplikasi -->
                <div id="section-profile" class="settings-pane">
                    <h3 class="settings-section-title"><i class="fas fa-desktop" style="color: #6366f1;"></i> Profil Sistem Aplikasi</h3>
                    <p class="settings-section-subtitle">Atur data utama dan preferensi global sistem ObatKita.</p>
                    
                    <form onsubmit="event.preventDefault(); alert('Pengaturan Profil Aplikasi berhasil disimpan!');">
                        <div class="settings-form-group">
                            <label>Nama Aplikasi / Portal</label>
                            <input type="text" class="settings-form-control" value="ObatKita - Portal Apotek & Klinik Terintegrasi">
                        </div>
                        <div class="settings-form-group">
                            <label>Instansi Penyelenggara</label>
                            <input type="text" class="settings-form-control" value="Dinas Kesehatan Kabupaten / Kota">
                        </div>
                        <div class="settings-form-group">
                            <label>Alamat Surel Hubungan Masyarakat (Email Support)</label>
                            <input type="email" class="settings-form-control" value="support@obatkita.go.id">
                        </div>
                        <div class="settings-form-group">
                            <label>Format Kode Invoice / Transaksi</label>
                            <input type="text" class="settings-form-control" value="ORD-{YEAR}-{MONTH}-{RAND:4}">
                            <small style="color: #64748b; font-size: 0.75rem;">Contoh output: ORD-2026-05-4921</small>
                        </div>
                        
                        <div class="toggle-container">
                            <div class="toggle-label">
                                <span class="toggle-title">Mode Pemeliharaan (Maintenance Mode)</span>
                                <span class="toggle-desc">Matikan portal sementara untuk pengguna umum guna pembaruan sistem.</span>
                            </div>
                            <label class="switch">
                                <input type="checkbox">
                                <span class="slider"></span>
                            </label>
                        </div>

                        <div class="toggle-container">
                            <div class="toggle-label">
                                <span class="toggle-title">Pendaftaran Mandiri Dokter</span>
                                <span class="toggle-desc">Izinkan pengguna umum mendaftar sebagai dokter/klinik secara langsung.</span>
                            </div>
                            <label class="switch">
                                <input type="checkbox" checked>
                                <span class="slider"></span>
                            </label>
                        </div>
                        
                        <div style="margin-top: 2rem;">
                            <button type="submit" class="save-btn"><i class="fas fa-save"></i> Simpan Perubahan</button>
                        </div>
                    </form>
                </div>

                <!-- Section 2: Notifikasi -->
                <div id="section-notifications" class="settings-pane" style="display: none;">
                    <h3 class="settings-section-title"><i class="fas fa-bell" style="color: #6366f1;"></i> Notifikasi & WhatsApp Gateway</h3>
                    <p class="settings-section-subtitle">Atur integrasi pengiriman notifikasi instan kepada pasien dan dokter.</p>
                    
                    <form onsubmit="event.preventDefault(); alert('Integrasi notifikasi berhasil diperbarui!');">
                        <div class="alert-settings">
                            <i class="fas fa-info-circle" style="font-size: 1.25rem;"></i>
                            <div>
                                Gateway WhatsApp menggunakan integrasi pihak ketiga (Fonnte API). Pastikan token API Anda masih memiliki saldo kuota aktif.
                            </div>
                        </div>

                        <div class="settings-form-group">
                            <label>Token WhatsApp API (Fonnte)</label>
                            <input type="password" class="settings-form-control" value="API_KEY_TOKEN_FONNTE_OBSCURED_12345">
                        </div>

                        <div class="settings-form-group">
                            <label>Nomor Pengirim (WA Sender Number)</label>
                            <input type="text" class="settings-form-control" value="+6281234567890">
                        </div>

                        <div class="toggle-container">
                            <div class="toggle-label">
                                <span class="toggle-title">Kirim Invoice Otomatis via WA</span>
                                <span class="toggle-desc">Kirim PDF bukti pembayaran / struk langsung ke WhatsApp pasien setelah transaksi Lunas.</span>
                            </div>
                            <label class="switch">
                                <input type="checkbox" checked>
                                <span class="slider"></span>
                            </label>
                        </div>

                        <div class="toggle-container">
                            <div class="toggle-label">
                                <span class="toggle-title">Pengingat Stok Menipis</span>
                                <span class="toggle-desc">Kirim notifikasi email kepada Admin jika stok obat di bawah batas minimum (10 unit).</span>
                            </div>
                            <label class="switch">
                                <input type="checkbox" checked>
                                <span class="slider"></span>
                            </label>
                        </div>

                        <div style="margin-top: 2rem;">
                            <button type="submit" class="save-btn"><i class="fas fa-save"></i> Simpan Gateway</button>
                        </div>
                    </form>
                </div>

                <!-- Section 3: Keamanan & Backup -->
                <div id="section-security" class="settings-pane" style="display: none;">
                    <h3 class="settings-section-title"><i class="fas fa-shield-alt" style="color: #6366f1;"></i> Keamanan & Cadangan Data</h3>
                    <p class="settings-section-subtitle">Lakukan pencadangan database manual dan kelola keamanan sistem.</p>
                    
                    <div style="margin-bottom: 2rem; padding: 1.5rem; background: #faf5ff; border: 1px solid #e9d5ff; border-radius: 10px; display: flex; align-items: center; justify-content: space-between; gap: 1.5rem;">
                        <div>
                            <h4 style="margin: 0; font-size: 0.95rem; color: #581c87; font-weight: 700;">Cadangkan Database Sekarang</h4>
                            <p style="margin: 0.25rem 0 0 0; font-size: 0.8rem; color: #7e22ce;">Ekspor semua data transaksi, obat, klinik, dan akun dalam format .sql (kompresi .zip).</p>
                        </div>
                        <button onclick="alert('Database backup sedang diproses. Unduhan akan segera dimulai!');" class="save-btn" style="background: #a855f7; white-space: nowrap;"><i class="fas fa-download"></i> Buat Backup</button>
                    </div>

                    <form onsubmit="event.preventDefault(); alert('Kebijakan keamanan sistem berhasil diperbarui!');">
                        <div class="settings-form-group">
                            <label>Masa Kadaluarsa Sesi Login (Session Lifetime)</label>
                            <select class="settings-form-control">
                                <option value="120">120 Menit (2 Jam)</option>
                                <option value="240">240 Menit (4 Jam)</option>
                                <option value="1440">1440 Menit (24 Jam / 1 Hari)</option>
                            </select>
                        </div>

                        <div class="toggle-container">
                            <div class="toggle-label">
                                <span class="toggle-title">Paksa Kebijakan Kata Sandi Kuat</span>
                                <span class="toggle-desc">Kata sandi baru pengguna wajib mengandung minimal 8 karakter, huruf besar, huruf kecil, angka, dan simbol.</span>
                            </div>
                            <label class="switch">
                                <input type="checkbox" checked>
                                <span class="slider"></span>
                            </label>
                        </div>

                        <div class="toggle-container">
                            <div class="toggle-label">
                                <span class="toggle-title">Log Aktivitas Administrator</span>
                                <span class="toggle-desc">Catat semua aksi pembuatan, pembaruan, dan penghapusan data oleh administrator ke database.</span>
                            </div>
                            <label class="switch">
                                <input type="checkbox" checked>
                                <span class="slider"></span>
                            </label>
                        </div>

                        <div style="margin-top: 2rem;">
                            <button type="submit" class="save-btn"><i class="fas fa-save"></i> Terapkan Kebijakan</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>

<script>
    function switchSection(sectionId, element) {
        // Toggle menu active class
        document.querySelectorAll('.settings-menu-item').forEach(item => {
            item.classList.remove('active');
        });
        element.classList.add('active');

        // Toggle sections visibility
        document.querySelectorAll('.settings-pane').forEach(pane => {
            pane.style.display = 'none';
        });
        document.getElementById('section-' + sectionId).style.display = 'block';
    }
</script>
@endsection
