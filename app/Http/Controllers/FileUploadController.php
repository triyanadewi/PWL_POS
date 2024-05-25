<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FileUploadController extends Controller
{
    public function fileUpload(){
        return view('file-upload');
    }

    public function prosesFileUpload(Request $request){
        // dump($request->berkas);
        // dump($request->file('file'));
        // return "Pemrosesan file upload di sini";

        // if($request->hasFile('berkas')) {
        //     echo "path(): ". $request->berkas->path();
        //     echo "<br>";
        //     echo "extension(): ". $request->berkas->extension();
        //     echo "<br>";
        //     echo "getClientOriginalExtension(): ". $request->berkas->getClientOriginalExtension();
        //     echo "<br>";
        //     echo "getMimeType(): ". $request->berkas->getMimeType();
        //     echo "<br>";
        //     echo "getClientOriginalName(): ". $request->berkas->getClientOriginalName();
        //     echo "<br>";
        //     echo "getSize(): ".$request->berkas->getSize();
        // } else {
        //     echo "Tidak ada berkas yang diupload";
        // }

        $request->validate([
            'berkas'=>'required|file|image|max:500']);
            $extfile = $request->berkas->getClientOriginalName();
            $namaFile = 'web-' . time() . "." . $extfile;

            $path = $request->berkas->move('gambar', $namaFile);
            $path = str_replace("\\","//", $path);
            echo "Variabel path berisi : $path <br>";

            $pathBaru = asset('gambar/' . $namaFile);
            echo "proses upload berhasil, data disimpan pada : $path";
            echo "<br>";
            echo "Tampilkan link: <a href='$pathBaru'>$pathBaru</a>";
    }

    public function fileUploadRename(){
        return view('file-upload-rename');
    }

    public function prosesFileUploadRename(Request $request)
    {
        $request->validate([
            'nama_gambar' => 'required|alpha_dash',
            'berkas' => 'required|file|image|max:500'
        ]);

        $extfile = $request->berkas->getClientOriginalExtension();
        $namaFile = $request->nama_gambar . '.' . $extfile;
        $path = $request->berkas->move('gambar', $namaFile);
        $path = str_replace("\\", "//", $path);

        echo "Gambar berhasil diupload ke <a href='$path'>$namaFile</a>";
        echo "<br>";
        echo "<img src='$path' alt='Uploaded Image'>";
    }
}
