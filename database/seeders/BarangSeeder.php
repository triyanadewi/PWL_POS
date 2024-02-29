<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'barang_id' => 1,
                'kategori_id' => 1,
                'barang_kode' => 'TLR',
                'barang_nama' => 'Telur',
                'harga_beli' => 8000,
                'harga_jual' => 10000,
            ],
            [
                'barang_id' => 2,
                'kategori_id' => 1,
                'barang_kode' => 'BRS',
                'barang_nama' => 'Beras',
                'harga_beli' => 10000,
                'harga_jual' => 12000,
            ],
            [
                'barang_id' => 3,
                'kategori_id' => 2,
                'barang_kode' => 'SRP',
                'barang_nama' => 'Sirup',
                'harga_beli' => 12500,
                'harga_jual' => 15000,
            ],
            [
                'barang_id' => 4,
                'kategori_id' => 2,
                'barang_kode' => 'SSU',
                'barang_nama' => 'Susu',
                'harga_beli' => 17000,
                'harga_jual' => 19000,
            ],
            [
                'barang_id' => 5,
                'kategori_id' => 3,
                'barang_kode' => 'SSC',
                'barang_nama' => 'Sunscreen',
                'harga_beli' => 30000,
                'harga_jual' => 34500,
            ],
            [
                'barang_id' => 6,
                'kategori_id' => 3,
                'barang_kode' => 'BDK',
                'barang_nama' => 'Bedak',
                'harga_beli' => 27000,
                'harga_jual' => 30000,
            ],
            [
                'barang_id' => 7,
                'kategori_id' => 4,
                'barang_kode' => 'DTJ',
                'barang_nama' => 'Deterjen',
                'harga_beli' => 3500,
                'harga_jual' => 5000,
            ],
            [
                'barang_id' => 8,
                'kategori_id' => 4,
                'barang_kode' => 'PHR',
                'barang_nama' => 'Pengharum Ruangan',
                'harga_beli' => 10000,
                'harga_jual' => 12500,
            ],
            [
                'barang_id' => 9,
                'kategori_id' => 5,
                'barang_kode' => 'LMP',
                'barang_nama' => 'Lampu',
                'harga_beli' => 35000,
                'harga_jual' => 39000,
            ],
            [
                'barang_id' => 10,
                'kategori_id' => 5,
                'barang_kode' => 'TV',
                'barang_nama' => 'Televisi',
                'harga_beli' => 10000,
                'harga_jual' => 12500,
            ],
        ];
        DB::table('m_barang')->insert($data);
    }
}
