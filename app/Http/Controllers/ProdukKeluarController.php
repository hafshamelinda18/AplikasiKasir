<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ProdukKeluar;
use App\DetailKeluar;
use App\Produk;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;

class ProdukKeluarController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $query = ProdukKeluar::query();
        
        if ($search) {
            $query->where('tanggal_keluar', 'LIKE', '%' . $search . '%')
                  ->orWhereHas('detailkeluar.produk', function($q) use ($search) {
                      $q->where('NamaProduk', 'LIKE', '%' . $search . '%');
                  });
        }
        $query->orderBy('pkID', 'desc');
        // Ambil data dengan pagination
        $produkkeluars = $query->paginate(10);
    

        return view('produkkeluar.index', compact('produkkeluars', 'search'));
    }

    public function create()
    {
        $produks = Produk::all();
        return view('produkkeluar.create', [
            'produks' => $produks 
        ]);
    }

    public function store(Request $request)
    {
        // Step 1: Validasi request
        $validated = $request->validate([
            'tanggal_keluar' => 'required|date',
            'keterangan' => 'required|string',
            'ProdukID' => 'required|array|min:1',
            'ProdukID.*' => 'required|exists:produk,ProdukID', // Validasi barang
            'JumlahKeluar' => 'required|array|min:1',
            'JumlahKeluar.*' => 'required|integer|min:1',
        ]);
    
        // Step 2: Cek apakah JumlahKeluar lebih besar dari stok tersedia
        foreach ($request->ProdukID as $index => $ProdukID) {
            $produk = Produk::findOrFail($ProdukID);
            
            if ($produk->Stok < $request->JumlahKeluar[$index]) {
                return back()->withErrors(['Stok barang ' . $produk->NamaProduk . ' tidak mencukupi!']);
            }
        }
    
        // Step 3: Simpan data BarangKeluar
        $produkKeluar = ProdukKeluar::create([
            'tanggal_keluar' => $request->tanggal_keluar,
            'keterangan' => $request->keterangan,
        ]);
    
        // Step 4: Loop untuk menyimpan setiap detail barang keluar dan update stok
        foreach ($request->ProdukID as $index => $ProdukID) {
            try {
                // Ambil data barang
                $produk = Produk::findOrFail($ProdukID);
    
                // Cek ulang stok barang
                if ($produk->Stok >= $request->JumlahKeluar[$index]) {
                    // Update stok barang
                    $produk->Stok -= $request->JumlahKeluar[$index];
                    $produk->save();
    
                    // Simpan detail barang keluar
                    $produkKeluar->detailkeluar()->create([
                        'pkID' => $produkKeluar->pkID,
                        'ProdukID' => $ProdukID,
                        'JumlahKeluar' => $request->JumlahKeluar[$index],
                    ]);
    
                    // Log data berhasil disimpan
                    Log::info('Detail ProdukKeluar:', [
                        'pkID' => $produkKeluar->pkID,
                        'ProdukID' => $ProdukID,
                        'JumlahKeluar' => $request->JumlahKeluar[$index],
                    ]);
                } else {
                    // Jika stok tidak cukup, jangan simpan
                    Log::error('Stok tidak cukup untuk Produk ID:', [
                        'ProdukID' => $ProdukID,
                        'JumlahKeluar' => $request->JumlahKeluar[$index],
                        'stok_saat_ini' => $produk->Stok,
                    ]);
                    continue;
                }
            } catch (\Exception $e) {
                Log::error('Gagal menyimpan detail ProdukKeluar:', [
                    'error' => $e->getMessage(),
                    'ProdukID' => $ProdukID,
                    'JumlahKeluar' => $request->JumlahKeluar[$index],
                ]);
            }
    
        }
    
        return redirect()->route('produkkeluar.index')->with('success', 'Data Produk Keluar berhasil ditambahkan.');
    }

    public function destroy($id)
{

    $detailKeluar = DetailKeluar::where('pkID', $id)->get();
    DetailKeluar::where('pkID', $id)->delete();
    ProdukKeluar::destroy($id);
        return redirect()->route('produkkeluar.index')->with('success', 'Data produk Keluar berhasil dihapus.');
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
        $produkKeluar = ProdukKeluar::whereBetween('tanggal_keluar', [$startDate, $endDate])
            ->with('detailkeluar.produk')
            ->get();
    
        // Generate PDF dengan view
        $pdf = Pdf::loadView('cetak-produk-keluar', compact('produkKeluar', 'startDate', 'endDate'));
        return $pdf->stream('laporan-produk-keluar.pdf');
    }

    public function laporanProdukKeluar(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
    
        $produkKeluar = ProdukKeluar::whereBetween('tanggal_keluar', [$startDate, $endDate])
                        ->with('detailkeluar.produk')
                        ->paginate(10);
        
        return view('laporan-produk-keluar', compact('produkKeluar'));
    }

}
