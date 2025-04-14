<?php

namespace App\Http\Controllers;
use App\Penjualan;
use App\Pelanggan;
use App\Detail;
use App\Produk;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail; // Import Mail untuk pengiriman email
use App\Mail\PenjualanMember;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $query = Penjualan::query();

        if ($search) {
            $query->where('TanggalPenjualan', 'LIKE', '%' . $search . '%')
                ->orWhereHas('detail.produk', function($q) use ($search) {
                    $q->where('NamaProduk', 'LIKE', '%' . $search . '%');
                });
        }
        $query->orderBy('PenjualanID', 'desc');
        // Ambil data dengan pagination
        $penjualans = $query->paginate(10);

        return view('penjualan.index', compact('penjualans', 'search'));

    }

    public function create()
    {
        $produk = Produk::all();
        $pelanggan = Pelanggan::all();
        return view('penjualan.create', [
            'pelanggan'=> $pelanggan,
            'produk' => $produk 
        ]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $isMember = $request->input('isMember');
    
        // Validasi
        $rules = [
            'TanggalPenjualan' => 'required',
            'ProdukID' => 'required|array|min:1',
            'ProdukID.*' => 'exists:produk,ProdukID',
            'JumlahProduk' => 'required|array|min:1',
            'JumlahProduk.*' => 'required|numeric|min:0',
            'TotalHarga' => 'required|numeric|min:0',
            'Harga' => 'required|array|min:1',
            'Harga.*' => 'required|numeric|min:0',
            'NamaKasir' => 'required'
        ];
    
        if ($isMember) {
            $rules['PelangganID'] = 'required|exists:pelanggans,PelangganID';
        }
    
        $request->validate($rules);
    
        foreach ($request->ProdukID as $index => $ProdukID) {
            $produk = Produk::find($ProdukID);
    
            if ($produk && $produk->Stok < $request->JumlahProduk[$index]) {
                return redirect()->back()->with('error', 'Stok tidak cukup untuk produk ' . $produk->NamaProduk);
            }
        }
    
        $penjualan = Penjualan::create([
            'TanggalPenjualan' => $request->TanggalPenjualan,
            'PelangganID' => $isMember ? $request->PelangganID : null,
            'TotalHarga' => $request->TotalHarga,
            'NamaKasir' => $request->NamaKasir
        ]);
    
        foreach ($request->ProdukID as $index => $ProdukID) {
            try {
                $produk = Produk::findOrFail($ProdukID);
    
                if ($produk->Stok >= $request->JumlahProduk[$index]) {
                    $produk->Stok -= $request->JumlahProduk[$index];
                    $produk->save();
    
                    $penjualan->detail()->create([
                        'PenjualanID' => $penjualan->PenjualanID,
                        'ProdukID' => $ProdukID,
                        'Harga' => $request->Harga[$index] ?? 0,
                        'JumlahProduk' => $request->JumlahProduk[$index]
                    ]);
    
                    Log::info('Detail Penjualan:', [
                        'PenjualanID' => $penjualan->PenjualanID,
                        'ProdukID' => $ProdukID,
                        'Harga' => $request->Harga[$index] ?? 0,
                        'JumlahProduk' => $request->JumlahProduk[$index]
                    ]);
    
                } else {
                    Log::error('Stok tidak cukup untuk Produk ID:', [
                        'ProdukID' => $ProdukID,
                        'JumlahProduk' => $request->JumlahProduk[$index],
                        'stok_saat_ini' => $produk->Stok,
                    ]);
                    continue;
                }
    
            } catch (\Exception $e) {
                Log::error('Gagal menyimpan detail penjualan:', [
                    'error' => $e->getMessage(),
                    'PenjualanID' => $penjualan->PenjualanID,
                    'ProdukID' => $ProdukID,
                    'Harga' => $request->Harga[$index] ?? 0,
                    'JumlahProduk' => $request->JumlahProduk[$index],
                    'NamaKasir' => $request->NamaKasir
                ]);
            }
        }
    
        // Jika pelanggan adalah member, kirim email konfirmasi
        if ($isMember) {
            $pelanggan = $penjualan->pelanggan; 
    \Mail::raw('Penjualan Berhasil', function ($message) use ($pelanggan) {
        $message->to($pelanggan->email, $pelanggan->Nama);
        $message->subject('Penjualan Telah Dilaksanakan.');
    });


        }
    
        return redirect()->route('pembayaran.create', ['PenjualanID' => $penjualan->PenjualanID])
            ->with('success', 'Data Penjualan Berhasil Disimpan. Silakan lakukan pembayaran.');
    }



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $penjualan = Penjualan::with(['detail.produk'])->findOrFail($id);
        return view('penjualan.show', compact('penjualan'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $pelanggan = Pelanggan::all();
        $penjualan = Penjualan::findOrFail($id);
        return view('penjualan.edit', compact('penjualan', 'pelanggan'));
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
        $request->validate([
            'TanggalPenjualan' => 'required',
            'TotalHarga' => 'required|numeric|min:0',
            'PelangganID' => 'required|exists:pelanggans,PelangganID'
        ]);

        $penjualan = Penjualan::findOrfail($id);
        $penjualan->update($request->all());
        return redirect()->route('penjualan.index')->with('success', 'Data Berhasil Diperbarui.');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Penjualan $penjualan)
{
    
    $penjualan->detail()->delete();
    $penjualan->delete();
    return redirect()->route('penjualan.index')->with('success', 'Data Berhasil Dihapus.');
}


public function batalkan($PenjualanID)
{
    // Ambil data penjualan
    $penjualan = Penjualan::find($PenjualanID);
    
    // Pastikan penjualan ada
    if (!$penjualan) {
        return redirect()->back()->with('error', 'Penjualan tidak ditemukan.');
    }

    // Periksa apakah penjualan sudah lunas atau belum
    if ($penjualan->status_pembayaran == 'lunas') {
        return redirect()->back()->with('error', 'Penjualan sudah lunas dan tidak dapat dibatalkan.');
    }

    // Ubah status penjualan menjadi 'dibatalkan'
    $penjualan->status_pembayaran = 'dibatalkan';
    $penjualan->save();

    // Kembalikan stok produk yang terjual
    $this->kembalikanStok($penjualan);

    return redirect()->route('penjualan.index')->with('success', 'Penjualan berhasil dibatalkan dan stok telah dikembalikan.');
}

private function kembalikanStok($penjualan)
{
    // Asumsikan penjualan memiliki relasi 'items' untuk detail penjualan,
    // dimana setiap item memiliki 'produk_id' dan 'jumlah'
    foreach ($penjualan->detail as $item) {
        $produk = Produk::find($item->ProdukID);
        if ($produk) {
            $produk->Stok += $item->JumlahProduk; // Tambahkan kembali jumlah yang terjual
            $produk->save();
        }
    }
}

public function cetakLaporan(Request $request)
{
    $startDate = $request->get('start_date');
    $endDate = $request->get('end_date');
    
    // Validasi input tanggal
    if (!$startDate || !$endDate) {
        return redirect()->back()->with('error', 'Silakan isi tanggal awal dan tanggal akhir untuk mencetak laporan.');
    }

    // Ambil data barang masuk berdasarkan rentang tanggal
    $penjualan = Penjualan::whereBetween('TanggalPenjualan', [$startDate, $endDate])
        ->with('detail.produk')
        ->get();

    // Generate PDF dengan view
    $pdf = Pdf::loadView('cetak-penjualan', compact('penjualan', 'startDate', 'endDate'));
    return $pdf->stream('laporan-penjualan.pdf');
}

public function laporanPenjualan(Request $request)
{
    $startDate = $request->input('start_date');
    $endDate = $request->input('end_date');

    $penjualan = Penjualan::whereBetween('TanggalPenjualan', [$startDate, $endDate])
                    ->with('detail.produk')
                    ->paginate(10);
    
    return view('laporan-penjualan', compact('penjualan'));
}

}
