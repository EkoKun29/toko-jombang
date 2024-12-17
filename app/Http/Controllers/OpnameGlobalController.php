<?php

namespace App\Http\Controllers;

use App\Models\API\Barang;
use App\Models\Audit;
use App\Models\OpnameGlobal;
use Illuminate\Http\Request;

class OpnameGlobalController extends Controller
{
    public function index(){
   
   
        $item = collect([
            ['penyetok' => 'PAK KIS'],
            ['penyetok' => 'SULISTYONO'],
            ['penyetok' => 'AZIZ'],
            ['penyetok' => 'PAK RIDWAN'],
        ]);
        $barang = Barang::all();
        $opname_global = OpnameGlobal::all();
        return view('stokglobal.index', compact('opname_global', 'barang', 'item'));
    }

    public function create(Request $request){

        $nama = $request->nama_barang;
        $isi_perdus =Barang::where('nama',$nama)->first();
        $total = $request->duz * $isi_perdus->isi + $request->qty;

        $opname=OpnameGlobal::where('nama_barang',$nama)->first();

        if($opname !=null){
            $sumTotal = $opname->
            total + $total;
            $opname->total = $sumTotal;
            $opname->save();

            $data = new Audit;
            $data->id_opname_global=$opname->id;
            $data->nama_barang = $request->nama_barang;
            $data->duz= $request->duz;
            $data->qty= $request->qty;
            $data->penyetok = $request->penyetok;
            $nama = $request->nama_barang;
            $isi_perdus =Barang::where('nama',$nama)->first();
            $data->update([
                'total' => $data->duz * $isi_perdus->isi + $data->qty
                
            ]);
            $data->total=$data->duz * $isi_perdus->isi + $data->qty;

            $data->kategori=$request->kategori;
            $data->save();
            return redirect()->route('audit1.index')->with('success', 'Data Berhasil Ditambahkan');

        }else{
            $global = new OpnameGlobal;
            $global->nama_barang = $request->nama_barang;
            $global->total = $total;
            $global->audit = $request->kategori;
            $global->save();

            $data = new Audit;
            $data->id_opname_global=$global->id;
            $data->nama_barang = $request->nama_barang;
            $data->duz= $request->duz;
            $data->qty= $request->qty;
            $data->penyetok = $request->penyetok;
            $nama = $request->nama_barang;
            $isi_perdus =Barang::where('nama',$nama)->first();
            $data->update([
                'total' => $data->duz * $isi_perdus->isi + $data->qty
                
            ]);
            $data->total=$data->duz * $isi_perdus->isi + $data->qty;
            $data->kategori=$request->kategori;
            $data->save();
            return redirect()->route('audit1.index')->with('success', 'Data Berhasil Ditambahkan');
        }
        
    }
}
