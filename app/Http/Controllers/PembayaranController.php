<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Pembayaran;
use App\MetodeBayar;
use App\Penjualan;
use App\Detail;
use App\ProfilToko;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\PembayaranMail;
class PembayaranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pembayarans = Pembayaran::with('penjualan', 'metode')->paginate(10);

        return view('pembayaran.index', compact('pembayarans'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($PenjualanID = null)
    {
        $penjualan = Penjualan::with('detail.produk', 'pelanggan')->findOrFail($PenjualanID);

        $metode_bayars = MetodeBayar::all();
    
        return view('pembayaran.create', compact('penjualan', 'metode_bayars'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
{
    $request->validate([
        'TanggalPembayaran' => 'required',
        'PenjualanID' => 'required|exists:penjualans,PenjualanID',
        'MetodeID' => 'required|exists:metode_bayar,MetodeID',
        'JumlahBayar' => 'required|numeric|min:0',
        'Kembalian' => 'required|numeric|min:0'
    ]);

    // Cari data penjualan terkait
    $penjualan = Penjualan::findOrFail($request->PenjualanID);

    // Cek apakah sudah lunas
    if ($penjualan->status_pembayaran == 'lunas') {
        return response()->json([
            'success' => false,
            'message' => 'Pembayaran sudah dilakukan untuk penjualan ini.'
        ], 400);
    }

    // Hitung kembalian
    $kembalian = $request->JumlahBayar - $penjualan->TotalHarga;
    if ($kembalian < 0) {
        return response()->json([
            'success' => false,
            'message' => 'Jumlah bayar tidak cukup untuk melunasi penjualan ini.'
        ], 400);
    }

    // Simpan pembayaran
    $pembayaran = Pembayaran::create([
        'TanggalPembayaran' => $request->TanggalPembayaran,
        'PenjualanID' => $request->PenjualanID,
        'MetodeID' => $request->MetodeID,
        'JumlahBayar' => $request->JumlahBayar,
        'Kembalian' => $kembalian
    ]);

    // Ubah status penjualan menjadi lunas
    $penjualan->status_pembayaran = 'lunas';
    $penjualan->save();

    // Kirim email jika penjualan memiliki pelanggan
    if ($penjualan->pelanggan) {
        $pelanggan = $penjualan->pelanggan;
        $profilToko = ProfilToko::first();
        $data = [
            'pelanggan' => $pelanggan,
            'JumlahBayar' => $request->JumlahBayar,
            'kembalian' => $kembalian,
            'penjualan' => $penjualan,
            'pembayaran' => $pembayaran,
            'profilToko' => $profilToko 

        ];

        // Mengirim email ke pelanggan
        \Mail::to($pelanggan->email, $pelanggan->NamaPelanggan)
            ->send(new PembayaranMail($data));  // Jangan lupa kirim data ke dalam email

    }

    // Berikan response sukses
    return response()->json([
        'success' => true,
        'message' => 'Pembayaran berhasil dilakukan.',
        'kembalian' => $kembalian
    ]);
}


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function struk($penjualanID)
    {
        // Cari pembayaran berdasarkan PenjualanID
        $pembayaran = Pembayaran::with('penjualan.detail.produk', 'penjualan.pelanggan')
            ->where('PenjualanID', $penjualanID)
            ->firstOrFail();
    
        $penjualan = $pembayaran->penjualan;
        $profilToko = ProfilToko::first();
        return view('pembayaran.struk', compact('pembayaran', 'penjualan', 'profilToko'));
    }
    
    public function strukDariPenjualan($penjualanID)
    {
        $pembayaran = Pembayaran::with('penjualan.pelanggan', 'penjualan.detail.produk')
                        ->where('PenjualanID', $penjualanID)
                        ->latest()
                        ->first(); // Ambil pembayaran terbaru (kalau ada cicilan)
    
        if (!$pembayaran) {
            return response()->json('Struk tidak ditemukan', 404);
        }
    
        $penjualan = $pembayaran->penjualan;
        $profilToko = ProfilToko::first();
    
        return view('pembayaran.struk', compact('pembayaran', 'penjualan', 'profilToko'))->render();
    }
    
    
}
