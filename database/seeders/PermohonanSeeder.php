<?php

namespace Database\Seeders;

use App\Models\Operasi;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PermohonanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create();
        for ($i=1; $i <= 10 ; $i++) {
            $random = Str::random(10);
            DB::table('permohonan_data')->insert([
                [
                    'operasi_id' => $i,
                    'nama_pemohon' => 'John Doe',
                    'nik_pemohon' => $faker->unique()->numerify('##########'), // generate NIK
                    'email_pemohon' => "email-$i-$random@gmail.com",
                    'no_telepon' => '62' . $faker->unique()->numerify('##########'),
                    'status_permohonan' => $faker->randomElement(['Diterima', 'Ditolak', 'Pending']),
                    'alasan_permohonan' => 'Permohonan untuk mendapatkan KTP baru.',
                    'kategori_id' => $faker->randomElement([1, 2, 3, 4]),
                ],
            ]);
        }
    }
}
