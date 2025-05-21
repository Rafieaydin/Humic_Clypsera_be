<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class detail_userSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('detail_user')->insert([
            [
                'user_id' => 1,
                'nik' => '1234567890123456',
                'pekerjaan' => 'Software Engineer',
                'tanggal_lahir' => '1990-01-01',
                'umur' => 33,
                'alamat' => 'Jl. Contoh Alamat No. 1, Jakarta',
                'jenis_kelamin' => 'L',
                'no_telepon' => '081234567890'
            ],
            // [
            //     'user_id' => 2,
            //     'nik' => '6543210987654321',
            //     'pekerjaan' => 'Data Scientist',
            //     'tanggal_lahir' => '1992-02-02',
            //     'umur' => 31,
            //     'alamat' => 'Jl. Contoh Alamat No. 2, Bandung',
            //     'jenis_kelamin' => 'P',
            //     'no_telepon' => '082345678901'
            // ]
        ]);
    }
}
