<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BarangModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BarangController extends Controller
{
    public function index()
    {
        return BarangModel::all();
    }

    public function __invoke(Request $request)
    {
        // Set validation
        $validator = Validator::make($request->all(), [
            'barang_kode' => 'required',
            'barang_nama' => 'required',
            'kategori_id' => 'required',
            'harga_beli' => 'required|integer',
            'harga_jual' => 'required|integer',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // If validations fails 
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Create barang
        $barang = BarangModel::create([
            'barang_kode' => $request->barang_kode,
            'barang_nama' => $request->barang_nama,
            'kategori_id' => $request->kategori_id,
            'harga_beli' => $request->harga_beli,
            'harga_jual' => $request->harga_jual,
            'image' => $request->image->hashName(),
        ]);

        // Return response JSON barang is created
        if ($barang) {
            return response()->json([
                'success' => true,
                'barang' => $barang,
            ], 201);
        }

        // return JSON process insert failed 
        return response()->json([
            'success' => false,
        ], 409);
    }

    public function show($barang)
    {
        $item = BarangModel::find($barang);

        if ($item) {
            return response()->json([
                'success' => true,
                'barang' => $item,
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'Item not found.',
        ], 404);
    }

    public function update(Request $request, BarangModel $barang)
    {
        $barang->update($request->all());
        return response()->json($barang, 200);
    }

    public function destroy(BarangModel $barang)
    {
        $barang->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data terhapus'
        ]);
    }
}
