<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MetodeBayar;
class MetodeBayarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request )
    {
        $search = $request->input('search'); 
        $query = MetodeBayar::query();

        if ($search) { 
            $query->where('NamaMetode', 'LIKE', '%' . $search . '%');
        }
        $query->orderBy('MetodeID', 'desc');
        $metodebayars = $query->paginate(10);
        
        return view('metodebayar.index', [
        'metodebayars' => $metodebayars, 
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
        return view('metodebayar.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'NamaMetode' => 'required|string|max:20'
        ]);

        MetodeBayar::create($request->all());
        return redirect()->route('metodebayar.index')->with('success', 'Data Berhasil Disimpan.');
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
        $metodebayar = MetodeBayar::findOrFail($id);
        return view('metodebayar.edit', compact('metodebayar'));
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
        $this->validate($request, [
            'NamaMetode' => 'required|string|max:20'
        ]);

        $metodebayar = MetodeBayar::findOrFail($id);
        $metodebayar->update($request->all());
        return redirect()->route('metodebayar.index')->with('success', 'Data Berhasil Diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(MetodeBayar $metodebayar)
    {
        $metodebayar->delete();
        return redirect()->route('metodebayar.index')->with('success', 'Data Berhasil Dihapus.');
    }
}
