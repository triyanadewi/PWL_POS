<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PenjualanModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TransaksiController extends Controller
{
    public function __invoke(Request $request)
    {
        // Set validation
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'pembeli' => 'required',
            'penjualan_kode' => 'required',
            'penjualan_tanggal' => 'required|date',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048' 
        ]);

        // If validations fails 
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Create transaction
        $user = PenjualanModel::create([
            'user_id' => $request->user_id,
            'pembeli' => $request->pembeli,
            'penjualan_kode' => $request->penjualan_kode,
            'penjualan_tanggal' => $request->penjualan_tanggal,
            'image' => $request->image->hashName(),
        ]);

        // Return response JSON transaction is created
        if ($user) {
            return response()->json([
                'success' => true,
                'transaksi' => $user
            ], 201);
        }

        // Return JSON process insert failed 
        return response()->json([
            'success' => false
        ], 409);
    }
    

    public function show($penjualan)
    {
        $transaksi = PenjualanModel::find($penjualan);

        if ($transaksi) {
            return response()->json([
                'success' => true,
                'transaksi' => $transaksi,
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'Transaksi not found.',
        ], 404);
    }
}
