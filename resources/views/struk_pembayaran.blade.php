<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Faktur - {{ $pesanan->kodePemesanan }}</title>
    <style>
        @page {
            size: a5 landscape;
            margin: 10mm 12mm 10mm 12mm;
        }
        body {
            font-family: 'Courier New', Courier, monospace;
            font-size: 9.5pt;
            color: #000;
            line-height: 1.35;
            margin: 0;
            padding: 0;
        }
        .header-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 5px;
        }
        .header-table td {
            vertical-align: top;
            padding: 0;
        }
        .title {
            font-size: 15pt;
            font-weight: bold;
            letter-spacing: 6px;
            margin: 0 0 5px 0;
        }
        .meta-label {
            width: 110px;
            display: inline-block;
        }
        .divider {
            border-top: 1px dashed #000;
            border-bottom: 1px dashed #000;
            height: 3px;
            margin: 6px 0;
        }
        .divider-double {
            border-top: 2px double #000;
            margin: 6px 0;
            height: 2px;
        }
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 6px;
        }
        .items-table th {
            border-bottom: 1px dashed #000;
            border-top: 1px dashed #000;
            padding: 6px 0;
            font-weight: normal;
            text-align: left;
            font-size: 9.5pt;
        }
        .items-table td {
            padding: 4px 0;
            font-size: 9.5pt;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .footer-container {
            margin-top: 20px;
            width: 100%;
        }
        .signature-table {
            width: 100%;
            border-collapse: collapse;
        }
        .signature-table td {
            vertical-align: top;
            padding: 0;
        }

        .jumlah-rupiah-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 2px;
        }
        .jumlah-rupiah-table td {
            font-size: 9.5pt;
        }
    </style>
</head>
<body>
    @php
        $createdAt = \Carbon\Carbon::parse($pesanan->created_at);
        $jatuhTempo = $pesanan->estimasipembayaran ? \Carbon\Carbon::parse($pesanan->estimasipembayaran) : null;
    @endphp

    <table class="header-table">
        <tr>
            <!-- Left Side Meta Info -->
            <td style="width: 52%;">
                <div class="title">F A K T U R</div>
                <div><span class="meta-label">No Faktur</span>: {{ $pesanan->kodePemesanan }}</div>
                <div><span class="meta-label">Tanggal</span>: {{ $createdAt->format('d/m/Y') }}</div>
                <div><span class="meta-label">Tipe Bayar</span>: {{ $pesanan->tipePembayaran ?? 'Cash' }}</div>
                @if(strtolower($pesanan->tipePembayaran) === 'kredit')
                <div><span class="meta-label">TOP</span>: 21 Hari</div>
                <div><span class="meta-label">Jatuh Tempo</span>: {{ $jatuhTempo ? $jatuhTempo->format('d/m/Y') : '-' }}</div>
                @endif
            </td>
            <!-- Right Side Customer Info -->
            <td style="width: 48%; padding-left: 15px;">
                <div style="height: 22px;"></div> <!-- visual offset mapping FAKTUR alignment -->
                <div>Nama Pelanggan : {{ $pesanan->user->klinik->namaKlinik ?? $pesanan->user->username }}</div>
                <div>Alamat         : {{ $pesanan->user->alamat ?? '-' }}</div>
            </td>
        </tr>
    </table>

    <!-- Dashed Separator -->
    <div class="divider"></div>

    <table class="items-table">
        <thead>
            <tr>
                <th style="width: 50%;">Nama Barang</th>
                <th style="width: 15%; text-align: right;">Banyak</th>
                <th style="width: 15%; text-align: right;">Harga</th>
                <th style="width: 20%; text-align: right;">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pesanan->details as $detail)
            <tr>
                <td>{{ $detail->produk->namaProduk }}</td>
                <td class="text-right">{{ $detail->jumlahBeli }}</td>
                <td class="text-right">{{ number_format($detail->harga, 0, ',', '.') }}</td>
                <td class="text-right">{{ number_format($detail->harga * $detail->jumlahBeli, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Dashed Separator -->
    <div class="divider"></div>

    <!-- Summary Row -->
    <table class="jumlah-rupiah-table">
        <tr>
            <td style="width: 60%;"></td>
            <td style="width: 20%; font-weight: bold; text-align: left;">Jumlah Rupiah</td>
            <td style="width: 20%; text-align: right; font-weight: bold;">{{ number_format($pesanan->totalHarga, 0, ',', '.') }}</td>
        </tr>
    </table>

    <!-- Footer with Stamps and Signature blocks -->
    <div class="footer-container">
        <table class="signature-table">
            <tr>
                <!-- Left Block -->
                <td style="width: 35%; text-align: left;">
                    <div>Penerima Barang / Tanggal & jam</div>
                    <div style="height: 45px;"></div>
                    <div>Tanda tangan & Nama Lengkap</div>
                </td>

                <!-- Right Block -->
                <td style="width: 35%; text-align: right;">
                    <div>&nbsp;</div>
                    <div style="height: 45px;"></div>
                    <div>Tanda Tangan & Cap Apotik</div>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>