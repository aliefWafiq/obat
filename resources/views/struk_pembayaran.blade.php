<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: 'Courier New', Courier, monospace;
            font-size: 12px;
        }

        .text-center {
            text-align: center;
        }

        .line {
            border-bottom: 1px dashed #000;
            margin: 10px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }
    </style>
</head>

<body>
    <div class="text-center">
        <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('img/obatkitalogo copy.png'))) }}" alt="Logo" style="width: 100px; height: auto;">
        <p>{{ now()->format('d/m/Y H:i') }}</p>
    </div>

    <div class="line"></div>
    <p>Kode: {{ $pesanan->kodePemesanan }}</p>
    <p>Pelanggan: {{ $pesanan->user->username }}</p>
    <div class="line"></div>

    <table>
        @foreach($pesanan->details as $detail)
        <tr>
            <td>{{ $detail->produk->namaProduk }}</td>
            <td>{{ $detail->jumlahBeli }}x</td>
            <td style="text-align: right;">Rp. {{ number_format($detail->harga * $detail->jumlahBeli, 0, ',', '.') }}</td>
        </tr>
        @endforeach
    </table>

    <div class="line"></div>
    <table>
        <tr>
            <td><strong>TOTAL</strong></td>
            <td style="text-align: right;"><strong>{{ number_format($pesanan->totalHarga, 0, ',', '.') }}</strong></td>
        </tr>
    </table>
    <div class="line"></div>

    <div class="text-center">
        <p>Terima Kasih Atas Kunjungan Anda</p>
        <p>Barang yang sudah dibeli tidak dapat ditukar</p>
    </div>
</body>
</html>