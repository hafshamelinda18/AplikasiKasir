<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Produk Keluar</title>
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
        <h1 style="margin: 0; font-family: 'Times New Roman', serif;">Laporan Produk Keluar</h1>
        <p style="margin: 0; font-family: 'Times New Roman', serif;">Periode: {{ \Carbon\Carbon::parse($startDate)->format('d-m-Y') }} s/d {{ \Carbon\Carbon::parse($endDate)->format('d-m-Y') }}</p>
        <hr>
    </div>
   
   <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Produk</th>
                <th>Nama Produk</th>
                <th>Jumlah Keluar</th>
                <th>Tanggal Keluar</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
        @php $no = 1; @endphp <!-- Deklarasi variabel nomor urut -->
            @foreach($produkKeluar as $item)
                @foreach($item->detailkeluar as $detail)
                    <tr>
                        <td>{{ $no++ }}</td> <!-- Increment variabel setiap iterasi -->
                        <td>{{ $detail->produk ? $detail->produk->KodeProduk : 'N/A' }}</td>
                        <td>{{ $detail->produk ? $detail->produk->NamaProduk : 'N/A' }}</td>
                        <td>{{ $detail->JumlahKeluar }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->tanggal_keluar)->format('d-m-Y') }}</td>
                        <td>{{ $item->keterangan }}</td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>

</body>
</html>
