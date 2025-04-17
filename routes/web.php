<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use App\Http\Controllers\AuthentificationController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\SatuanController;
use App\Http\Controllers\PemasokController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\ProdukSupplyController;
use App\Http\Controllers\MetodeBayarController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProfilTokoController;
use App\Http\Controllers\ProdukKeluarController;

Route::get('/send-test-email', [HomeController::class, 'sendTestEmail'])->name('send-test-email');
Route::get('/', function () {
    return view('welcome');
});
Route::get('/login', [AuthentificationController::class, 'showFormLogin'])->name('login');
Route::post('/login', [AuthentificationController::class, 'postLogin'])->name('login.post');
Route::get('/register', [AuthentificationController::class, 'showFormRegister'])->name('register');
Route::post('/register-post', [AuthentificationController::class, 'postRegister'])->name('register.post');


Route::middleware(['auth', 'role:admin,kasir'])->group(function () {

Route::post('/logout', [AuthentificationController::class, 'Logout'])->name('logout');
Route::middleware('auth')->group(function() {
Route::resource('pembayaran', PembayaranController::class);

Route::get('pembayaran/create/{PenjualanID?}', [PembayaranController::class, 'create'])->name('pembayaran.create');
Route::resource('penjualan', PenjualanController::class);
Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
Route::post('/check-stock', [PenjualanController::class, 'checkStock'])->name('checkStock');
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/pelanggan', [PelangganController::class, 'index'])->name('pelanggan.index');
Route::get('/produk', [ProdukController::class, 'index'])->name('produk.index');

Route::patch('/penjualan/{PenjualanID}/batalkan', [PenjualanController::class, 'batalkan'])->name('penjualan.batalkan');

Route::get('pembayaran/struk/{penjualanID}', [PembayaranController::class, 'struk'])->name('pembayaran.struk');

Route::post('/produk/cek/{id}', [ProdukController::class, 'cek'])->name('produk.cek');

Route::get('/cetak-laporan-penjualan', [PenjualanController::class, 'cetakLaporan'])->name('cetak-laporan-penjualan');
Route::get('/laporan-penjualan', [PenjualanController::class, 'laporanPenjualan'])->name('laporan-penjualan');

Route::get('/cetak-laporan-produk-supply', [ProdukSupplyController::class, 'cetakLaporan'])->name('cetak-laporan-produk-supply');
Route::get('/laporan-produk-supply', [ProdukSupplyController::class, 'laporanProdukSupply'])->name('laporan-produk-supply');

Route::get('/cetak-laporan-produk-keluar', [ProdukKeluarController::class, 'cetakLaporan'])->name('cetak-laporan-produk-keluar');
Route::get('/laporan-produk-keluar', [ProdukKeluarController::class, 'laporanProdukKeluar'])->name('laporan-produk-keluar');
});




Route::middleware(['auth', 'role:admin'])->group(function () {
Route::get('/pelanggan/create', [PelangganController::class, 'create'])->name('pelanggan.create');
Route::post('/pelanggan', [PelangganController::class, 'store'])->name('pelanggan.store');
Route::get('/pelanggan/{pelanggan}', [PelangganController::class, 'show'])->name('pelanggan.show');
Route::get('/pelanggan/{pelanggan}/edit', [PelangganController::class, 'edit'])->name('pelanggan.edit');
Route::put('/pelanggan/{pelanggan}', [PelangganController::class, 'update'])->name('pelanggan.update');
Route::delete('/pelanggan/{pelanggan}', [PelangganController::class, 'destroy'])->name('pelanggan.destroy');
Route::resource('metodebayar', MetodeBayarController::class);

Route::get('/produk/create', [ProdukController::class, 'create'])->name('produk.create');
Route::post('/produk', [ProdukController::class, 'store'])->name('produk.store');
Route::get('/produk/{produk}', [ProdukController::class, 'show'])->name('produk.show');
Route::get('/produk/{produk}/edit', [ProdukController::class, 'edit'])->name('produk.edit');
Route::put('/produk/{produk}', [ProdukController::class, 'update'])->name('produk.update');
Route::delete('/produk/{produk}', [ProdukController::class, 'destroy'])->name('produk.destroy');

Route::resource('kategori', KategoriController::class);
Route::resource('satuan', SatuanController::class);
Route::resource('pemasok', PemasokController::class);
Route::resource('produksupply', ProdukSupplyController::class);
Route::resource('produkkeluar', ProdukKeluarController::class);

Route::get('/profiltoko', [ProfilTokoController::class, 'index'])->name('profiltoko.index');
Route::get('/profiltoko/create', [ProfilTokoController::class, 'create'])->name('profiltoko.create');
Route::post('/profiltoko', [ProfilTokoController::class, 'store'])->name('profiltoko.store');
Route::get('/profiltoko/{profiltoko}', [ProfilTokoController::class, 'show'])->name('profiltoko.show');
Route::get('/profiltoko/{profiltoko}/edit', [ProfilTokoController::class, 'edit'])->name('profiltoko.edit');
Route::put('/profiltoko/{profiltoko}', [ProfilTokoController::class, 'update'])->name('profiltoko.update');
Route::delete('/profiltoko/{profiltoko}', [ProfilTokoController::class, 'destroy'])->name('profiltoko.destroy');

// Route::get('/profiltoko', [ProfilTokoController::class, 'show'])->name('profiltoko.show');
Route::get('/user', [AuthentificationController::class, 'index'])->name('user.index');
    });
    Route::get('/penjualan/{id}/struk', [PembayaranController::class, 'strukDariPenjualan']);
   
    Route::get('/penjualan/{id}/struk', [PembayaranController::class, 'struk'])->name('pembayaran.struk');

    Route::get('/get-regencies/{province_id}', [PelangganController::class, 'getRegencies']);
    Route::get('/get-districts/{regency_id}', [PelangganController::class, 'getDistricts']);
    Route::get('/get-villages/{district_id}', [PelangganController::class, 'getVillages']);
});