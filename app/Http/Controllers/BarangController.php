<?php

namespace App\Http\Controllers;

use App\Models\BarangModel;
use App\Models\KategoriModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class BarangController extends Controller
{
    public function index()
    {
        // Menampilkan Halaman Awal Data Barang
        $breadcrumb = (object)[
            'title' => 'Daftar Barang',
            'list' => ['Home','Barang']
        ];

        $page = (object)[
            'title' => 'Daftar barang yang terdaftar dalam sistem'
        ];

        $activeMenu = 'barang'; //set menu yang sedang aktif

        $kategori = KategoriModel::all(); //ambil data kategori untuk filter kategori

        return view('barang.index',['breadcrumb' => $breadcrumb, 'page' => $page, 'kategori' => $kategori, 'activeMenu' => $activeMenu]);
    }

    // Ambil Data Barang dalam bentuk json untuk datatables
    public function list(Request $request)
    {
        $barangs = BarangModel::select('barang_id', 'kategori_id','barang_kode', 'barang_nama', 'harga_beli','harga_jual', 'image')
            ->with('kategori');

        // Filter data barang berdasarkan kategori kode
        if ($request->kategori_id) {
            $barangs->where('kategori_id', $request->kategori_id);
        }
        
        return DataTables::of($barangs)
            ->addIndexColumn() // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex)
            ->addColumn('aksi', function ($barang) { // menambahkan kolom aksi
                $btn = '<a href="'.url('/barang/' . $barang->barang_id).'" class="btn btn-info btn-sm">Detail</a> ';
                $btn .= '<a href="'.url('/barang/' . $barang->barang_id . '/edit').'" class="btn btn-warning btn-sm">Edit</a> ';
                $btn .= '<form class="d-inline-block" method="POST" action="'. url('/barang/'.$barang->barang_id).'">' . csrf_field() . method_field('DELETE') . '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakin menghapus data ini?\');">Hapus</button></form>';
            return $btn;
        })
        ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html
        ->make(true);
    }

    // Menampilkan halaman form tambah barang
    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Tambah Barang',
            'list'  => ['Home', 'Barang', 'Tambah']
        ];

        $page = (object) [
            'title' => 'Tambah barang baru'
        ];

        $kategori = KategoriModel::all(); // ambil kategori barang untuk ditampilkan di form
        $activeMenu = 'barang'; // set menu yang sedang aktif

        return view('barang.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'kategori' => $kategori, 'activeMenu' => $activeMenu]);
    }

    // Menyimpan data barang baru
    public function store(Request $request)
    {
        $request->validate([
            'barang_kode'   => 'required|string|max:10|min:2',
            'barang_nama'   => 'required|string|max:100|',
            'kategori_id'   => 'required|integer',
            'harga_beli'    => 'required|integer',
            'harga_jual'    => 'required|integer',
            'image'         => 'required|file|image|max:5000'
        ]);
    
        $extfile = $request->image->getClientOriginalExtension();
        $namaFile = $request->barang_kode . '_' . $request->barang_nama . '.' . $extfile;
        $path = $request->image->move('gambar/barang', $namaFile);
        $path = str_replace("\\", "//", $path);
        $pathBaru = asset('gambar/barang/' . $namaFile);

        BarangModel::create([
            'barang_kode'   => $request->barang_kode,
            'barang_nama'   => $request->barang_nama,
            'kategori_id'   => $request->kategori_id,
            'harga_beli'    => $request->harga_beli,
            'harga_jual'    => $request->harga_jual,
            'image'         => $pathBaru
        ]);

        return redirect('/barang')->with('success', 'Data barang berhasil disimpan');
    }

    // Menampilkan detail barang
    public function show(string $id)
    {
        $barang = BarangModel::with('kategori')->find($id);

        $breadcrumb = (object) [
            'title' => 'Detail Barang',
            'list'  => ['Home', 'Barang', 'Detail']
        ];

        $page = (object) [
            'title' => 'Detail barang'
        ];

        $activeMenu = 'barang'; // set menu yang sedang aktif

        return view('barang.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'barang' => $barang, 'activeMenu' => $activeMenu]);
    }

    // Menampilkan halaman form edit barang
    public function edit(string $id)
    {
        $barang = BarangModel::find($id);
        $kategori = KategoriModel::all();

        $breadcrumb = (object) [
            'title' => 'Edit Barang',
            'list'  => ['Home', 'Barang', 'Edit']
        ];

        $page = (object) [
            'title' => 'Edit barang'
        ];

        $activeMenu = 'barang'; // set menu yang sedang aktif

        return view('barang.edit', ['breadcrumb' => $breadcrumb, 'page' => $page, 'barang' => $barang, 'kategori' => $kategori, 'activeMenu' => $activeMenu]);
    }

    // Menyimpan perubahan data barang
    public function update(Request $request, string $id)
    {
        $request->validate([
            'barang_kode'   => 'required|string|max:10|min:2',
            'barang_nama'   => 'required|string|max:100|',
            'kategori_id'   => 'required|integer',
            'harga_beli'    => 'required|integer',
            'harga_jual'    => 'required|integer',
            'image'         => 'nullable|image|max:5000'
        ]);

        $barang = BarangModel::find($id);

        if ($request->image) {
            $extfile = $request->image->getClientOriginalExtension();
            $namaFile = $request->barang_kode . '_' . $request->barang_nama . '.' . $extfile;
            $path = $request->image->move('gambar/barang', $namaFile);
            $path = str_replace("\\", "//", $path);
            $pathBaru = asset('gambar/barang/' . $namaFile);    
        } else {
            $pathBaru = $barang->image;
        }

        $barang->update([
            'barang_kode'   => $request->barang_kode,
            'barang_nama'   => $request->barang_nama,
            'kategori_id'   => $request->kategori_id,
            'harga_beli'    => $request->harga_beli,
            'harga_jual'    => $request->harga_jual,
            'image'         => $pathBaru
        ]);

        return redirect('/barang')->with('success', 'Data barang berhasil diubah');
    }

    // Menghapus data barang
    public function destroy(string $id)
    {
        $check = BarangModel::find($id); 
        if (!$check) {      // Untuk mengecek apakah data barang dengan id yang dimaksud ada atau tidak
            return redirect('/barang')->with('error', 'Data barang tidak ditemukan');
        }

        try {
            BarangModel::destroy($id); // Hapus data barang
            return redirect('/barang')->with('success', 'Data barang berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            // Jika terjadi error ketika menghapus data, redirect kembali ke halaman dengan membawa pesan error
            return redirect('/barang')->with('error', 'Data barang gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }
}
