<?php

namespace App\Http\Controllers;
use App\Pelanggan;
// use App\Notifications\CustomerNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\MemberMail;
use App\Models\Penjualan; 
use App\Models\Province;
use App\Models\District;
use App\Models\Regency; 
use App\Models\Village;   
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
        $provinces = Province::all();  
        $regencies = Regency::all(); 
        $districts = District::all();
        $villages = Village::all(); 
        return view('pelanggan.create', compact('provinces', 'regencies', 'districts', 'villages' ));
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
            'province_id' => 'required|exists:indoregion_provinces,id',
            'regency_id' => 'required|exists:indoregion_regencies,id',
            'district_id' => 'required|exists:indoregion_districts,id',
            'village_id' => 'required|exists:indoregion_villages,id',
        ]);
    
        $pelanggan = Pelanggan::create([
            'NamaPelanggan' => $request->NamaPelanggan,
            'Alamat' => $request->Alamat,
            'NoTelp' => $request->NoTelp,
            'email' => $request->email,
            'province_id' => $request->province_id,
            'regency_id' => $request->regency_id,
            'district_id' => $request->district_id,
            'village_id' => $request->village_id,
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
        $provinces = Province::all();  
        $regencies = Regency::all(); 
        $districts = District::all();
        $villages = Village::all(); 
        return view('pelanggan.edit', compact('pelanggan','provinces', 'regencies', 'districts', 'villages'));
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
            'NoTelp' => 'required|max:15',
            'province_id' => 'required|exists:indoregion_provinces,id',
            'regency_id' => 'required|exists:indoregion_regencies,id',
            'district_id' => 'required|exists:indoregion_districts,id',
            'village_id' => 'required|exists:indoregion_villages,id',
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
        Penjualan::where('PelangganID', $pelanggan->id)->update(['PelangganID' => null]);

        // Hapus pelanggan
       
        $pelanggan->delete();
    
        return redirect()->route('pelanggan.index')->with('success', 'Data Berhasil DiHapus');
    }
    


    public function getRegencies($province_id)
    {
        $regencies = Regency::where('province_id', $province_id)->get();
        return response()->json($regencies);
    }

    // Mengambil data kecamatan berdasarkan kabupaten
    public function getDistricts($regency_id)
    {
        $districts = District::where('regency_id', $regency_id)->get();
        return response()->json($districts);
    }

    // Mengambil data desa berdasarkan kecamatan
    public function getVillages($district_id)
    {
        $villages = Village::where('district_id', $district_id)->get();
        return response()->json($villages);
    }
}
