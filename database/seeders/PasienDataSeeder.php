<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PasienDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('pasien')->insert([
            [
                'nama_pasien' => 'John Doe',
                'tanggal_lahir' => '2020-01-01',
                'umur_pasien' => 3,
                'jenis_kelamin' => 'L',
                'alamat_pasien' => 'Jl. Kebon Jeruk No. 1, Jakarta',
                'no_telepon' => '081234567890',
                'pasien_anak_ke_berapa' => 1,
                'kelainan_kotigental' => 'Tidak ada',
                'riwayat_kehamilan' => 'Sehat',
                'riwayat_keluarga_pasien' => 'Tidak ada',
                'riwayat_kawin_berabat' => 'Tidak ada',
                'riwayat_terdahulu' => 'Tidak ada',
                'operator_id' => 1,
                'operasi_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),

            ]
        ]);
    }
}
