<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pengaduan;
use App\Models\Tanggapan;
use PDF;

class PengaduanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::user()->role == 0){
            $pengaduans = Pengaduan::where('user_id', Auth::user()->id)->latest()->get();
        } else {
            $pengaduans = Pengaduan::latest()->get();
        }
        return view('pengaduan.index', compact('pengaduans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pengaduan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
        'tgl_pengaduan' => 'required',
        'user_id' => 'required',
        'isi_laporan' => 'required',
        'foto'=>'required',
        ]);

        $foto= $request->file ('foto');
        $name = time().'.'.$foto->getClientOriginalExtension();
        $destinationPath = public_path('/foto');
        $foto->move ($destinationPath, $name);
        
        Pengaduan::create([
            'tgl_pengaduan'=>$request->get('tgl_pengaduan'),
            'user_id' => $request->get('user_id'),
            'isi_laporan'=>$request->get('isi_laporan'),
            'foto'=>$name
        ]);

        return redirect()->back()->with('message', 'Pengaduan berhasil dilaporkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Pengaduan $pengaduan)
    {
        return view('pengaduan.detail', compact('pengaduan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $pengaduan = Pengaduan::findOrFail($id);
        return view('pengaduan.edit', compact('pengaduan'));
    }

    /**
     * Update the specified resource in storage.
     */

     public function update (Request $request, Pengaduan $pengaduan)
     {
     $this->validate ($request, [
        'tgl_pengaduan' => 'required',
        'user_id' => 'required',
        'isi_laporan' => 'required',
        'foto'=>'',
     ]);

     $name = $pengaduan->foto;
     if ($request->hasFile('foto')) {
     $foto= $request->file ('foto');
     $name = time().'.'.$foto->getClientOriginalExtension(); 
     $destinationPath = public_path('/foto');
     $foto->move ($destinationPath, $name);
     }

     $pengaduan->tgl_pengaduan = $request->get('tgl_pengaduan');
     $pengaduan->user_id = $request->get('user_id');
     $pengaduan->isi_laporan = $request->get('isi_laporan');
     $pengaduan->foto = $name;
     $pengaduan->save();
     return redirect()->back()->with('message', 'Pengaduan berhasil diupdate');
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $pengaduan = Pengaduan::find($id);
        $pengaduan->delete();

        return redirect()->route('pengaduan.index')->with('message', 'Pengaduan berhasil dihapus!');
    }

    public function tanggapan()
    {
        return $this->hasOne(Tanggapan::class);
    }

    public function laporan() 
    {
        $pengaduans = Pengaduan::latest()->get();
        return view('pengaduan.laporan', compact('pengaduans'));
    }

    public function pdf()
    {
        $pengaduans = Pengaduan::latest()->get();
        $pdf = PDF::loadview('pengaduan.pdf', compact('pengaduans'));
        return $pdf->download('laporan.pdf');
    }
}
