<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DiagnosisSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('diagnosis')->insert([
            [
                'nama_diagnosis' => 'Labioschisis',
                'deskripsi_diagnosis' => 'Kelainan pada bibir yang menyebabkan celah pada bibir.',
            ],
            [
                'nama_diagnosis' => 'Palatoschisis',
                'deskripsi_diagnosis' => 'Kelainan pada langit-langit mulut yang menyebabkan celah pada langit-langit.',
            ],
            [
                'nama_diagnosis' => 'Labiopalatoschisis',
                'deskripsi_diagnosis' => 'Kelainan pada bibir dan langit-langit mulut yang menyebabkan celah pada keduanya.',
            ],
            [
                'nama_diagnosis' => 'Labiognatoschisis',
                'deskripsi_diagnosis' => 'Kelainan pada bibir dan gusi yang menyebabkan celah pada keduanya.',
            ],
            [
                'nama_diagnosis' => 'Palatognatoschisis',
                'deskripsi_diagnosis' => 'Kelainan pada langit-langit mulut dan gusi yang menyebabkan celah pada keduanya.',
            ],
            [
                'nama_diagnosis' => 'Labiopalatoschisis bilateral',
                'deskripsi_diagnosis' => 'Kelainan pada bibir dan langit-langit mulut yang menyebabkan celah pada keduanya secara bilateral.',
            ],
            [
                'nama_diagnosis' => 'Labiopalatoschisis unilateral',
                'deskripsi_diagnosis' => 'Kelainan pada bibir dan langit-langit mulut yang menyebabkan celah pada keduanya secara unilateral.',
            ],
        ]);
    }
}
