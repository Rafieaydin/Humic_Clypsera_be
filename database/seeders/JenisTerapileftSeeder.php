<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JenisTerapileftSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('jenis_terapi')->insert([
            [
                'nama_terapi' => 'Labioshisis',
                'deskripsi_terapi' => 'Terapi untuk kelainan pada bibir yang menyebabkan celah pada bibir.',
            ],
            [
                'nama_terapi' => 'Palatoschisis',
                'deskripsi_terapi' => 'Terapi untuk kelainan pada langit-langit mulut yang menyebabkan celah pada langit-langit.',
            ],
            [
                'nama_terapi' => 'Labiopalatoschisis',
                'deskripsi_terapi' => 'Terapi untuk kelainan pada bibir dan langit-langit mulut yang menyebabkan celah pada keduanya.',
            ],
            [
                'nama_terapi' => 'Labiognatoschisis',
                'deskripsi_terapi' => 'Terapi untuk kelainan pada bibir dan gusi yang menyebabkan celah pada keduanya.',
            ],
            [
                'nama_terapi' => 'Palatognatoschisis',
                'deskripsi_terapi' => 'Terapi untuk kelainan pada langit-langit mulut dan gusi yang menyebabkan celah pada keduanya.',
            ],
            [
                'nama_terapi' => 'Labiopalatoschisis bilateral',
                'deskripsi_terapi' => 'Terapi untuk kelainan pada bibir dan langit-langit mulut yang menyebabkan celah pada keduanya secara bilateral.',
            ],
            [
                'nama_terapi' => 'Labiopalatoschisis unilateral',
                'deskripsi_terapi' => 'Terapi untuk kelainan pada bibir dan langit-langit mulut yang menyebabkan celah pada keduanya secara unilateral.',
            ],
        ]);
    }
}
