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
        $data = Pembelian::all();
        $dataDetail = DetailPenjualan::all();
        return response()->json([
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
        $data = [
            'kode_pembelian' => $request->input('kode_pembelian'),
            'tgl_pembelian' => $request->input('tgl_pembelian'),
            'id_supplier' => $request->input('id_supplier'),
            'total_bayar' => $request->input('total_bayar'),
        ];

        $dataDetail = [
            'kode_pembelian' => $request->input('kode_pembelian'),
            'kode_produk' => $request->input('kode_produk'),
            'qty' => $request->input('qty'),
            'total' => $request->input('total'),
        ];

        Pembelian::create($data);
        DetailPembelian::create($dataDetail);

        return response()->json([
            'message_update' => "Data Added!"
        ]);
    }
    /**
     * Store a newly created resource in storage.
     */
    // public function store(Request $request)
    // {
    //     $kode_pembelian = $request->input('kode_pembelian'); // Mendapatkan kode_pembelian

    //     $produk = $request->input('produk', []);
    //     foreach ($produk as $index => $p) {
    //         // Pastikan nilai kode_pembelian ada di data detail
    //         $dataDetail = [
    //             'kode_pembelian' => $kode_pembelian,
    //             'kode_produk' => $p,
    //             'qty' => $request->qty[$index],
    //             'total' => $request->total_harga[$index],
    //         ];

    //         // Simpan data ke dalam tabel detail_pembelian
    //         DetailPembelian::create($dataDetail);
    //     }

    //     $data = [
    //         'kode_pembelian' => $kode_pembelian,
    //         'tgl_pembelian' => $request->input('tgl_pembelian'),
    //         'id_supplier' => $request->input('id_supplier'),
    //         'id_user' => Auth::user()->id,
    //     ];


    //     Pembelian::create($data);
    //     DetailPembelian::create($dataDetail);

    //     return response()->json([
    //         'message_update' => "Data-Added!"
    //     ]);

    //     // return redirect()
    //     //     ->route('pembelian.index')
    //     //     ->with('message', 'Data sudah ditambahkan');
    // }

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
        $kodePembelian = $request->input('kode_pembelian');

        $data = [
            'tgl_pembelian' => $request->input('tgl_pembelian'),
            'id_supplier' => $request->input('id_supplier'),
            'total_bayar' => $request->input('total_bayar'),
        ];

        $dataDetail = [
            'kode_produk' => $request->input('kode_produk'),
            'qty' => $request->input('qty'),
            'total' => $request->input('total'),
        ];

        $datas = Pembelian::where('kode_pembelian', $kodePembelian)->first();
        $datas->update($data);

        $datasDetail = DetailPembelian::where('kode_pembelian', $kodePembelian)->first();
        $datasDetail->update($dataDetail);

        return response()->json([
            'message_update' => "Data Updated!"
        ]);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $data = Pembelian::findOrFail($id);
            $kodePembelian = $data->kode_pembelian;

            $data = Pembelian::where('kode_pembelian', $kodePembelian)->first();
            $dataDetail = DetailPembelian::where('kode_pembelian', $kodePembelian)->first();

            if ($data) {
                $data->delete();
            }

            if ($dataDetail) {
                $dataDetail->delete();
            }

            return response()->json([
                'message_delete' => "Data Deleted!"
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to delete data.',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
