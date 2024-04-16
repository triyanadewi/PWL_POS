<?php

namespace App\Http\Controllers;

use App\Models\BarangModel;
use App\Models\PenjualanDetailModel;
use App\Models\PenjualanModel;
use App\Models\StokModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PenjualanController extends Controller
{
    public function index()
    {
        // Menampilkan Halaman Awal Penjualan
        $breadcrumb = (object)[
            'title' => 'Daftar Transaksi Penjualan',
            'list' => ['Home','Penjualan']
        ];

        $page = (object)[
            'title' => 'Daftar transaksi penjualan yang terdaftar dalam sistem'
        ];

        $activeMenu = 'penjualan'; //set menu yang sedang aktif

        $user = UserModel::all(); //ambil data barang untuk filter user

        return view('penjualan.index',['breadcrumb' => $breadcrumb, 'page' => $page, 'user' => $user, 'activeMenu' => $activeMenu]);
    }

    // Ambil data stok dalam bentuk json untuk datatables
    public function list(Request $request)
    {
        $penjualans = PenjualanModel::select('penjualan_id', 'penjualan_kode', 'penjualan_tanggal', 'user_id', 'pembeli')
            ->with('detail', 'user');

        // Filter data penjualan berdasarkan barang_id
        if ($request->user_id) {
            $penjualans->where('user_id', $request->user_id);
        }
        
        return DataTables::of($penjualans)
            ->addIndexColumn() // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex)
            ->addColumn('aksi', function ($penjualan) { // menambahkan kolom aksi
                $btn = '<a href="'.url('/penjualan/' . $penjualan->penjualan_id).'" class="btn btn-info btn-sm">Detail</a> ';
                $btn .= '<a href="'.url('/penjualan/' . $penjualan->penjualan_id . '/edit').'" class="btn btn-warning btn-sm">Edit</a> ';
                $btn .= '<form class="d-inline-block" method="POST" action="'. url('/penjualan/'.$penjualan->penjualan_id).'">' . csrf_field() . method_field('DELETE') . '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakin menghapus data ini?\');">Hapus</button></form>';
            return $btn;
        })
        ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html
        ->make(true);
    }

    // Menampilkan halaman form tambah penjualan
    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Tambah Transaksi Penjualan',
            'list'  => ['Home', 'Penjualan', 'Tambah']
        ];

        $page = (object) [
            'title' => 'Tambah transaksi penjualan baru'
        ];

        $user = UserModel::all(); // ambil data barang untuk ditampilkan di form
        $barang = BarangModel::with('kategori', 'stok')->get();
        $counter = (PenjualanModel::selectRaw("CAST(RIGHT(penjualan_kode, 3) AS UNSIGNED) AS counter")->orderBy('penjualan_id', 'desc')->value('counter')) + 1;
        $penjualan_kode = 'PNJ' . sprintf("%03d", $counter);        
        $activeMenu = 'penjualan'; // set menu yang sedang aktif

        return view('penjualan.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'user' => $user, 'barang' => $barang, 'penjualan_kode' => $penjualan_kode, 'activeMenu' => $activeMenu]);
    }

    // Menyimpan data penjualan baru
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer',
            'penjualan_kode' => 'required|string|min:3|unique:t_penjualan,penjualan_kode',
            'pembeli' => 'required|string|max:100',
            'barang_id.*' => 'required|integer',
            'jumlah.*' => 'required|integer',
            'harga.*' => 'required|integer'
        ]);

        $penjualan = PenjualanModel::create([
            'user_id' => $request->user_id,
            'penjualan_kode' => $request->penjualan_kode,
            'pembeli' => $request->pembeli,
            'penjualan_tanggal' => now()
        ]);

        $barang_ids = $request->barang_id;
        $jumlahs = $request->jumlah;
        $hargas = $request->harga;

        foreach ($barang_ids as $key => $barang_id) {
            PenjualanDetailModel::create([
                'penjualan_id' => $penjualan->penjualan_id,
                'barang_id' => $barang_id,
                'jumlah' => $jumlahs[$key],
                'harga' => $hargas[$key]
            ]);

            $stok = (StokModel::where('barang_id', $barang_id)->value('stok_jumlah')) - $jumlahs[$key];
            $date = date('Y-m-d');
            StokModel::where('barang_id', $barang_id)->update(['stok_jumlah' => $stok, 'stok_tanggal' => $date, 'user_id' => $request->user_id]);
        }

        return redirect('/penjualan')->with('success', 'Data transaksi penjualan berhasil disimpan');
    }

    // Menampilkan detail penjualan
    public function show(string $id)
    {
        $penjualan = PenjualanModel::find($id);
        $detail = PenjualanDetailModel::where('penjualan_id',$id)->get();

        $breadcrumb = (object) [
            'title' => 'Detail Transaksi Penjualan',
            'list'  => ['Home', 'Penjualan', 'Detail']
        ];

        $page = (object) [
            'title' => 'Detail transaksi penjualan'
        ];

        $activeMenu = 'penjualan'; // set menu yang sedang aktif

        $total = 0;
        foreach ($detail as $dt) {
            $total += $dt->jumlah * $dt->harga;
        }

        return view('penjualan.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'penjualan' => $penjualan, 'detail' => $detail, 'total' => $total, 'activeMenu' => $activeMenu]);
    }

    // Menampilkan halaman form edit penjualan
    public function edit(string $id)
    {
        $penjualan = PenjualanModel::with('user')->with('detail')->find($id);

        $breadcrumb = (object) [
            'title' => 'Edit Penjualan',
            'list' => ['Home', 'Penjualan', 'Edit']
        ];

        $page = (object) [
            'title' => 'Edit Transaksi Penjualan'
        ];

        $activeMenu = 'penjualan'; //set menu yang aktif

        $barang = BarangModel::all();
        $user = UserModel::all();
        
        return view('penjualan.edit', ['breadcrumb' => $breadcrumb, 'page' => $page, 'penjualan' => $penjualan, 'barang' => $barang, 'user' => $user, 'activeMenu' => $activeMenu]);
    }

    // Menyimpan perubahan data penjualan
    public function update(Request $request, string $id)
    {
        $request->validate([
            'user_id' => 'required',
            'pembeli' => 'required|string|max:100',
        ]);

        $penjualan = PenjualanModel::find($id);
        $penjualan->user_id = $request->user_id;
        $penjualan->pembeli = $request->pembeli;
        $penjualan->save();

        $penjualan->detail()->delete();

        for ($i=0; $i < count($request->barang_id); $i++) {
            $detail = new PenjualanDetailModel();
            $detail->penjualan_id = $penjualan->penjualan_id;
            $detail->barang_id = $request->barang_id[$i];
            $detail->jumlah = $request->jumlah[$i];

            $barang = BarangModel::find($request->barang_id[$i]);
            $detail->harga = $barang->harga_jual;

            $detail->save();
            $barang->save();
        }

        return redirect('/penjualan')->with('success', 'Data transaksi berhasil diubah');    }

    // Menghapus data penjualan
    public function destroy(string $id)
    {
        $check = PenjualanModel::find($id); 
        if (!$check) {      // Untuk mengecek apakah data penjualan dengan id yang dimaksud ada atau tidak
            return redirect('/penjualan')->with('error', 'Data transaksi penjualan tidak ditemukan');
        }

        try {
            PenjualanModel::destroy($id); // Hapus data penjualan
            return redirect('/penjualan')->with('success', 'Data transaksi penjualan berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            // Jika terjadi error ketika menghapus data, redirect kembali ke halaman dengan membawa pesan error
            return redirect('/penjualan')->with('error', 'Data transaksi penjualan gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }
}
