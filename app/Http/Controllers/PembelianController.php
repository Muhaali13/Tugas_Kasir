<?php

namespace App\Http\Controllers;

use App\Models\DetailPembelian;
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
        return view('page.pembelian.index')->with([
            'data' => $data,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $supplier = Supplier::all();
        $produk = ProdukJual::where('status','BELUM')->get();
        $kodePembelian = Pembelian::createCode();
        return view('page.pembelian.create', compact('kodePembelian'))->with([
            'supplier' => $supplier,
            'produk' => $produk,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
    $kode_pembelian = $request->input('kode_pembelian'); // Mendapatkan kode_pembelian

    $produk = $request->input('produk', []);
    foreach ($produk as $index => $p) {
        // Pastikan nilai kode_pembelian ada di data detail
        $dataDetail = [
            'kode_pembelian' => $kode_pembelian,
            'kode_produk' => $p,
            'qty' => $request->qty[$index],
            'total' => $request->total_harga[$index],
        ];

        // Simpan data ke dalam tabel detail_pembelian
        DetailPembelian::create($dataDetail);
    }

    $data = [
        'kode_pembelian' => $kode_pembelian,
        'tgl_pembelian' => $request->input('tgl_pembelian'),
        'id_supplier' => $request->input('id_supplier'),
        'id_user' => Auth::user()->id,
    ];

  
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
        //
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

        // foreach ($details as $detail) {
        //     $produkJual = ProdukJual::where('kode_produk', $detail->kode_produk)->first();
        //     if ($produkJual) {
        //         // Tambahkan kembali qty yang dihapus
        //         $produkJual->qty += $detail->qty;
        //         $produkJual->save();
        //     }
        // }

        // Hapus detail penjualan dan data penjualan
        DetailPembelian::where('kode_pembelian', $kodePembelian)->delete();
        $pembelian->delete();

        return back()->with('message_delete', 'Data Transaksi berhasil dihapus.');
    
    }
}
