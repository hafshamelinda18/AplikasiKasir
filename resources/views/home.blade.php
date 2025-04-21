@extends('template.style')

@section('content')
<div class="container mt-4">
    <!-- Notifikasi Success -->
    @if(session('success'))
        <div id="success-alert" class="alert alert-success"> 
            {{ session('success') }} 
        </div>
    @endif

    <!-- Welcome Card -->
    <div class="row mb-4">
        <div class="card shadow-sm border rounded d-flex flex-md-row align-items-center justify-content-between">
            <div class="p-3">
                <h3 class="card-title font-weight-bold">Selamat Datang!</h3>
                <p class="card-text">
                    Hai, <strong>{{ Auth::user()->name }}</strong>! Kami senang melihat Anda kembali. Siap untuk melanjutkan pekerjaan Anda hari ini?
                </p>
            </div>
            <img src="{{ asset('assets/img/wlc.jpg') }}" alt="Profile Picture" class="img-fluid rounded-circle shadow" style="width: 150px; height: 150px;">
        </div>
    </div>

    <!-- Dashboard Metrics -->
    <div class="row mb-5">
        <!-- Produk Hampir Habis -->
        <div class="col-md-6 mb-4">
            <h5 class="text-center">Produk Hampir Habis</h5>
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="bg-danger text-white">
                        <tr>
                            <th>Produk</th>
                            <th>Kategori</th>
                            <th>Stok</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($hampirHabis as $produk)
                            <tr>
                                <td>{{ $produk->NamaProduk }}</td>
                                @if ($produk->kategori)
            <td>{{ $produk->kategori->NamaKategori }}</td>
        @else
            <td><span class="text-danger">Tidak Ada Kategori</span></td>
        @endif

                                <td>{{ $produk->Stok }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Produk Kadaluarsa -->
        <div class="col-md-6 mb-4">
            <h5 class="text-center">Produk Kadaluarsa</h5>
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="bg-danger text-white">
                        <tr>
                            <th>Produk</th>
                            <th>Kategori</th>
                            <th>Kadaluarsa</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($produkSupply as $item)
                            @foreach ($item->DetailSup as $detail)
                                @if (!is_null($detail->tanggal_kadaluarsa) && Carbon\Carbon::parse($detail->tanggal_kadaluarsa)->diffInDays(now()) <= 30 && is_null($detail->tanggal_cek))
                                    <tr>
                                        <td>{{ $detail->produk->NamaProduk }}</td>
                                                                            @if ($produk->kategori)
                                                <td>{{ $detail->produk->kategori->NamaKategori }}</td>
                                            @else
                                                <td><span class="text-danger">Tidak Ada Kategori</span></td>
                                            @endif
                                        <td>{{ Carbon\Carbon::parse($detail->tanggal_kadaluarsa)->format('d M Y') }}</td>
                                    </tr>
                                @endif
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Best Seller dan Pemasukan -->
    <div class="row mt-4">
        <div class="col-md-6 mb-4">
            <!-- Best Seller Table -->
            <h4 class="text-center mb-3">Produk Best Seller</h4>
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>Produk</th>
                            <th>Total Terjual</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($bestSellers as $product)
                            <tr>
                                <td>{{ $product->NamaProduk }}</td>
                                <td>{{ $product->total_terjual }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pemasukan Per Minggu -->
            <h4 class="text-center mb-3">Pemasukan Per-Minggu Bulan {{ $monthName }}</h4>
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>Minggu</th>
                            <th>Total Pemasukan (Rp)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($weeklyIncome as $weekName => $income)
                            <tr>
                                <td>{{ $weekName }}</td>
                                <td>{{ number_format($income, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Grafik Pendapatan Perbulan -->
        <div class="col-md-6">
            <h4 class="text-center mb-3">Grafik Pendapatan Perbulan</h4>
            <canvas id="incomeChart"></canvas>
        </div>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('incomeChart').getContext('2d');
    const incomeChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode(array_keys($monthlyIncome)) !!},
            datasets: [{
                label: 'Pendapatan (Rp)',
                data: {!! json_encode(array_values($monthlyIncome)) !!},
                backgroundColor: 'rgba(54, 162, 235, 0.6)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>

<!-- Auto-hide alert after 5 seconds -->
<script>
    setTimeout(function() {
        const alert = document.getElementById('success-alert');
        if (alert) {
            alert.style.transition = "opacity 0.5s ease-out";
            alert.style.opacity = 0;
            setTimeout(() => alert.remove(), 500);
        }
    }, 5000);
</script>
@endsection
