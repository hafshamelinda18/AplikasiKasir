<?php

namespace App\Http\Controllers;
use App\Pelanggan;
use App\Notifications\CustomerNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\MemberMail;
class PelangganController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->input('search'); 
        $query = Pelanggan::query();

        if ($search) { 
            $query->where('NamaPelanggan', 'LIKE', '%' . $search . '%');
        }
        $query->orderBy('PelangganID', 'desc');
        $pelanggans = $query->paginate(10);
        
        return view('pelanggan.index', [
        'pelanggans' => $pelanggans,
        'search' => $search
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pelanggan.create');
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
            'NamaPelanggan' => 'required|string|max:200',
            'Alamat' => 'required',
            'NoTelp' => 'required|max:15',
            'email' => 'required|email|unique:pelanggans',
        ]);
    
        $pelanggan = Pelanggan::create([
            'NamaPelanggan' => $request->NamaPelanggan,
            'Alamat' => $request->Alamat,
            'NoTelp' => $request->NoTelp,
            'email' => $request->email,
        ]);
    
        $data = ['pelanggan' => $pelanggan];
    
        // Mengirim email ke pelanggan
        \Mail::to($pelanggan->email, $pelanggan->NamaPelanggan)
            ->send(new MemberMail($data));
    
        return redirect()->route('pelanggan.index')->with('success', 'Data Berhasil Ditambahkan.');
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
        $pelanggan = Pelanggan::findOrFail($id);

        return view('pelanggan.edit', compact('pelanggan'));
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
            'NamaPelanggan' => 'required|string|max:200',
            'Alamat' => 'required',
            'NoTelp' => 'required|max:15'
        ]);
        
        $pelanggan = Pelanggan::findOrFail($id);
        $pelanggan->update($request->all());
        return redirect()->route('pelanggan.index')->with('success', 'Data Berhasil DiPerbarui');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pelanggan $pelanggan)
    {
        $pelanggan->delete();
        return redirect()->route('pelanggan.index')->with('success', 'Data Berhasil DiHapus');
    }
}
