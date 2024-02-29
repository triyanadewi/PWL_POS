<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'kategori_id' => 1,
                'kategori_kode' => 'MAK',
                'kategori_nama' => 'Makanan',
            ],
            [
                'kategori_id' => 2,
                'kategori_kode' => 'MIN',
                'kategori_nama' => 'Minuman',
            ],
            [
                'kategori_id' => 3,
                'kategori_kode' => 'SCR',
                'kategori_nama' => 'Skincare',
            ],
            [
                'kategori_id' => 4,
                'kategori_kode' => 'HCR',
                'kategori_nama' => 'Homecare',
            ],
            [
                'kategori_id' => 5,
                'kategori_kode' => 'ELK',
                'kategori_nama' => 'Elektronik',
            ],
        ];
        DB::table('m_kategori')->insert($data);
    }
}
