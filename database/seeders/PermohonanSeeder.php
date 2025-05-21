<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermohonanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('permohonan_data')->insert([
            [
                'operasi_id' => 1,
                'nama_pemohon' => 'John Doe',
                'nik_pemohon' => '1234567890123456',
                'email_pemohon' => 'email@gmail.com',
                'no_telepon' => '081234567890',
                'status_permohonan' => 'pending',
                'alasan_permohonan' => 'Permohonan untuk mendapatkan KTP baru.',
                'kategori_id' => 1,
            ],
        ]);
    }
}
