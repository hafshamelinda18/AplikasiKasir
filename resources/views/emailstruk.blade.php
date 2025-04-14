<!DOCTYPE html>
<html>
<head>
    <title>Struk Pembayaran</title>
    <style>
        /* CSS sederhana untuk tampilan struk */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 80mm;
            margin: auto;
            padding: 10px;
            border: 1px solid #ddd;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: left;
            position: relative;
        }
        .header-info {
            font-size: 0.7em; /* Ukuran teks lebih kecil */
        }
        .logo {
            max-width: 60px;
            float: right;
            border-radius: 50%; /* Membuat logo bulat */
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 4px;
            text-align: left;
            border-bottom: 1px dashed #000;
        }
        th {
            background-color: #f5f5f5;
        }
        .total {
            font-weight: bold;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
        }
        hr {
            border: 0;
            border-bottom: 1px solid #ddd;
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <div class="container">
    <div class="header">

    
@if(isset($logoCid))
    <img src="{{ $logoCid }}" alt="Logo Toko" class="logo">
@endif


            <h2 style="text-align: center;">{{ $data['profilToko']->NamaToko }}</h2>
            <div class="header-info">
                <p>{{ $data['profilToko']->Alamat }}</p>
                <p>Telepon: {{ $data['profilToko']->NoTelp }}</p>
                <p>Email: {{ $data['profilToko']->email }}</p>
                <p>{{ \Carbon\Carbon::now()->format('d-m-Y H:i:s') }}</p>

        </div>
</div>
        <p><strong>Id Transaksi:</strong> {{ $data['penjualan']->PenjualanID }}</p>
        <p><strong>Kasir:</strong> {{ $data['penjualan']->NamaKasir }}</p>
        
        <p><strong>Pelanggan:</strong> 
            @if($data['penjualan']->pelanggan)
                {{ $data['penjualan']->pelanggan->NamaPelanggan }}
            @else
                No Member
            @endif
        </p>
        
        <p><strong>Tanggal Bayar:</strong> {{ \Carbon\Carbon::parse($data['penjualan']->TanggalPenjualan)->format('d-m-Y') }}</p>
        
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
                @foreach($data['penjualan']->detail as $detail)
                <tr>
                    <td>{{ $detail->produk->NamaProduk }}</td>
                    <td>{{ $detail->JumlahProduk }}</td>
                    <td>{{ 'Rp'.number_format($detail->Harga, 0, ',', '.') }}</td>
                    <td>{{ 'Rp'.number_format($detail->SubTotal, 0, ',', '.') }}</td>
                </tr>
                @endforeach
                <tr>
                    <td colspan="3" class="total">Total Harga</td>
                    <td class="total">{{ 'Rp'.number_format($data['penjualan']->TotalHarga, 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>

        <hr>
        <p><strong>Jumlah Bayar:</strong> {{ 'Rp'.number_format($data['JumlahBayar'], 0, ',', '.') }}</p>
        <p><strong>Kembalian:</strong> {{ 'Rp'.number_format($data['kembalian'], 0, ',', '.') }}</p>

        <div class="header">
            <p>Terima kasih telah berbelanja!</p>
        </div>
    </div>
</body>
</html>
