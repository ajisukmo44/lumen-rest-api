<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Produk;

class ProdukController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }



    // get
    public function index()
    {

        $produk = Produk::all();

        return response()->json($produk);
    }

    public function show($id)
    {

        $produk = Produk::find($id);

        return response()->json($produk);
    }


    // post
    public function create(Request $request)
    {
        $this->validate($request, [
            'nama' => 'required|string|unique',
            'harga' => 'required|integer',
            'kondisi' => 'required|in:baru,lama',
            'deskripsi' => 'required|string',
        ]);

        $data = $request->all();
        $produk = Produk::create($data);

        return response()->json($produk);
    }

    public function update(Request $request, $id)
    {

        $produk = Produk::find($id);

        if (!$produk) {
            return response()->json(["Message" => "Data Produk Tidak Di Temukan"], 404);
        }

        $this->validate($request, [
            'nama' => 'string',
            'harga' => 'integer',
            'kondisi' => 'in:baru,lama',
            'deskripsi' => 'string',
        ]);

        $data = $request->all();
        $produk->fill($data);

        $produk->save();

        return response()->json($produk);
    }


    public function destroy($id)
    {
        $produk = Produk::find($id);
        if (!$produk) {
            return response()->json(["Message" => "Data Produk Tidak Di Temukan"], 404);
        }
        $produk->delete();
        return response()->json(["Message" => "Data berhasil dihapus"]);
    }
}
