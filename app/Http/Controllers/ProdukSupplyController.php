<?php

namespace App\Http\Controllers;
use App\ProdukSupply;
use App\Pemasok;
use App\Produk;
use App\SupplyDetail;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class ProdukSupplyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $query = ProdukSupply::query();
        
        if ($search) {
            $query->where('TanggalSupply', 'LIKE', '%' . $search . '%')
                  ->orWhereHas('DetailSup.produk', function($q) use ($search) {
                      $q->where('NamaProduk', 'LIKE', '%' . $search . '%');
                  });
        }
        $query->orderBy('SupplyID', 'desc');
        // Ambil data dengan pagination
        $produksupplys = $query->paginate(10);
    

        return view('produksupply.index', compact('produksupplys', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $produks = Produk::all();
        $pemasoks = Pemasok::all();
        return view('produksupply.create', [
            'pemasoks'=> $pemasoks,
            'produks' => $produks 
        ]);
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
            'PemasokID' => 'required|array|min:1',
            'PemasokID.*' => 'required|exists:pemasoks,PemasokID',
            'TanggalSupply' => 'required|date',
            'tanggal_kadaluarsa' => 'nullable|array',
            'tanggal_kadaluarsa.*' => 'nullable|date',
            'ProdukID' => 'required|array|min:1',
            'ProdukID.*' => 'exists:produk,ProdukID',
            'JumlahMasuk' => 'required|array|min:1',
            'JumlahMasuk.*' => 'required|numeric|min:1',
            'HargaBeli' => 'required|array|min:1',
            'HargaBeli.*' => 'required|numeric|min:0',
            'Totalharga' => 'required|numeric|min:0',
            
        ]);
    
        // Step 2: Simpan data BarangMasuk
        $produkSupply = ProdukSupply::create([
            'TanggalSupply' => $request->TanggalSupply,
            'Totalharga' => $request->Totalharga,
        ]);
    
        // Step 3: Loop untuk menyimpan setiap detail barang masuk dan update stok
        foreach ($request->ProdukID as $index => $ProdukID) {
            try {
                // Ambil data barang
                $produk = Produk::findOrFail($ProdukID);
    
                // Update stok barang
                $produk->Stok += $request->JumlahMasuk[$index];
                $produk->save();
    
                // Simpan detail barang masuk ke BarangMasukDetail
                $produkSupply->DetailSup()->create([
                    'ProdukID' => $ProdukID,
                    'JumlahMasuk' => $request->JumlahMasuk[$index],
                    'HargaBeli' => $request->HargaBeli[$index],
                    'PemasokID' => $request->PemasokID[$index], // Simpan pemasok
                    'tanggal_kadaluarsa' => $request->tanggal_kadaluarsa[$index] ?? null, // Gunakan null jika kosong
                ]);
    
                // Log data sebelum menyimpan detail
                Log::info('Detail ProdukSupply:', [
                    'SupplyID' => $produkSupply->SupplyID,
                    'ProdukID' => $ProdukID,
                    'JumlahMasuk' => $request->JumlahMasuk[$index],
                    'HargaBeli' => $request->HargaBeli[$index],
                    'PemasokID' => $request->PemasokID[$index],
                    'tanggal_kadaluarsa' => $request->tanggal_kadaluarsa[$index] ?? null,
                ]);
            } catch (\Exception $e) {
                Log::error('Gagal menyimpan detail ProdukSupply:', [
                    'error' => $e->getMessage(),
                    'ProdukID' => $ProdukID,
                    'JumlahMasuk' => $request->JumlahMasuk[$index],
                    'HargaBeli' => $request->HargaBeli[$index],
                    'PemasokID' => $request->PemasokID[$index],
                    'tanggal_kadaluarsa' => $request->tanggal_kadaluarsa[$index] ?? null,
                ]);
            }
        }
    
        return redirect()->route('produksupply.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $produkSupply = ProdukSupply::with(['DetailSup.produk'])->findOrFail($id);
        return view('produksupply.show', compact('produkSupply'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $produkSupply = ProdukSupply::findOrFail($id);
        $produks = Produk::all();
        $pemasoks = Pemasok::all();

        return view('produksupply.edit', compact('produkSupply', 'produks', 'pemasoks'));
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

    $detailSupply = SupplyDetail::where('SupplyID', $id)->get();
    SupplyDetail::where('SupplyID', $id)->delete();
    ProdukSupply::destroy($id);
        return redirect()->route('produksupply.index')->with('success', 'Data produk Keluar berhasil dihapus.');
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
        $produkSupply = ProdukSupply::whereBetween('TanggalSupply', [$startDate, $endDate])
            ->with('detailSup.produk')
            ->get();
    
        // Generate PDF dengan view
        $pdf = Pdf::loadView('cetak-produk-supply', compact('produkSupply', 'startDate', 'endDate'));
        return $pdf->stream('laporan-produk-supply.pdf');
    }

    public function laporanProdukSupply(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
    
        $produkSupply = ProdukSupply::whereBetween('TanggalSupply', [$startDate, $endDate])
                        ->with('detailSup.produk')
                        ->paginate(10);
        
        return view('laporan-produk-supply', compact('produkSupply'));
    }
}
