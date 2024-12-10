<?php

namespace App\Http\Controllers;

use App\Models\Pengaduan;
use App\Models\Tanggapan;
use Illuminate\Http\Request;

class TanggapanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate ($request, [
        'tgl_tanggapan' => 'required',
        'tanggapan' => 'required',
        'status' => 'required',
        ]);

        Tanggapan::create([
            'pengaduan_id' => $request->get('pengaduan_id'),
            'tgl_tanggapan'=>$request->get('tgl_tanggapan'),
            'tanggapan'=>$request->get('tanggapan'),
            'user_id'=>$request->get('user_id'),
        ]);

        Pengaduan::where ('id', $request->pengaduan_id)->update([
            'status' => $request->get('status'),
        ]);
        
        return redirect()->back()->with('message', 'Tanggapan berhasil dilaporkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $pengaduan = Pengaduan::find($id);
        return view('tanggapan.create', compact('pengaduan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tanggapan $tanggapan)
    {
        return view('tanggapan.edit', compact('tanggapan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tanggapan $tanggapan)
    {
        $this->validate($request,[
            'tgl_tanggapan' => 'required',
            'tanggapan' => 'required',
            'status' => 'required',
        ]);

        Pengaduan::where ('id', $request->pengaduan_id)->update([
            'status' => $request->get('status'),
        ]);

        $tanggapan->tgl_tanggapan = $request->get('tgl_tanggapan');
        $tanggapan->tanggapan = $request->get('tanggapan');
        $tanggapan->save();

        return redirect()->back()->with('message', 'Tanggapan berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function pengaduan()
    {
        return $this->belongsTo(Pengaduan::class);
    }
}
