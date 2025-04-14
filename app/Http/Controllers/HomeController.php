<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Produk;
use App\Penjualan;
use App\ProdukSupply;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\TestEmail;

// use App\Detail;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $belumLunas = Penjualan::where('status_pembayaran', 'belum lunas')->get();
        $hampirHabis = Produk::where('Stok', '<', 10)->get();

        $produkSupply = ProdukSupply::whereHas('DetailSup', function ($query) {
            $query->whereHas('produk', function ($query) {
                $query->where('tanggal_kadaluarsa', '<=', Carbon::now()->addDays(30))
                ->where('tanggal_kadaluarsa', '>', Carbon::now()) // Barang yang kadaluarsa dalam 30 hari ke depan
                ->whereNull('tanggal_cek'); // Exclude checked items          
            });
        })->with('DetailSup.produk')->get();
        
        $produkSudahKadaluarsa = ProdukSupply::whereHas('DetailSup', function ($query) {
            $query->whereHas('produk', function ($query) {
                $query->where('tanggal_kadaluarsa', '<', Carbon::now()) // Barang yang sudah kadaluarsa
                      ->whereNull('tanggal_cek'); // Exclude checked items
            });
        })->with('DetailSup.produk')->get();

        // Ambil produk dengan jumlah terjual terbanyak
        $bestSellers = Produk::select('produk.ProdukID', 'produk.NamaProduk', 'produk.Harga', 'produk.Keterangan', 'produk.Keterangan', 'produk.image', DB::raw('SUM(detail_penjualan.JumlahProduk) as total_terjual'))
                        ->join('detail_penjualan', 'produk.ProdukID', '=', 'detail_penjualan.ProdukID')
                        ->groupBy('produk.ProdukID', 'produk.NamaProduk', 'produk.Harga', 'produk.Keterangan', 'produk.Keterangan', 'produk.image') // Pastikan groupBy sesuai dengan kolom
                        ->orderBy('total_terjual', 'desc') // Urutkan dari yang paling banyak terjual
                        ->take(5) // Ambil 5 produk terlaris
                        ->get();

         // Ambil data penjualan per bulan
         $monthlyIncome = Penjualan::selectRaw('MONTHNAME(TanggalPenjualan) as month_name, SUM(TotalHarga) as total')
         ->groupBy('month_name')
         ->orderBy(DB::raw('MONTH(TanggalPenjualan)'))
         ->pluck('total', 'month_name')
         ->toArray();  // Convert result to an array
     
  
    // Dapatkan bulan dan tahun saat ini
    $currentMonth = Carbon::now()->month;
    $currentYear = Carbon::now()->year;
    $currentMonthName = Carbon::now()->locale('id')->translatedFormat('F'); // Mendapatkan nama bulan dalam bahasa Indonesia

    // Ambil data penjualan per minggu hanya dari bulan dan tahun saat ini
    $weeklyIncomeData = Penjualan::selectRaw('WEEK(TanggalPenjualan, 1) - WEEK(DATE_SUB(TanggalPenjualan, INTERVAL DAY(TanggalPenjualan)-1 DAY), 1) + 1 as week, SUM(TotalHarga) as total_income')
        ->whereMonth('TanggalPenjualan', $currentMonth)
        ->whereYear('TanggalPenjualan', $currentYear)
        ->groupBy('week')
        ->get()
        ->pluck('total_income', 'week')
        ->toArray();

    // Definisikan nama minggu
    $weeklyIncome = [];

    // Assign nama minggu dan bulan sesuai data yang ada
    foreach ($weeklyIncomeData as $week => $income) {
        // Format: Minggu Ke-X Bulan NamaBulan
        $weeklyIncome["Minggu Ke-$week Bulan $currentMonthName"] = $income;
    }

        return view('home', compact('belumLunas', 'hampirHabis', 'produkSudahKadaluarsa', 'produkSupply', 'bestSellers', 'monthlyIncome', 'weeklyIncome'));
    }

    public function sendTestEmail()
{
    Mail::to('tugashafsha@gmail.com')->send(new TestEmail);  // Ganti dengan email tujuan

    return 'Email sent!';
}

}