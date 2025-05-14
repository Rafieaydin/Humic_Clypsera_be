<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OperasiDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('operasi')->insert([
            [
                'pasien_id' => 1,
                'diagnosis_id' => 1,
                'jenis_terapi_id' => 1,
                'jenis_kelainan_cleft_id' => 1,
                'tanggal_operasi' => '2023-10-01',
                'tehnik_operasi' => 'Operasi Bibir Sumbing',
                'lokasi_operasi' => 'RS Cleft Care',
                'foto_sebelum_operasi' => 'foto_sebelum_operasi.jpg',
                'foto_setelah_operasi' => 'foto_setelah_operasi.jpg',
                'follow_up' => 'Follow up 1 bulan setelah operasi',
                'operator_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
