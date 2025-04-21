<?php

namespace App\Http\Controllers;
use App\Pemasok;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

class PemasokController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $query = Pemasok::query();

        if ($search) { 
            $query->where('Nama', 'LIKE', '%' . $search . '%');
        }
        $query->orderBy('PemasokID', 'desc');
        $pemasoks = $query->paginate(10);

        return view('pemasok.index', [
            'pemasoks' => $pemasoks,
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
        return view('pemasok.create');
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
            'Nama' => 'required|unique:pemasoks,Nama',
            'NoTelp' => 'required|numeric|unique:pemasoks,NoTelp',
            'Alamat' => 'required|string|max:100',
            'Email' => 'required|email|unique:pemasoks,Email'
        ]);

        Pemasok::create($request->all());
        return redirect()->route('pemasok.index')->with('success', 'Data Berhasil Ditambahkan.');
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
       $pemasok = Pemasok::findOrFail($id);
        return view('pemasok.edit', compact('pemasok'));
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
            'Nama' => [
                'required',
                Rule::unique('pemasoks', 'Nama')->ignore($id, 'PemasokID'),
            ],
            'NoTelp' => [
                'required', 'numeric',
                Rule::unique('pemasoks', 'NoTelp')->ignore($id, 'PemasokID'),
            ],
            'Alamat' => 'required|string|max:100',
            'Email' => [
                'required',
                'email',
                Rule::unique('pemasoks', 'Email')->ignore($id, 'PemasokID'),
            ],
        ]);       

        $pemasok = Pemasok::findOrFail($id);
        $pemasok->update($request->all());
        return redirect()->route('pemasok.index')->with('success', 'Data Berhasil Diperbarui.');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pemasok $pemasok)
    {
        $pemasok->delete();
        return redirect()->route('pemasok.index')->with('success', 'Data Berhasil Dihapus.');
    }
}
