<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\FileUploadController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\StokController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get( '/', [WelcomeController::class, 'index']);

Route::group(['prefix' => 'user'], function(){
    Route::get('/', [UserController::class, 'index']);          //menampilkan halaman awal user
    Route::post('/list', [UserController::class,'list']);       //menampilkan data user dalam bentuk json untuk datatables
    Route::get('/create', [UserController::class,'create']);    //menampilkan halaman form tambah user
    Route::post('/', [UserController::class,'store']);          //menyimpan data user baru  
    Route::get('/{id}', [UserController::class,'show']);        //menampilkan detail user
    Route::get('/{id}/edit', [UserController::class,'edit']);   //menampilkan halaman form edit user
    Route::put('/{id}', [UserController::class,'update']);      //menyimpan perubahan data user
    Route::delete('/{id}', [UserController::class,'destroy']);  //menghapus data user
});

Route::group(['prefix' => 'level'], function(){
    Route::get('/', [LevelController::class, 'index']);          //menampilkan halaman awal level user
    Route::post('/list', [LevelController::class,'list']);       //menampilkan data level user dalam bentuk json untuk datatables
    Route::get('/create', [LevelController::class,'create']);    //menampilkan halaman form tambah level user
    Route::post('/', [LevelController::class,'store']);          //menyimpan data level user baru  
    Route::get('/{id}', [LevelController::class,'show']);        //menampilkan detail level user
    Route::get('/{id}/edit', [LevelController::class,'edit']);   //menampilkan halaman form edit level user
    Route::put('/{id}', [LevelController::class,'update']);      //menyimpan perubahan data level user
    Route::delete('/{id}', [LevelController::class,'destroy']);  //menghapus data level user
});

Route::group(['prefix' => 'kategori'], function(){
    Route::get('/', [KategoriController::class, 'index']);          //menampilkan halaman awal kategori
    Route::post('/list', [KategoriController::class,'list']);       //menampilkan data kategori dalam bentuk json untuk datatables
    Route::get('/create', [KategoriController::class,'create']);    //menampilkan halaman form tambah kategori
    Route::post('/', [KategoriController::class,'store']);          //menyimpan data kategori baru  
    Route::get('/{id}', [KategoriController::class,'show']);        //menampilkan detail kategori
    Route::get('/{id}/edit', [KategoriController::class,'edit']);   //menampilkan halaman form edit kategori
    Route::put('/{id}', [KategoriController::class,'update']);      //menyimpan perubahan data kategori
    Route::delete('/{id}', [KategoriController::class,'destroy']);  //menghapus data kategori
});

Route::group(['prefix' => 'barang'], function(){
    Route::get('/', [BarangController::class, 'index']);          //menampilkan halaman awal barang
    Route::post('/list', [BarangController::class,'list']);       //menampilkan data barang dalam bentuk json untuk datatables
    Route::get('/create', [BarangController::class,'create']);    //menampilkan halaman form tambah barang
    Route::post('/', [BarangController::class,'store']);          //menyimpan data barang baru  
    Route::get('/{id}', [BarangController::class,'show']);        //menampilkan detail barang
    Route::get('/{id}/edit', [BarangController::class,'edit']);   //menampilkan halaman form edit barang
    Route::put('/{id}', [BarangController::class,'update']);      //menyimpan perubahan data barang
    Route::delete('/{id}', [BarangController::class,'destroy']);  //menghapus data barang
});

Route::group(['prefix' => 'stok'], function(){
    Route::get('/', [StokController::class, 'index']);          //menampilkan halaman awal stok
    Route::post('/list', [StokController::class,'list']);       //menampilkan data stok dalam bentuk json untuk datatables
    Route::get('/create', [StokController::class,'create']);    //menampilkan halaman form tambah stok
    Route::post('/', [StokController::class,'store']);          //menyimpan data stok baru  
    Route::get('/{id}', [StokController::class,'show']);        //menampilkan detail stok
    Route::get('/{id}/edit', [StokController::class,'edit']);   //menampilkan halaman form edit stok
    Route::put('/{id}', [StokController::class,'update']);      //menyimpan perubahan data stok
    Route::delete('/{id}', [StokController::class,'destroy']);  //menghapus data stok
});

Route::group(['prefix' => 'penjualan'], function(){
    Route::get('/', [PenjualanController::class, 'index']);          //menampilkan halaman awal penjualan
    Route::post('/list', [PenjualanController::class,'list']);       //menampilkan data penjualan dalam bentuk json untuk datatables
    Route::get('/create', [PenjualanController::class,'create']);    //menampilkan halaman form tambah penjualan
    Route::post('/', [PenjualanController::class,'store']);          //menyimpan data penjualan baru  
    Route::get('/{id}', [PenjualanController::class,'show']);        //menampilkan detail penjualan
    Route::get('/{id}/edit', [PenjualanController::class,'edit']);   //menampilkan halaman form edit penjualan
    Route::put('/{id}', [PenjualanController::class,'update']);      //menyimpan perubahan data penjualan
    Route::delete('/{id}', [PenjualanController::class,'destroy']);  //menghapus data penjualan
});

Route::get('login', [AuthController::class, 'index'])->name('login');
Route::get('register', [AuthController::class, 'register'])->name('register');
Route::post('proses_login', [AuthController::class, 'proses_login'])->name('proses_login');
Route::get('logout', [AuthController::class,'logout'])->name('logout');
Route::post('proses_register', [AuthController::class, 'proses_register'])->name('proses_register');

// kita atur juga untuk middleware menggunakan group pada routing
// didalamnya terdapat group untuk mengecek kondisi login
// jika user yang login merupakan admin maka akan diarahkan ke AdminController
// jika user yang login merupakan manager maka akan diarahkan ke UserController

Route::group(['middleware' => ['auth']], function() {

    Route::group(['middleware' => ['cek_login:1']], function() {
        Route::resource('admin', AdminController::class);
    });
    Route::group(['middleware' => ['cek_login:2']], function() {
        Route::resource('manager', ManagerController::class);
    });
});

Route::get('/', function () {
    return view('welcome');
});
Route::get('/file-upload',[FileUploadController::class,'fileupload']);
Route::post('/file-upload',[FileUploadController::class,'prosesFileUpload']);