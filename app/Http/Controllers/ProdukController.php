<?php

namespace App\Http\Controllers;
use App\Produk;
use App\Kategori;
use App\Satuan;
use App\SupplyDetail;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $query = Produk::query();

        if ($search) { 
            $query->where('NamaProduk', 'LIKE', '%' . $search . '%');
        }
        $query->orderBy('ProdukID', 'desc');

        $produks = $query->paginate(10);
        return view('produk.index', compact('produks', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $produkKode = 'P' . str_pad(Produk::max('ProdukID') + 1, 3, '0', STR_PAD_LEFT);
        $kategori = Kategori::all();
        $satuan = Satuan::all();
        return view('produk.create', [
            'kategori' => $kategori,
            'satuan' => $satuan,
            'produkKode' => $produkKode
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
            'KodeProduk' => 'required|unique:produk,KodeProduk',
            'NamaProduk' => 'required|string|max:100',
            'KategoriID' => 'required|exists:kategoris,KategoriID',
            'SatuanID' => 'required|exists:satuans,SatuanID',
            'Harga' => 'required|numeric|min:0',
            'Keterangan' => 'string|max:100',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('uploads', 'public');
            
        } else {
            $imagePath = null;
        }
        Produk::create([
            'NamaProduk' =>$request->NamaProduk,
            'Harga' =>$request->Harga,
            'KategoriID' =>$request->KategoriID,
            'SatuanID' =>$request->SatuanID,
            'Keterangan' => $request->Keterangan,  
            'image' => $imagePath,
            
        ]);
        return redirect()->route('produk.store')->with('success', 'Data Berhasil Ditambahkan.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $produk = Produk::findOrFail($id);
        return view('produk.show', compact('produk'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $produk = Produk::findOrFail($id);
        $kategori = Kategori::all();
        $satuan = Satuan::all();
        return view('produk.edit', compact('produk', 'kategori', 'satuan'));
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
        $produk = Produk::findOrFail($id);
        
        $request->validate([
            // 'KodeProduk' => 'required|unique:produk,KodeProduk',
            'NamaProduk' => 'required|string|max:100',
            'KategoriID' => 'required|exists:kategoris,KategoriID',
            'SatuanID' => 'required|exists:satuans,SatuanID',
            'Harga' => 'required|numeric|min:0',
            'Keterangan' => 'string|max:100',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

         // Proses upload gambar jika ada
            if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($produk->image) {
                Storage::delete('public/' . $produk->image);
            }
            $imagePath = $request->file('image')->store('uploads', 'public');
        } else {
            $imagePath = $produk->image;
        }
        
        $produk->update([  
        'NamaProduk' =>$request->NamaProduk,
        'Harga' =>$request->Harga,
        'KategoriID' =>$request->KategoriID,
        'SatuanID' =>$request->SatuanID,
        'Keterangan' => $request->Keterangan,  
        'image' => $imagePath,]);

        return redirect()->route('produk.index')->with('success', 'Data Berhasil Diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Produk $produk)
    {
        $produk->delete();
        return redirect()->route('produk.index')->with('success', 'Data Berhasil Dihapus');
    }

    public function cek($id)
    {
        $DetailSup = SupplyDetail::findOrFail($id);
        $DetailSup->tanggal_cek = now(); // Set tanggal cek ke waktu sekarang
        $DetailSup->save();

        return redirect()->back()->with('success', 'Produk telah dicek.');
    }
}
