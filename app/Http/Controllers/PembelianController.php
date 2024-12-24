<?php

namespace App\Http\Controllers;

use App\Models\DetailPembelian;
use App\Models\DetailPenjualan;
use App\Models\Pembelian;
use App\Models\Penjualan;
use App\Models\ProdukJual;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PembelianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Pembelian::paginate(5);
        $dataDetail = DetailPembelian::paginate(5);
        return view('page.pembelian.index')->with([
            'data' => $data,
            'dataDetail' => $dataDetail
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $supplier = Supplier::all();
        $produk = ProdukJual::where('status', 'BELUM')->get();
        $kodePembelian = Pembelian::createCode();
        return view('page.pembelian.create', compact('kodePembelian'))->with([
            'supplier' => $supplier,
            'produk' => $produk,
        ]);
    }


    public function store(Request $request)
    {
        $request->validate([
            'kode_pembelian' => 'required',
            'tgl_pembelian' => 'required|date',
            'id_supplier' => 'required|exists:supplier,id',


        ]);

        $kode_pembelian = $request->input('kode_pembelian');

        $produk = $request->input('produk', []);
        foreach ($produk as $index => $p) {
            $dataDetail = [
                'kode_pembelian' => $kode_pembelian,
                'kode_produk' => $p,
                'qty' => $request->qty[$index],
                'total' => $request->total_harga[$index],
            ];

            DetailPembelian::create($dataDetail);
        }

        $data = [
            'kode_pembelian' => $kode_pembelian,
            'tgl_pembelian' => $request->input('tgl_pembelian'),
            'id_supplier' => $request->input('id_supplier'),
            'total_harga' => $request->input('total_harga'),
            'id_user' => Auth::user()->id,
        ];

        // Update stok produk
        $produkJual = ProdukJual::where('kode_produk', $p)->first();
        if ($produkJual) {
            $produkJual->qty += $request->qty[$index];
            $produkJual->save();
        }

        // dd($request->input('total_harga'));
        Pembelian::create($data);

        return redirect()
            ->route('pembelian.index')
            ->with('message', 'Data sudah ditambahkan');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // $kodePembelian = $request->input('kode_pembelian');

        // $data = [
        //     'tgl_pembelian' => $request->input('tgl_pembelian'),
        //     'id_supplier' => $request->input('id_supplier'),
        //     'total_harga' => $request->input('total_harga'),
        // ];

        // $dataDetail = [
        //     'kode_produk' => $request->input('kode_produk'),
        //     'qty' => $request->input('qty'),
        //     'total' => $request->input('total_harga'),
        // ];

        // $datas = Pembelian::where('kode_pembelian', $kodePembelian)->first();
        // $datas->update($data);

        // $datasDetail = DetailPembelian::where('kode_pembelian', $kodePembelian)->first();
        // $datasDetail->update($dataDetail);

        // // return response()->json([
        // //     'message_update' => "Data Updated!"
        // // ]);

        // return redirect()
        //     ->route('pembelian.index')
        //     ->with('message', 'Data sudah diupdated!');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $pembelian = Pembelian::findOrFail($id);
        $kodePembelian = $pembelian->kode_pembelian;

        // Ambil detail penjualan untuk memproses qty
        $details = DetailPembelian::where('kode_pembelian', $kodePembelian)->get();

        foreach ($details as $detail) {
            // Ambil data produk terkait berdasarkan kode produk
            $produkJual = ProdukJual::where('kode_produk', $detail->kode_produk)->first();

            if ($produkJual) {
                // Kurangi qty produk sesuai dengan jumlah dalam detail pembelian
                $produkJual->qty -= $detail->qty;
                $produkJual->save();
            }
        }

        // Hapus detail pembelian dan data pembelian
        DetailPembelian::where('kode_pembelian', $kodePembelian)->delete();
        $pembelian->delete();

        return back()->with('message_delete', 'Data Transaksi berhasil dihapus.');
    }
}
