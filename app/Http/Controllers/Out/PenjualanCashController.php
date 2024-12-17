<?php

namespace App\Http\Controllers\Out;

use App\Http\Controllers\Controller;
use App\Models\API\Barang;
use App\Models\DetailPenjualanCash;
use App\Models\Konsumen;
use App\Models\PenjualanCash;
use App\Traits\Buttons;
use App\Traits\Formatting;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PenjualanCashController extends Controller
{
    use Buttons, Formatting;

    public function index()
    {
        $data = Barang::get();
        $konsumens = Konsumen::all();
        return view('out.penjualan-cash.index', compact('data', 'konsumens'));
    }

    public function store(Request $request)
    {
        $konsumen = Konsumen::where('nama',  $request->nama_konsumen)->first();

        if (!$konsumen) {
            return redirect()->back()->with('delete', 'Error, Nama Konsumen Tidak Ada Didatabase!');
        }

        // STORE PENJUALAN CASH
        $new_data = PenjualanCash::create([
            'toko'          => 'TOKO WINONG',
            'nama_konsumen' => $request->nama_konsumen,
            'total'         => $request->total,
            'bayar'         => $request->bayar,
            'kembalian'     => $request->kembalian
        ]);

        // STORE DETAIL PENJUALAN CASH
        $detail_data = $request->data;

        foreach ($detail_data as $item => $value) {
            $new_detail = DetailPenjualanCash::create([
                'penjualan_cash_id'         => $new_data->id,
                'nama_barang_dan_no_lot'    => $value['nama_barang_dan_no_lot'],
                'harga'                     => $value['harga'],
                'qty'                       => $value['qty'],
                'diskon'                    => $value['diskon'],
                'sub_total'                 => $value['subtotal']
            ]);
        }

        return redirect()->route('print.penjualan.cash')->with(compact('new_data'));
    }

    public function report()
    {
        return view('report.r-penjualan-cash.index');
    }

    public function show()
    {
        if (request()->ajax()) {
            $data = PenjualanCash::query();
            return DataTables::of($data)
                ->editColumn('total', function ($params) {
                    return $this->_Money($params->total);
                })
                ->editColumn('bayar', function ($params) {
                    return $this->_Money($params->bayar);
                })
                ->editColumn('kembalian', function ($params) {
                    return $this->_Money($params->kembalian);
                })
                ->editColumn('created_at', function ($params) {
                    return Carbon::parse($params->created_at)->format('j F Y');
                })
                ->addColumn('action', function ($params) {
                    return $this->_CheckRole($params, 'penjualan-cash');
                })
                ->rawColumns(['action'])
                ->make();
        }
    }

    public function table($id)
    {
        $data = DetailPenjualanCash::where('penjualan_cash_id', $id)->get();
        return response()->json([
            'data' => $data,
            'message' => 'Success'
        ]);
    }

    public function edit($id)
    {
        $head  = PenjualanCash::find($id);
        $data   = DetailPenjualanCash::where('penjualan_cash_id', $id)->get();
        $barang = Barang::select('nama')->get();
        return view('report.r-penjualan-cash.edit', compact('head','data', 'barang'));
    }

    public function update($id, Request $request)
    {
        $data = DetailPenjualanCash::find($id);
        $data->update([
            'nama_barang_dan_no_lot' => $request->nama_barang_dan_no_lot,
            'harga'                  => $request->harga,
            'qty'                    => $request->qty,
            'diskon'                 => $request->diskon,
            'sub_total'              => ($request->harga * $request->qty)
        ]);
        $head = PenjualanCash::find($data->penjualan_cash_id);
        $total_penjualan = $head->detailPenjualanCash->sum('sub_total') - $head->detailPenjualanCash->sum('diskon');
        $head->update([ 'total' => $total_penjualan,
                        'bayar' => $total_penjualan]);
        return redirect()->back();
    }

    public function delete($id)
    {
        $data = PenjualanCash::find($id);
        DetailPenjualanCash::where('penjualan_cash_id', $data->id)->delete();
        $data->delete();
        return response()->json([
            'data' => $data,
            'message' => 'Success'
        ]);
    }

    public function updateInduk(Request $request, $id)
    {
        $data = PenjualanCash::find($id);
        $data->update([
            'nama_konsumen' => $request->nama_konsumen,
            'created_at'    => $request->created_at,
        ]);

        // UPDATE DETAIL PENJUALAN
        $dataDetail = DetailPenjualanCash::where('penjualan_cash_id', $id)->get();
        foreach ($dataDetail as $item) {
            $item->update([
                'created_at' => $request->created_at,
            ]);
        }

        return redirect()->back()->with('success', 'Data berhasil diubah!');
    }
}
