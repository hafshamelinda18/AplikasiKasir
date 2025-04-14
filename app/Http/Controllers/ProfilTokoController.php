<?php

namespace App\Http\Controllers;
use App\ProfilToko;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class ProfilTokoController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search'); 
        $query = ProfilToko::query();

        if ($search) { 
            $query->where('NamaToko', 'LIKE', '%' . $search . '%');
        }
        $query->orderBy('IdToko', 'desc');
        $tokos = $query->paginate(10);
        
        return view('profiltoko.index', [
        'tokos' => $tokos,
        'search' => $search
        ]);
    }

    public function create()
    {
        $profil = ProfilToko::first();
        if ($profil) {
            return redirect()->route('profiltoko.show', $profil->IdToko)
                             ->with('info', 'Anda sudah mendaftarkan profil toko.');
        }
    
        return view('profiltoko.create');
        
    }

    public function store(Request $request)
    {
        $request->validate([
            'NamaToko' => 'required|string|max:50',
            'Pemilik' => 'required|string|max:50',
            'Alamat' => 'required',
            'NoTelp' => 'required|max:15',
            'email' => 'required|email|unique:profil_toko',
            'logo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('uploads', 'public');
            
        } else {
            $logoPath = null;
        }
        $toko = ProfilToko::create([
            'NamaToko' => $request->NamaToko,
            'Pemilik' => $request->Pemilik,
            'Alamat' => $request->Alamat,
            'NoTelp' => $request->NoTelp,
            'email' => $request->email,
            'logo' => $logoPath,
            
        ]);
    
        return redirect()->route('profiltoko.show', $toko->IdToko)->with('success', 'Data Berhasil Ditambahkan.');
    }

    public function edit($id)
    {
        $toko = ProfilToko::findOrFail($id);

        return view('profiltoko.edit', compact('toko'));
    }

    public function update(Request $request, $id)
{
    // Temukan toko berdasarkan id
    $toko = ProfilToko::find($id);

    // Validasi data form yang dikirim
    $request->validate([
        'NamaToko' => 'required|string|max:50',
        'Pemilik' => 'required|string|max:50',
        'Alamat' => 'required',
        'NoTelp' => 'required|max:15',
        'email' => 'required|email', // Tambahkan validasi email
        'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Gambar tidak wajib diisi
    ]);

    // Cek apakah ada file logo yang diunggah
    if ($request->hasFile('logo')) {
        // Hapus logo lama jika ada
        if ($toko->logo) {
            Storage::delete('public/' . $toko->logo);
        }
        // Simpan logo baru
        $logoPath = $request->file('logo')->store('uploads', 'public');
    } else {
        // Jika tidak ada logo baru, simpan logo lama
        $logoPath = $toko->logo;
    }

    // Update data toko
    $toko->update([
        'NamaToko' => $request->NamaToko,
        'Pemilik' => $request->Pemilik,
        'Alamat' => $request->Alamat,
        'NoTelp' => $request->NoTelp,
        'email' => $request->email,
        'logo' => $logoPath,
    ]);

    // Redirect ke halaman profil toko dengan pesan sukses
    return redirect()->route('profiltoko.show', $toko->IdToko)->with('success', 'Data Berhasil Diperbarui');
}



    public function destroy(ProfilToko $toko)
    {
        $toko->delete();
        return redirect()->route('profiltoko.index')->with('success', 'Data Berhasil DiHapus');
    }

    public function show()
    {
        $toko = ProfilToko::first();
        return view('profiltoko.show', compact('toko'));
    }
}
