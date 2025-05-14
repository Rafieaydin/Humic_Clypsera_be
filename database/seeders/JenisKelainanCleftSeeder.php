<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JenisKelainanCleftSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('jenis_kelainan_cleft')->insert([
            [
                'nama_kelainan' => 'Sindromic Cleft',
                'deskripsi_kelainan' => 'Kelainan pada bibir dan langit-langit yang disebabkan oleh faktor genetik.',
            ],
            [
                'nama_kelainan' => 'Nonsindromic Cleft',
                'deskripsi_kelainan' => 'Kelainan pada bibir dan langit-langit yang tidak disebabkan oleh faktor genetik.',
            ],
        ]);
    }
}
