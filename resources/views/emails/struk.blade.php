<!DOCTYPE html>
<html>
<head>
  
    <title>Struk Pembayaran</title>
    <style>
        /* CSS sederhana untuk tampilan struk */
        body { font-family: Arial, sans-serif; }
        .container { width: 80mm; margin: auto; }
        .header { text-align: center; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border-bottom: 1px dashed #000; padding: 4px; text-align: left; }
        .total { font-weight: bold; }
        hr { border-top: 1px dashed #000; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Struk Pembayaran</h2>
            <p>{{ \Carbon\Carbon::now()->format('d-m-Y H:i:s') }}</p>
        </div>
        <p><strong>Id Transaksi:</strong> {{ $penjualan->PenjualanID }}</p>
        <p><strong>Kasir:</strong> {{ $penjualan->NamaKasir }}</p>
        
        <p><strong>Pelanggan:</strong> 
            @if($penjualan->pelanggan)
                {{ $penjualan->pelanggan->NamaPelanggan }}
            @else
                No Member
            @endif
        </p>
        
        <p><strong>Tanggal Bayar:</strong> {{ \Carbon\Carbon::parse($penjualan->TanggalPenjualan)->format('d-m-Y') }}</p>
        
        <hr>

        <table>
            <thead>
                <tr>
                    <th>Produk</th>
                    <th>Qty</th>
                    <th>Harga</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($penjualan->detail as $detail)
                <tr>
                    <td>{{ $detail->produk->NamaProduk }}</td>
                    <td>{{ $detail->JumlahProduk }}</td>
                    <td>{{ 'Rp'.number_format($detail->Harga, 0, ',', '.') }}</td>
                    <td>{{ 'Rp'.number_format($detail->SubTotal, 0, ',', '.') }}</td>
                </tr>
                @endforeach
                <tr>
                    <td colspan="3" class="total">Total Harga</td>
                    <td class="total">{{ 'Rp'.number_format($penjualan->TotalHarga, 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>

        <hr>
        <p><strong>Jumlah Bayar:</strong> {{ 'Rp'.number_format($pembayaran->JumlahBayar, 0, ',', '.') }}</p>
        <p><strong>Kembalian:</strong> {{ 'Rp'.number_format($pembayaran->Kembalian, 0, ',', '.') }}</p>

        <div class="header">
            <p>Terima kasih telah berbelanja!</p>
        </div>
    </div>
</body>
</html>
