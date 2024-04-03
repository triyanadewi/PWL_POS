<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\DataTables\LevelDataTable;
use App\Models\LevelModel;

class LevelController extends Controller
{
    public function index(LevelDataTable $dataTable)
    {
        // DB::insert('insert into m_level(level_kode, level_nama, created_at) values(?, ?, ?)', ['CUS', 'Pelangan', now()]);
        // return 'Insert data baru berhasil';

        // $row = DB::update('update m_level set level_nama = ? where level_kode = ?', ['Customer', 'CUS']);
        // return 'Update data berhasil. Jumlah data yang diupload: ' . $row . ' baris';

        // $row = DB::delete('delete from m_level where level_kode = ?', ['CUS']);
        // return 'Delete data berhasil. Jumlah data yang dihapus: ' . $row . ' baris';

        // $data = DB::select('select * from m_level');
        // return view('level', ['data' => $data]);

        return $dataTable->render('level.index');
    }
    public function create()
    {
        return view('level.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'level_kode' => 'bail|required|string|max:10',
            'level_nama' => 'bail|required|string|max:100',
        ]);
        LevelModel::create([
            'level_kode' => $request->level_kode,
            'level_nama' => $request->level_nama,
        ]);
        return redirect('/level');
    }

    public function edit($id)
    {
        $kategori = LevelModel::find($id);
        return view('level.edit', ['data' => $kategori]);
    }

    public function edit_save($id, Request $request)
    {
        $level = LevelModel::find($id);

        $level->level_kode = $request->level_kode;
        $level->level_nama = $request->level_nama;

        $level->save();

        return redirect('/level');
    }

    public function delete($id)
    {
        $level = LevelModel::find($id);
        $level->delete();

        return redirect('/level');
    }
}
