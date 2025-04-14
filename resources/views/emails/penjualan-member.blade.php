<!DOCTYPE html>
<html>
<head>
    <title>Konfirmasi Penjualan</title>
</head>
<body>
    <h1>Halo, {{ $pelanggan->NamaPelanggan }}!</h1>
    <p>Terima kasih atas pembelian Anda pada tanggal {{ $penjualan->TanggalPenjualan }}.</p>
    <p>Total harga: {{ $penjualan->TotalHarga }}</p>
    <p>Semoga Anda puas dengan produk kami!</p>
    <p>Hormat kami, <br> Toko Kami</p>
</body>
</html>
