@extends('layouts.adminLayout')
@section('content')
<div class="main-content">
    <header class="header">
        <div class="header-left">
            <button class="menu-toggle">
                <i class="fas fa-bars"></i>
            </button>
            <h1 id="page-title">Bulk Update Stok</h1>
        </div>
    </header>
    
    <section id="dashboard" class="content-section active" style="padding: 2rem 1.5rem; max-width: 1000px; margin: 0 auto">
        <!-- Instruction Banner -->
        <div class="card-tutorial" style="background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%); border-radius: 20px; padding: 1.5rem; border: 1px solid #bfdbfe; margin-bottom: 2rem; display: flex; gap: 1rem; align-items: flex-start; box-shadow: 0 4px 12px rgba(37, 99, 235, 0.04);">
            <div style="background: #2563eb; color: #fff; width: 42px; height: 42px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.25rem; flex-shrink: 0; box-shadow: 0 4px 10px rgba(37, 99, 235, 0.3);">
                <i class="fas fa-file-excel"></i>
            </div>
            <div>
                <h3 style="margin: 0 0 0.35rem 0; color: #1e3a8a; font-weight: 700; font-size: 1.05rem;">Cara Cepat Tambah Stok dari Excel</h3>
                <p style="margin: 0; color: #1e40af; font-size: 0.88rem; line-height: 1.5;">
                    Salin 2 kolom di Excel (Kolom 1: <strong>Kode Produk</strong>, Kolom 2: <strong>Jumlah Tambahan Stok</strong>). Tempelkan langsung ke kolom input besar di bawah. Sistem akan otomatis mendeteksi baris produk dan menambahkan nilai tersebut ke stok yang sudah ada.
                </p>
            </div>
        </div>

        <div class="grid-container" style="display: grid; grid-template-columns: 1fr; gap: 2rem;">
            
            <!-- Paste Area Card -->
            <div style="background: #ffffff; border-radius: 24px; padding: 2rem; box-shadow: 0 10px 30px rgba(0,0,0,0.05); border: 1px solid #f1f5f9;">
                <h2 style="font-size: 1.2rem; font-weight: 700; margin-top: 0; margin-bottom: 1.2rem; color: #1e293b; display: flex; align-items: center; gap: 0.50rem;">
                    <i class="far fa-clipboard" style="color: #2563eb;"></i> Tempel Data Excel Di Sini
                </h2>
                
                <div class="form-group" style="margin-bottom: 1.5rem;">
                    <textarea id="excel-paste-input" style="width: 100%; height: 180px; padding: 1.2rem; border-radius: 16px; border: 2px dashed #cbd5e1; font-family: 'Courier New', Courier, monospace; font-size: 0.9rem; resize: vertical; outline: none; transition: all 0.3s ease; box-sizing: border-box; background: #fafbfd;" placeholder="Tempel kolom Excel di sini...&#10;Contoh:&#10;HJKSDL&#9;20&#10;ABCDEF&#9;15"></textarea>
                </div>

                <div class="form-actions" style="display: flex; gap: 1rem; justify-content: space-between; align-items: center; flex-wrap: wrap;">
                    <a href="{{ route('listProduk') }}" class="btn-cancel" style="padding: 0.85rem 1.4rem; border-radius: 12px; background: #f8fafc; color: #64748b; font-weight: 600; text-decoration: none; border: 1px solid #e2e8f0; display: inline-flex; align-items: center; gap: 0.5rem; font-size: 0.88rem; transition: all 0.2s;">
                        <i class="fas fa-arrow-left"></i> Kembali ke Produk
                    </a>
                    
                    <button type="button" id="btn-submit-bulk" disabled style="padding: 0.85rem 1.8rem; border-radius: 12px; background: #94a3b8; color: #ffffff; font-weight: 700; border: none; cursor: not-allowed; display: inline-flex; align-items: center; gap: 0.6rem; font-size: 0.88rem; transition: all 0.3s; box-shadow: 0 4px 12px rgba(148, 163, 184, 0.2);">
                        <i class="fas fa-cloud-upload-alt"></i> Tambahkan Stok Baru (<span id="parsed-count-badge">0</span> Item)
                    </button>
                </div>
            </div>

            <!-- Preview Card -->
            <div id="preview-card" style="background: #ffffff; border-radius: 24px; padding: 2rem; box-shadow: 0 10px 30px rgba(0,0,0,0.05); border: 1px solid #f1f5f9; display: none;">
                <h2 style="font-size: 1.2rem; font-weight: 700; margin-top: 0; margin-bottom: 1.2rem; color: #1e293b; display: flex; align-items: center; gap: 0.5rem;">
                    <i class="fas fa-eye" style="color: #10b981;"></i> Pratinjau Data Deteksi
                </h2>
                
                <div style="overflow-x: auto;">
                    <table style="width: 100%; border-collapse: collapse; min-width: 400px;">
                        <thead>
                            <tr style="border-bottom: 2px solid #f1f5f9; text-align: left;">
                                <th style="padding: 0.85rem 1rem; color: #64748b; font-weight: 600; font-size: 0.85rem; text-transform: uppercase;">Kode Produk</th>
                                <th style="padding: 0.85rem 1rem; color: #64748b; font-weight: 600; font-size: 0.85rem; text-transform: uppercase; text-align: right;">Tambahan Stok</th>
                                <th style="padding: 0.85rem 1rem; color: #64748b; font-weight: 600; font-size: 0.85rem; text-transform: uppercase; text-align: center;">Format</th>
                            </tr>
                        </thead>
                        <tbody id="preview-table-body">
                            <!-- JS populated -->
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Result Log Card -->
            <div id="result-log-card" style="background: #ffffff; border-radius: 24px; padding: 2rem; box-shadow: 0 10px 30px rgba(0,0,0,0.05); border: 1px solid #f1f5f9; display: none;">
                <h2 style="font-size: 1.2rem; font-weight: 700; margin-top: 0; margin-bottom: 1.2rem; color: #1e293b; display: flex; align-items: center; gap: 0.50rem;">
                    <i class="fas fa-list-alt" style="color: #f59e0b;"></i> Log Hasil Sinkronisasi (Akumulatif)
                </h2>
                
                <div id="result-summary-alert" style="padding: 1rem 1.2rem; border-radius: 14px; margin-bottom: 1.5rem; font-weight: 600; font-size: 0.9rem;"></div>
                
                <div id="result-notfound-box" style="background: #fffbeb; border: 1px solid #fef3c7; padding: 1.2rem; border-radius: 16px; margin-bottom: 1.5rem; display: none;">
                    <h4 style="margin: 0 0 0.5rem 0; color: #b45309; font-size: 0.92rem;"><i class="fas fa-exclamation-triangle"></i> Kode Produk Tidak Ditemukan:</h4>
                    <p id="result-notfound-list" style="margin: 0; font-family: monospace; font-size: 0.85rem; color: #d97706; word-break: break-all;"></p>
                </div>

                <div style="overflow-x: auto;">
                    <table style="width: 100%; border-collapse: collapse; min-width: 400px;">
                        <thead>
                            <tr style="border-bottom: 2px solid #f1f5f9; text-align: left;">
                                <th style="padding: 0.85rem 1rem; color: #64748b; font-weight: 600; font-size: 0.85rem; text-transform: uppercase;">Kode</th>
                                <th style="padding: 0.85rem 1rem; color: #64748b; font-weight: 600; font-size: 0.85rem; text-transform: uppercase;">Nama Produk</th>
                                <th style="padding: 0.85rem 1rem; color: #64748b; font-weight: 600; font-size: 0.85rem; text-transform: uppercase; text-align: right;">Stok Awal</th>
                                <th style="padding: 0.85rem 1rem; color: #64748b; font-weight: 600; font-size: 0.85rem; text-transform: uppercase; text-align: right;">Tambahan</th>
                                <th style="padding: 0.85rem 1rem; color: #64748b; font-weight: 600; font-size: 0.85rem; text-transform: uppercase; text-align: right;">Stok Akhir</th>
                            </tr>
                        </thead>
                        <tbody id="result-table-body">
                            <!-- JS populated -->
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </section>
</div>

