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
                <th>Kode Produk</th>
                <th>Nama Produk</th>
                <th>Jumlah Masuk</th>
                <th>Tanggal Masuk</th>
                <th>Tanggal Kadaluarsa</th>
            </tr>
        </thead>
        <tbody>
        @php $no = 1; @endphp <!-- Deklarasi variabel nomor urut -->
            @foreach($barangMasuk as $item)
                @foreach($item->detailSup as $detail)
                    <tr>
                        <td>{{ $no++ }}</td> <!-- Increment variabel setiap iterasi -->
                        <td>{{ $detail->barang ? $detail->produk->KodeProduk : 'N/A' }}</td>
                        <td>{{ $detail->barang ? $detail->produk->NamaProduk : 'N/A' }}</td>
                        <td>{{ $detail->JumlahMasuk }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->TanggalSupply)->format('d-m-Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($detail->tanggal_kadaluarsa)->format('d-m-Y') }}</td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>

</body>
</html>
