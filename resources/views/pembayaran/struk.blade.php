<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Pembayaran</title>
    <style>
        body {
            font-family: 'Courier New', Courier, monospace;
            font-size: 12px;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 80mm;
            margin: auto;
            padding: 10px;
        }

        .header {
            text-align: center;
            border-bottom: 1px dashed #000;
            padding-bottom: 5px;
            margin-bottom: 10px;
        }

        .header img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 5px;
        }

        .info-toko {
            text-align: center;
        }

        .info-toko p {
            margin: 0;
            line-height: 1.2;
        }

        .section {
            margin-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 2px 0;
            text-align: left;
        }

        .text-right {
            text-align: right;
        }

        .total-row {
            font-weight: bold;
            border-top: 1px dashed #000;
            border-bottom: 1px dashed #000;
            padding-top: 5px;
            padding-bottom: 5px;
        }

        .footer {
            text-align: center;
            margin-top: 10px;
            font-style: italic;
            font-size: 11px;
        }

        hr {
            border: none;
            border-top: 1px dashed #000;
            margin: 8px 0;
        }
    </style>
    <script>
        window.onload = function() {
            window.print();
        }
    </script>
</head>
<body>
<div class="container">

    @if($penjualan && $penjualan->detail->count())
        <div class="header">
            @if(isset($profilToko->logo))
                <img src="{{ asset('storage/' . $profilToko->logo) }}" alt="Logo Toko">
            @endif
            <div class="info-toko">
                <strong>{{ $profilToko->NamaToko ?? 'Nama Toko' }}</strong><br>
                <p>{{ $profilToko->Alamat ?? '-' }}</p>
                <p>Telp: {{ $profilToko->NoTelp ?? '-' }}</p>
                <p>{{ \Carbon\Carbon::now()->format('d-m-Y H:i') }}</p>
            </div>
        </div>

        <div class="section">
            <p>ID Transaksi : {{ $penjualan->PenjualanID }}</p>
            <p>Kasir        : {{ $penjualan->NamaKasir }}</p>
            <p>Pelanggan    : {{ $penjualan->pelanggan->NamaPelanggan ?? 'No Member' }}</p>
            <p>Tgl Bayar    : {{ \Carbon\Carbon::parse($penjualan->TanggalPenjualan)->format('d-m-Y') }}</p>
            <p>Metode Bayar : @if ($pembayaran->metode)
                      {{ $pembayaran->metode->NamaMetode }}</td>
                    @else
                        <span class="text-danger">Tidak Ada Metode</span></p>
                    @endif
        </div>

        <hr>

        <table>
            <thead>
            <tr>
                <th>Item</th>
                <th class="text-right">Qty</th>
                <th class="text-right">Harga</th>
                <th class="text-right">Sub</th>
            </tr>
            </thead>
            <tbody>
            @foreach($penjualan->detail as $detail)
                <tr>
                    <td>{{ optional($detail->produk)->NamaProduk ?? '-' }}</td>
                    <td class="text-right">{{ $detail->JumlahProduk }}</td>
                    <td class="text-right">{{ number_format($detail->Harga, 0, ',', '.') }}</td>
                    <td class="text-right">{{ number_format($detail->SubTotal, 0, ',', '.') }}</td>
                </tr>
            @endforeach
            <tr class="total-row">
                <td colspan="3">TOTAL</td>
                <td class="text-right">{{ number_format($penjualan->TotalHarga, 0, ',', '.') }}</td>
            </tr>
            </tbody>
        </table>

        <div class="section">
            <p><strong>Bayar</strong>: Rp{{ number_format(optional($pembayaran)->JumlahBayar ?? 0, 0, ',', '.') }}</p>
            <p><strong>Kembali</strong>: Rp{{ number_format(optional($pembayaran)->Kembalian ?? 0, 0, ',', '.') }}</p>
        </div>

        <div class="footer">
            <p>--- Terima Kasih ---</p>
            <p>Semoga belanja Anda menyenangkan</p>
        </div>
    @else
        <p style="text-align:center; padding: 20px;">Struk tidak tersedia.</p>
    @endif
</div>

</body>
</html>