<style>
    #excel-paste-input:focus {
        border-color: #2563eb !important;
        background: #ffffff !important;
        box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1);
    }
    .btn-cancel:hover {
        background: #f1f5f9 !important;
        color: #475569 !important;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const pasteInput = document.getElementById('excel-paste-input');
        const submitBtn = document.getElementById('btn-submit-bulk');
        const countBadge = document.getElementById('parsed-count-badge');
        const previewCard = document.getElementById('preview-card');
        const previewTableBody = document.getElementById('preview-table-body');
        const resultLogCard = document.getElementById('result-log-card');
        const resultTableBody = document.getElementById('result-table-body');
        const resultSummaryAlert = document.getElementById('result-summary-alert');
        const resultNotfoundBox = document.getElementById('result-notfound-box');
        const resultNotfoundList = document.getElementById('result-notfound-list');

        let parsedItems = [];

        // Parse excel columns in real-time
        pasteInput.addEventListener('input', function(e) {
            const rawText = e.target.value;
            const lines = rawText.trim().split(/\r?\n/);
            parsedItems = [];
            
            previewTableBody.innerHTML = '';
            
            lines.forEach((line, index) => {
                if (!line.trim()) return;
                
                const columns = line.split('\t');
                const kode = columns[0] ? columns[0].trim() : '';
                const qtyStr = columns[1] ? columns[1].trim() : '';
                const qty = parseInt(qtyStr, 10);
                
                const isFormatValid = kode && !isNaN(qty) && qty >= 0;
                
                if (kode) {
                    if (isFormatValid) {
                        parsedItems.push({ kode, qty });
                    }
                    
                    const rowHtml = `
                        <tr style="border-bottom: 1px solid #f8fafc;">
                            <td style="padding: 0.85rem 1rem; font-weight: 600; color: #334155; font-family: monospace;">${escapeHtml(kode)}</td>
                            <td style="padding: 0.85rem 1rem; text-align: right; font-weight: 700; color: ${isFormatValid ? '#0f766e' : '#dc2626'};">
                                ${isFormatValid ? qty : (qtyStr || 'Kuantitas Salah')}
                            </td>
                            <td style="padding: 0.85rem 1rem; text-align: center;">
                                <span style="display: inline-flex; align-items: center; gap: 0.25rem; font-size: 0.72rem; padding: 0.25rem 0.5rem; border-radius: 999px; font-weight: 700; background: ${isFormatValid ? '#dcfce7; color: #16a34a;' : '#fee2e2; color: #ef4444;'}">
                                    <i class="${isFormatValid ? 'fas fa-check-circle' : 'fas fa-times-circle'}"></i> ${isFormatValid ? 'Valid' : 'Gagal'}
                                </span>
                            </td>
                        </tr>
                    `;
                    previewTableBody.insertAdjacentHTML('beforeend', rowHtml);
                }
            });

            if (parsedItems.length > 0) {
                // Enable button
                submitBtn.disabled = false;
                submitBtn.style.background = '#2563eb';
                submitBtn.style.cursor = 'pointer';
                submitBtn.style.boxShadow = '0 4px 12px rgba(37, 99, 235, 0.24)';
                
                previewCard.style.display = 'block';
                countBadge.textContent = parsedItems.length;
            } else {
                // Disable button
                submitBtn.disabled = true;
                submitBtn.style.background = '#94a3b8';
                submitBtn.style.cursor = 'not-allowed';
                submitBtn.style.boxShadow = 'none';
                
                previewCard.style.display = 'none';
                countBadge.textContent = '0';
            }
        });

        // Submit to Laravel Backend via AJAX Fetch
        submitBtn.addEventListener('click', function() {
            if (parsedItems.length === 0) return;
            
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menyimpan...';

            fetch("{{ route('produk.updateStokMassal') }}", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    "Content-Type": "application/json",
                    "Accept": "application/json"
                },
                body: JSON.stringify({ items: parsedItems })
            })
            .then(res => res.json())
            .then(data => {
                submitBtn.innerHTML = '<i class="fas fa-cloud-upload-alt"></i> Tambahkan Stok Baru (' + parsedItems.length + ' Item)';
                submitBtn.disabled = false;

                if (data.success) {
                    // Reset input
                    pasteInput.value = '';
                    previewCard.style.display = 'none';
                    parsedItems = [];
                    
                    // Display results log
                    resultLogCard.style.display = 'block';
                    resultTableBody.innerHTML = '';
                    
                    // Render summary status alert
                    const updatedCount = data.updated.length;
                    const notFoundCount = data.not_found.length;
                    
                    if (notFoundCount > 0) {
                        resultSummaryAlert.style.background = '#fffbeb';
                        resultSummaryAlert.style.color = '#b45309';
                        resultSummaryAlert.style.border = '1px solid #fef3c7';
                        resultSummaryAlert.innerHTML = `<i class="fas fa-exclamation-circle"></i> Berhasil mengupdate ${updatedCount} produk. Namun ada ${notFoundCount} kode barang yang salah/tidak ditemukan.`;
                        
                        resultNotfoundBox.style.display = 'block';
                        resultNotfoundList.textContent = data.not_found.join(', ');
                    } else {
                        resultSummaryAlert.style.background = '#dcfce7';
                        resultSummaryAlert.style.color = '#15803d';
                        resultSummaryAlert.style.border = '1px solid #bbf7d0';
                        resultSummaryAlert.innerHTML = `<i class="fas fa-check-circle"></i> Sinkronisasi Sukses! Semua ${updatedCount} produk berhasil diperbarui secara akumulatif.`;
                        resultNotfoundBox.style.display = 'none';
                    }

                    // Render updated list
                    data.updated.forEach(item => {
                        const tr = `
                            <tr style="border-bottom: 1px solid #f8fafc;">
                                <td style="padding: 0.85rem 1rem; font-family: monospace; font-weight: 600; color: #475569;">${escapeHtml(item.kode)}</td>
                                <td style="padding: 0.85rem 1rem; font-weight: 600; color: #1e293b;">${escapeHtml(item.nama)}</td>
                                <td style="padding: 0.85rem 1rem; text-align: right; color: #64748b;">${item.stok_lama} unit</td>
                                <td style="padding: 0.85rem 1rem; text-align: right; font-weight: 700; color: #3b82f6;">+${item.tambahan} unit</td>
                                <td style="padding: 0.85rem 1rem; text-align: right; font-weight: 700; color: #16a34a;">${item.stok_baru} unit</td>
                            </tr>
                        `;
                        resultTableBody.insertAdjacentHTML('beforeend', tr);
                    });

                    // Scroll to results
                    resultLogCard.scrollIntoView({ behavior: 'smooth' });

                } else {
                    alert('Gagal memproses data: ' + (data.message || 'Terjadi kesalahan sistem.'));
                }
            })
            .catch(err => {
                submitBtn.innerHTML = '<i class="fas fa-cloud-upload-alt"></i> Simpan Stok Baru (' + parsedItems.length + ' Item)';
                submitBtn.disabled = false;
                console.error(err);
                alert('Gagal mengirim data. Silakan cek koneksi atau format data.');
            });
        });

        function escapeHtml(text) {
            return text
                .replace(/&/g, "&amp;")
                .replace(/</g, "&lt;")
                .replace(/>/g, "&gt;")
                .replace(/"/g, "&quot;")
                .replace(/'/g, "&#039;");
        }
    });
</script>
@endsection