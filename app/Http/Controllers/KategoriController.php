<?php

namespace App\Http\Controllers;

use App\DataTables\KategoriDataTable;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index(KategoriDataTable $dataTable)
    {
        return $dataTable->render('kategori.index');
    }

    /**
     * Show the form to create a new post.
     */
    public function create(): View
    {
        return view('kategori.create');
    }

    /**
     * Store a new post
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'kategori_kode' => 'bail|required|min:3|unique:posts|string|max:10',
            'kategori_nama' => 'bail|required|string|max:100',
        ]);

        // The post is valid...

        return redirect('/kategori');
    }
}