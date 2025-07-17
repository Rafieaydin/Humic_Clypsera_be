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
        $faker = \Faker\Factory::create('id_ID');
        $operasi = Operasi::count();
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
                    'kategori_id' => $faker->randomElement([1, 2, 3]),
                    'scope' => 'sendiri',
                    'user_id' => $faker->numberBetween(1, 10), // Assuming user IDs are between 1 and 10
                ],
            ]);
        }

        // Insert additional permohonan with different scope
        for ($i=11; $i <= 20 ; $i++) {
            $random = Str::random(10);
            DB::table('permohonan_data')->insert([
                [
                    'operasi_id' => $faker->numberBetween(1, $operasi),
                    'nama_pemohon' => 'Jane Doe',
                    'nik_pemohon' => $faker->unique()->numerify('##########'),
                    'email_pemohon' => $faker->unique()->safeEmail(),
                    'no_telepon' => '62' . $faker->unique()->numerify('##########'),
                    'status_permohonan' => $faker->randomElement(['Diterima', 'Ditolak', 'Pending']),
                    'alasan_permohonan' => 'Permohonan untukmendapatkan KTP baru.',
                    'kategori_id' => $faker->randomElement([1, 2, 3]),
                    'scope' => 'semua',
                    'user_id' => $faker->numberBetween(1, 10), // Assuming user IDs are between 1 and 10
                ],
            ]);
        }
    }
}
