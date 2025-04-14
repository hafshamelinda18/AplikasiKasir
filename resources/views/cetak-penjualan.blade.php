<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Produk Masuk</title>
    <style>
        body {
            font-family: 'Times New Roman', serif;
        }
        .kop-surat {
            text-align: center;
            margin-bottom: 20px;
           
        }
        .kop-surat h1 {
            margin: 0;
            font-size: 24px;
        }
        .kop-surat p {
            margin: 0;
            font-size: 14px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    

    <div class="kop-surat">
        <h1 style="margin: 0; font-family: 'Times New Roman', serif;">Laporan Produk Masuk</h1>
        <p style="margin: 0; font-family: 'Times New Roman', serif;">Periode: {{ \Carbon\Carbon::parse($startDate)->format('d-m-Y') }} s/d {{ \Carbon\Carbon::parse($endDate)->format('d-m-Y') }}</p>
        <hr>
    </div>
   
   <table>
        <thead>
            <tr>
            <th>No</th>
                    <th>Id Penjualan</th>
                    <th>Tanggal Penjualan</th>
                    <th>Pelanggan</th>
                    <th>Produk</th>
                    <th>Total Harga</th>
                </tr>
            </thead>
            <tbody>
    @php $no = 1; @endphp
    @foreach($penjualan as $item)
        <tr>
            <td>{{ $no++ }}</td>
            <td>{{ $item->PenjualanID }}</td>
            <td>{{ \Carbon\Carbon::parse($item->TanggalPenjualan)->format('d-m-Y') }}</td>

            <!-- Check if pelanggan exists directly from the penjualan table -->
            <td>
                @if($item->pelanggan)
                    {{ $item->pelanggan->NamaPelanggan }}
                @else
                    <span class="text-danger">No Member</span>
                @endif
            </td>

            <!-- Gabungkan nama produk dalam satu kolom -->
            <td>
                @php
                    $produkNames = $item->detail->map(function($detail) {
                        return $detail->produk->NamaProduk;
                    })->implode(', ');
                @endphp
                {{ $produkNames }}
            </td>

            <td>
                {{ 'Rp'.number_format($item->TotalHarga, 2, ',', '.') }}
            </td>

        </tr>
    @endforeach
</tbody>
    </table>

</body>
</html>
