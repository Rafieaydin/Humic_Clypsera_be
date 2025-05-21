<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriPermohonanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('kategori_peromohonan')->insert([
            [
                'kategori' => 'KTP',
            ],
            [
                'kategori' => 'KK',
            ],
            [
                'kategori' => 'Akta Kelahiran',
            ],
            [
                'kategori' => 'Akta Kematian',
            ],
        ]);
    }
}
